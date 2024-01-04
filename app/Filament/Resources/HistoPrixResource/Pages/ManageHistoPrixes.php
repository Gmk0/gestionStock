<?php

namespace App\Filament\Resources\HistoPrixResource\Pages;

use App\Filament\Resources\HistoPrixResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageHistoPrixes extends ManageRecords
{
    protected static string $resource = HistoPrixResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
