<div class="space-y-10">
    <h1 class="text-center text-5xl">{{$tableTitle}}</h1> 

    {{-- Search and create --}}
    <div class="md:flex md:justify-between md:items-center text-sm">
        <x-mary-input label={{$labelSearch}} inline wire:model='search' class="md:max-w-[400px]">
            <x-slot:append>
                <x-mary-button wire:click='updateSearch' label="Buscar" icon="o-check" class="btn-primary rounded-s-none h-full" />
            </x-slot:append>
        </x-mary-input>
        <x-mary-button icon="o-plus-circle" label='Añadir nuevo' wire:click="togglePanelCreate()" spinner class="btn-sm" />
    </div>
    
    {{-- Table --}}
    <x-mary-table :headers='$headers' :rows='$rows' with-pagination spinner>
        @scope('actions', $row)
            <div class="flex space-x-2">
                <x-mary-button icon="o-pencil" wire:click="togglePanelUpdate({{$row->id}})"  spinner class="btn-sm" />
                <x-mary-button icon="o-trash"  spinner class="btn-sm" />
            </div>
        @endscope
    </x-mary-table>

    {{-- create form --}}
    <x-mary-drawer wire:model="showFormCreate" class="w-11/12 lg:w-1/3" right>
        @livewire('generic-form',['headers' => $headers, 'model'=>$model, 'errors'=>$errors])
    </x-mary-drawer>

    {{-- update form --}}
    <x-mary-drawer wire:model="showForm" class="w-11/12 lg:w-1/3" right>
        @livewire('generic-form',['headers' => $headers, 'model'=>$model, 'errors'=>$errors, 'isUpdate'=>true])
    </x-mary-drawer>
</div>
