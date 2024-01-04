<?php

namespace App\Filament\Resources\AchatResource\Widgets;

use App\Filament\Resources\AchatResource\Pages\ListAchats;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\Concerns\InteractsWithPageTable;

class AchatOverview extends BaseWidget
{
    use InteractsWithPageTable;

    protected function getTablePage(): string
    {
        return ListAchats::class;
    }
    protected function getStats(): array
    {
        return [
            Stat::make('Total Commande', number_format($this->getPageTableQuery()->sum('montant')) . ' CDF'),
            //
        ];
    }
}
