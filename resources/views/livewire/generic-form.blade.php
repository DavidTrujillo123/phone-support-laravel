<div class="space-y-2">
    <x-mary-toast />
    <h2 class="text-2xl">{{$text['title']}}</h2>
    <x-mary-form wire:submit.prevent="save" >
        @foreach ($fields as $key => $value)
            <x-mary-input 
                :label="$labels[$key]" 
                :type="$typeInputs[$key]"
                wire:model="fields.{{ $key }}" 
                :key="$key"
                wire:change='removeErrors()'
            />
        @endforeach
        <x-slot:actions>
            <x-mary-button label='Cerrar' wire:click={{$closeForm}}  />
            <x-mary-button label="{{$text['textBtn']}}" class="btn-primary" type="submit" spinner="save" />
        </x-slot:actions>
    </x-mary-form>
    {{-- special $paren: is a feature of livewire to use funcions of parents in childs components --}}
</div>
