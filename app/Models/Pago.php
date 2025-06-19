<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_usuario', 'id_membresia', 'id_clase', 'monto', 'fecha'
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }

    public function membresia()
    {
        return $this->belongsTo(Membresia::class, 'id_membresia');
    }

    public function clase()
    {
        return $this->belongsTo(Clase::class, 'id_clase');
    }
}
