<x-filament-panels::page>


<form wire:submit.prevent='save'>

   {{$this->form}}


   <div style="margin:20px 0;">

    <x-filament::button type="submit" icon="heroicon-m-plus">
        Ajouter
    </x-filament::button>


    <div class="flex flex-col">
        <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full py-2 sm:px-6 lg:px-8">
                <div class="overflow-hidden">
                    <table class="min-w-full text-sm font-light text-left">
                        <thead class="font-medium border-b dark:border-neutral-500">
                            <tr>
                                <th scope="col" class="px-6 py-4">#</th>
                                <th scope="col" class="px-6 py-4">PRODUIT</th>
                                <th scope="col" class="px-6 py-4">Qte</th>
                                <th scope="col" class="px-6 py-4">Montant</th>
                                <th scope="col" class="px-6 py-4">Benefice</th>
                                <th scope="col" class="px-6 py-4">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($ventes as $key=>$value )

                            @php
                                $number=$key+1;
                            @endphp
                            <tr class="border-b dark:border-neutral-500">
                            <td class="px-6 py-4 font-medium whitespace-nowrap">{{$number}}</td>
                            <td class="px-6 py-4 font-medium whitespace-nowrap">{{$value['product_name']}}</td>
                            <td class="px-6 py-4 font-medium whitespace-nowrap">{{$value['qte_pqt']}}</td>
                            <td class="px-6 py-4 font-medium whitespace-nowrap">{{$value['montant']}}</td>
                            <td class="px-6 py-4 font-medium whitespace-nowrap">{{$value['benefice']}}</td>
                            <td class="px-6 py-4 font-medium whitespace-nowrap">{{$value['date_vente']}}</td>




                            </tr>

                            @empty

                            @endforelse


                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>




    <div class="flex items-center justify-center mt-4">
    <x-filament::button
    icon="heroicon-m-plus"

     wire:click='validation'>
Valider
    </x-filament::button>
    </div>
</div>
</form>



</x-filament-panels::page>
