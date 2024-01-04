<?php

namespace App\Filament\Widgets;

use App\Models\Achat;
use App\Models\vente;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class CommandeView extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total commande', number_format(Achat::all()->sum('montant')).' CDF'),
            Stat::make('Total Ventes', number_format(vente::all()->sum('montant')).'CDF'),
            
        ];
    }
}
