<?php

namespace App\Filament\Widgets;

use App\Models\vente;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class ChartView extends ChartWidget
{
    protected static ?string $heading = 'Chart';
    protected int | string | array $columnSpan = 2;
    protected static ?int $sort=3;

    protected function getFilters(): ?array
    {
        return [
            'today' => 'Aujourdhui',
            'week' => 'Semaine dernier',
            'month' => 'Mois dernier',
            'year' => 'Cette annee',
        ];
    }

    protected function getData(): array
    {
        $data = Trend::model(vente::class)
            ->between(
                start: now()->startOfYear(),
                end: now()->endOfYear(),
            )
            ->perMonth()
            ->sum('montant');

        return [
            'datasets' => [
                [
                    'label' => 'Vente',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                ],
            ],
            'labels' => $data->map(fn (TrendValue $value) => $value->date),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
