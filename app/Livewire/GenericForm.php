<?php

namespace App\Livewire;

use App\Models\Client;
use Livewire\Attributes\On;
use Livewire\Component;

class GenericForm extends Component
{
    public $model;
    public $errors = [];
    public $obj = null;
    public $fields = [];
    public $labels = [];
    public $text = ['title' => '', 'textBtn' => ''];

    //Get element when event trigger
    #[On('passId')]
    public function loadId($id){        
        $this->obj = $this->model->find($id)->first();
        
        //fill inputs
        foreach ($this->fields as $key => $value) {
            $this->fields[$key] = $this->obj->{$key};
        }
        $this->text['title'] = 'Actualización';
        $this->text['textBtn'] = 'Actualizar';
    }
    #[On('clearObj')]
    public function clearObj(){
        $this->text['title'] = 'Crear nuevo';
        $this->text['textBtn'] = 'Guardar';
        $this->initInputs();
    }

    public function mount($model, $headers){
        $this->text['title'] = 'Crear nuevo';
        $this->text['textBtn'] = 'Guardar';
        $this->model = $model;
        $this->initInputs();

        //init labels
        foreach ($this->fields as $key => $value) {
            $label = collect($headers)->firstWhere('key', $key)['label'] ?? $key;
            $this->labels[$key] = $label;
        }
    }
    private function initInputs(){
        $fillable = $this->model->getFillable();

        //init inputs
        foreach ($fillable as $key) {
            $this->fields[$key] = '';
        }
    }

    public function save(){
        $this->obj->update($this->fields);
    }

    public function render()
    {
        return view('livewire.generic-form');
    }
}
