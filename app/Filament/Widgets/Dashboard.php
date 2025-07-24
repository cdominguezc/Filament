<?php

namespace App\Filament\Widgets;

use App\Models\Categoria;
use App\Models\Movimiento;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\User;




class Dashboard extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            //

                Stat::make('Usuarios', User::count())
                ->description('Total de usuarios registrados')
                ->icon('heroicon-o-users')
                ->color('success')
                ->chart([1, 2, 3, 4, 5, 6, 7, 8, 9, 10]),

                Stat::make('Categorias', Categoria::count())
                ->description('Total de movimientos registrados')
                ->icon('heroicon-o-briefcase')
                ->color('primary')
                ->chart([1, 5, 10, 15]),

                Stat::make('Movimientos', Movimiento::where('tipo', 'ingreso')->sum('monto').' $')
                ->description('Total de movimientos registrados')
                ->icon('heroicon-o-currency-dollar')
                ->color('danger')
                ->chart([1, 5, 3, 4, 15, 6, 7, 18, 9, 10]),   
       
        ];  
    }   
}
