<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asistencia extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_clase', 'id_usuario', 'id_profesor', 'id_membresia'
    ];

    public function clase()
    {
        return $this->belongsTo(Clase::class, 'id_clase');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }

    public function profesor()
    {
        return $this->belongsTo(User::class, 'id_profesor')->where('rol', 'profesor');
    }

    public function membresia()
    {
        return $this->belongsTo(Membresia::class, 'id_membresia');
    }
}

