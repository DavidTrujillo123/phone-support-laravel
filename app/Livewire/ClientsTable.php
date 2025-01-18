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
        ['key' => 'id', 'label' => '#', 'type' => 'text'],
        ['key' => 'ci', 'label' => 'CI', 'type' => 'text'],
        ['key' => 'name', 'label' => 'Nombre', 'type' => 'text'],
        ['key' => 'surname', 'label' => 'Apellido', 'type' => 'text'],
        ['key' => 'email', 'label' => 'Email', 'type' => 'email'],

    ];
    public $errors = [
        'rulesUpdate' => [
            'ci' => 'required|string|max:20',
            'email' => 'required|email',
            'name' => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/u',
            'surname' => 'required|string|max:255',
        ],
        'rules' => [
            'ci' => 'required|string|max:20|unique:clients,ci',
            'email' => 'required|email|unique:clients,email',
            'name' => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/u',
            'surname' => 'required|string|max:255',
        ],
        'messages' => [
            'ci.required' => 'Cedula es obligatorio.',
            'ci.unique' =>'La cedula ya esta registrada',
            'ci.max' => 'El campo CI no puede tener más de :max caracteres.',
            'email.required' => 'El campo email es obligatorio.',
            'email.unique'=>'El email ya esta registrado',
            'email.email' => 'El campo email debe ser una dirección válida.',
            'name.required' => 'El campo nombre es obligatorio.',
            'name.regex' => 'El campo nombre solo debe contener letras.',
            'surname.required' => 'El campo apellido es obligatorio.',
        ]
    ];

    public function render()
    {
        return view('livewire.clients-table');
    }
}
