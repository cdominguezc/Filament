<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Movimiento;

class IngresosChat extends ChartWidget
{
    protected static ?string $heading = 'Reporte de movimientos de ingresos';

    protected function getData(): array
    {
        $data = Movimiento::where('tipo', 'ingreso')
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
                    'label' => 'Ingresos',
                    'data' => $totalRevenue,
                    'backgroundColor' => '#4CAF50',
                    'borderColor' =>  '#4CAF50',
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
