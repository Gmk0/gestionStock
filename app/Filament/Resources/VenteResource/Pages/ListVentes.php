<?php

namespace App\Filament\Resources\VenteResource\Pages;

use App\Filament\Resources\VenteResource;
use App\Filament\Resources\VenteResource\Widgets\VenteOverview;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListVentes extends ListRecords
{
    protected static string $resource = VenteResource::class;

    

    protected function getHeaderWidgets(): array
    {
        return [
            VenteOverview::class,
        ];
    }

}
