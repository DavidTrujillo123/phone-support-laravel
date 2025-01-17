<div class="space-y-2">
    <h2 class="text-2xl">{{$text['title']}}</h2>
    <x-mary-form wire:submit="save">
        @foreach ($fields as $key => $value)
            <x-mary-input :label="$labels[$key]" wire:model="fields.{{ $key }}" />
        @endforeach
        <x-slot:actions>
            <x-mary-button label="{{$text['textBtn']}}" wire:click='save' class="btn-primary" type="submit" spinner="save" />
        </x-slot:actions>
    </x-mary-form>


</div>
