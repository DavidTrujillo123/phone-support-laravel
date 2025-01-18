<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\On;
use Livewire\Component;
use Mary\Traits\Toast;

class GenericForm extends Component
{
    use Toast;
    public $model;
    public $errors = [];
    public $obj = null;
    public $fields = [];
    public $labels = [];
    public $typeInputs = [];
    public $text = ['title' => '', 'textBtn' => ''];
    public $closeForm;
    public $isUpdate = false;

    //Get element when event trigger
    #[On('passId')]
    public function loadId($id)
    {
        $this->obj = $this->model->find($id)->first();

        //fill inputs
        foreach ($this->fields as $key => $value) {
            $this->fields[$key] = $this->obj->{$key};
        }

        $this->resetValidation();
    }
    #[On('clearObj')]
    public function clearObj()
    {
        $this->initInputs();
    }

    public function removeErrors(){
        $this->resetValidation();
    }

    public function mount($model, $headers, $errors, $isUpdate = false)
    {
        $this->model = $model;
        $this->errors = $errors;
        $this->isUpdate = $isUpdate;
        $this->initInputs();

        //init labels
        foreach ($this->fields as $key => $value) {
            $label = collect($headers)->firstWhere('key', $key)['label'] ?? $key;
            $input = collect($headers)->firstWhere('key', $key)['type'] ?? $key;
            $this->labels[$key] = $label;
            $this->typeInputs[$key] = $input;
        }

        if ($isUpdate) {
            $this->text['title'] = 'Actualización';
            $this->text['textBtn'] = 'Actualizar';
            $this->closeForm = '$parent.togglePanelUpdate()';
        } else {
            $this->text['title'] = 'Crear nuevo';
            $this->text['textBtn'] = 'Crear';
            $this->closeForm = '$parent.togglePanelCreate()';
        }
    }
    public function save()
    {
        if($this->isUpdate){
            $this->update();
        }
        else{
            $this->create();
        }
    }

    public function render()
    {
        return view('livewire.generic-form');
    }
    private function initInputs()
    {
        $fillable = $this->model->getFillable();

        //init inputs
        foreach ($fillable as $key) {
            $this->fields[$key] = '';
        }
    }
    private function generalValidator(array $rules, array $messages, array $data): array
    {
        $validator = Validator::make($data, $rules, $messages);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        return $validator->validated();
    }
    private function  create(){
        try {
            $validatedData = $this->generalValidator(
                $this->errors['rules'],
                $this->errors['messages'],
                $this->fields
            );
            
            $validatedData = $this->clearWhiteSpace($validatedData);

            $this->model::create($validatedData);
            $this->success('Cliente creado correctamente');
            $this->initInputs();
        } catch (ValidationException $e) {
            foreach ($e->validator->errors()->messages() as $key => $messages) {
                $this->addError("fields.$key", $messages[0]);
            }
        } 
        catch (\Throwable $th) {
            $this->error('Error inesperado!');
            //throw $th;
        }
    }
    private function update(){
        try {
            $validatedData = $this->generalValidator(
                $this->errors['rulesUpdate'],
                $this->errors['messages'],
                $this->fields
            );
        
            $validatedData = $this->clearWhiteSpace($validatedData);

            $fillable = $this->model->getFillable();
            $hasDataChange = $this->obj->only($fillable) != $validatedData;

            if($hasDataChange){
                $this->obj->update($validatedData);
                $this->success('Cliente actualizado correctamente');
                //Event -> Consume in reload data method in GenericTable
                $this->dispatch('reloadData');
            }
            
        } catch (ValidationException $e) {
            foreach ($e->validator->errors()->messages() as $key => $messages) {
                $this->addError("fields.$key", $messages[0]);
            }
        } 
        catch (\Throwable $th) {
            //throw $th;
            $this->error('Error inesperado!');
        }
    }
    private function clearWhiteSpace($data){
        foreach ($data as $key => $value) {
            if (is_string($value)) {
                $data[$key] = trim($value);
            }
        }
        return $data;
    }
}
