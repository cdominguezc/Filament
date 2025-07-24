<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Movimiento extends Model
{
    //
    protected $fillable = [
        'user_id',
        'categoria_id',
        'tipo',
        'monto',
        'descripcion',
        'foto',
        'fecha',
    ];
    //Relaciones muchos a uno con el modelo User
    public function user()
    {
        return $this->belongsTo(User::class);   

    }
    //Relaciones muchos a uno con el modelo Categoria
    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    protected static function booted()
    {
        static::created(function ($movimiento) {
            if ($movimiento->tipo === 'gasto') {
                // Si es un gasto, decrementamos el monto del presupuesto del usuario
                $presupuesto = Presupuesto::where('user_id', $movimiento->user_id)
                    ->where('categoria_id', $movimiento->categoria_id)
                    ->where('mes', now()->format('F'))
                    ->where('anio', now()->year)
                    ->first();

                if ($presupuesto) {
                    $presupuesto->monto_gastado += $movimiento->monto;
                    $presupuesto->save();       

           } 
        }
        });
    

    }
}   

