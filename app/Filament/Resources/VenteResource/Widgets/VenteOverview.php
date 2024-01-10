<?php

namespace App\Filament\Resources\VenteResource\Widgets;

use App\Filament\Resources\VenteResource\Pages\ListVentes;
use App\Models\vente;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\Concerns\InteractsWithPageTable;

class VenteOverview extends BaseWidget
{




    protected function getStats(): array
    {
        return [
            Stat::make('Total ventes', number_format(vente::all()->sum('montant')).' CDF'),
            Stat::make('Total Benefices', number_format(vente::all()->sum('benefice')) . ' CDF'),
            Stat::make('Total Paquets', number_format(vente::all()->sum('qte_pqt')) . ' PQT'),
            //
        ];
    }
}
