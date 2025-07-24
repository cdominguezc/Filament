<?php

namespace App\Filament\Widgets;

use App\Models\Movimiento;
use Filament\Widgets\ChartWidget;

class GastosChart extends ChartWidget
{
    protected static ?string $heading = 'Reporte de movimientos de gastos';

    protected function getData(): array
    {

         $data = Movimiento::where('tipo', 'gasto')
            ->selectRaw('MONTH(fecha) as mes, SUM(monto) as total')
            ->groupBy('mes')
            ->orderBy('mes')
            ->get();

        $meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
        $totalRevenue = array_fill(0, 12, 0);

        foreach ($data as $item) {
            $totalRevenue[$item->mes - 1] = $item->total;
        }

        return [
            //
            'datasets' => [
                [
                    'label' => 'Gastos',
                    'data' => $totalRevenue ,
                    'backgroundColor' => '#F44336',
                    'borderColor' => '#F44336',
                    'fill' => false,
                ],
            ],
            'labels' => $meses,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
