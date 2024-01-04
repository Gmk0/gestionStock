<x-filament-panels::page>


<form wire:submit.prevent='save'>

   {{$this->form}}


   <div style="margin:20px 0;">

   <x-filament::button type="submit">
    Enregistrer
</x-filament::button>
</div>
</form>



</x-filament-panels::page>
