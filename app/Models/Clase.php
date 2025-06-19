<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clase extends Model
{
    use HasFactory;

    protected $fillable = [
        'fecha', 'id_profesor', 'tipo', 'lugares', 'lugares_ocupados', 'lugares_disponibles'
    ];

    public function profesor()
    {
        return $this->belongsTo(User::class, 'id_profesor')->where('rol', 'profesor');
    }

    public function asistencias()
    {
        return $this->hasMany(Asistencia::class, 'id_clase');
    }

    public function pagos()
    {
        return $this->hasMany(Pago::class, 'id_clase');
    }
}

