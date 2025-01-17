<div class="p-5 space-y-10">
    @livewire('generic-table', [
        'tableTitle' => 'Clientes',
        'headers' => $headers,
        'model' => $model,
        'searchObj' => ['label' => 'Apellido', 'value' =>'surname']
    ])
</div>
