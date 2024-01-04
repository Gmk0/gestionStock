<?php

namespace App\Filament\Resources\VenteResource\Pages;

use App\Filament\Resources\VenteResource;
use Filament\Resources\Pages\Page;

class AjoutVente extends Page
{
    protected static string $resource = VenteResource::class;

    protected static string $view = 'filament.resources.vente-resource.pages.ajout-vente';

    public function mount(): void
    {
        static::authorizeResourceAccess();
    }
}
