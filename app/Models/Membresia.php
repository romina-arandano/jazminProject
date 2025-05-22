<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Membresia extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_usuario',
        'clases_adquiridas',
        'clases_disponibles',
        'clases_ocupadas',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }
}
