<?php

namespace App\Filament\Resources\AchatResource\Widgets;

use App\Filament\Resources\AchatResource\Pages\ListAchats;
use App\Models\Achat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\Concerns\InteractsWithPageTable;

class AchatOverview extends BaseWidget
{
    
    protected function getStats(): array
    {
        return [
            Stat::make('Total Commande', number_format(Achat::all()->sum('montant')) . ' CDF'),
            //
        ];
    }
}
