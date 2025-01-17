<div class="space-y-10">
    <h1 class="text-center text-5xl">{{$tableTitle}}</h1>
    <div class="max-w-[400px]">
        <x-mary-input label={{$labelSearch}} wire:model='search'>
            <x-slot:append>
                <x-mary-button wire:click='updateSearch' label="Buscar" icon="o-check" class="btn-primary rounded-s-none" />
            </x-slot:append>
        </x-mary-input>
        <x-mary-button icon="o-trash" wire:click="togglePanelCreate()" spinner class="btn-sm" />
    </div>
    
    <x-mary-table :headers='$headers' :rows='$rows' with-pagination spinner>
        @scope('actions', $row)
            <div class="flex space-x-2">
                <x-mary-button icon="o-pencil" wire:click="togglePanelUpdate({{$row->id}})"  spinner class="btn-sm" />
                <x-mary-button icon="o-trash"  spinner class="btn-sm" />
            </div>
        @endscope
    </x-mary-table>

    <x-mary-drawer wire:model="showFormCreate" class="w-11/12 lg:w-1/3" right>
        <x-mary-button class="mb-5 rounded-full" icon='o-x-mark' @click="$wire.showFormCreate = false" />
        @livewire('generic-form',['headers' => $headers, 'model'=>$model])
    </x-mary-drawer>

    {{-- Form to update --}}
    <x-mary-drawer wire:model="showForm" class="w-11/12 lg:w-1/3" right>
        <x-mary-button class="mb-5 rounded-full" icon='o-x-mark' @click="$wire.showForm = false" />
        @livewire('generic-form',['headers' => $headers, 'model'=>$model])
    </x-mary-drawer>
</div>
