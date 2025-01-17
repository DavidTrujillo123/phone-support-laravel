<?php

namespace App\Livewire;

use Illuminate\Database\Eloquent\Model;
use Livewire\Component;
use Livewire\WithPagination;

class GenericTable extends Component
{
    use WithPagination;

    public $tableTitle;
    public $headers;
    //Type: string returns /App/Model/
    public $model;
    public $labelSearch;
    public $searchParam;
    public $search = '';

    public $objId;
    public $showForm = false;
    public $showFormCreate = false;
    
    public function mount($tableTitle, $headers, $model, $searchObj){
        $this->tableTitle = $tableTitle;
        $this->headers = $headers;
        $this->model = new $model;
        $this->searchParam = $searchObj['value'];
        $this->labelSearch = $searchObj['label'];
    }

    public function updateSearch(){
        $this->resetPage();
        $this->search = trim($this->search);
    }

    public function findById($id){
        dd($id);
    }

    function togglePanelCreate(){
        $this->showFormCreate = !$this->showFormCreate;
        if($this->objId){
            $this->objId = '';
            $this->dispatch('clearObj');
        }
    }

    public function togglePanelUpdate($id){
        $this->objId = $id;
        $this->showForm =!$this->showForm;

        //Emit event when change id
        //Used to pass ids in forms
        $this->dispatch('passId', ['id' => $id]);

    }
    

    public function render()
    {
        $query = $this->model::query();

        if (!empty($this->search)) {
            $query->where($this->searchParam, 'LIKE', '%'.$this->search.'%');
        }

        $rows = $query->paginate(5);
        
        return view('livewire.generic-table',[
            'rows' => $rows,
        ]);
    }
}
