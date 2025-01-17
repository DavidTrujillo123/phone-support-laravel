<?php

namespace App\Livewire;

use App\Models\Client;
use Livewire\Component;
use Livewire\WithPagination;

class ClientsTable extends Component
{
    use WithPagination;

    public $model = Client::class;
    public $headers = [
        ['key' => 'id', 'label' => '#'],
        ['key' => 'ci', 'label' => 'CI'],
        ['key' => 'name', 'label' => 'Nombre'],
        ['key' => 'surname', 'label' => 'Apellido'],
        ['key' => 'email', 'label' => 'Email'],

    ];
    
    public function render()
    {
        return view('livewire.clients-table');
    }
}
