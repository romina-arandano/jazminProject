<?php

namespace App\Http\Controllers;

use App\Models\Membresia;
use Illuminate\Http\Request;

class MembresiaController extends Controller
{
    public function index()
    {
        return Membresia::all();
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_usuario' => 'required|exists:users,id',
            'clases_adquiridas' => 'required|integer',
            'clases_disponibles' => 'required|integer',
            'clases_ocupadas' => 'required|integer',
        ]);

        $membresia = Membresia::create($request->all());

        return response()->json([
            'status' => 'ok',
            'mensaje' => 'Membresía creada correctamente',
            'data' => $membresia
        ], 201); // Código HTTP 201: creado
    }

    public function show($id)
    {
        return Membresia::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $membresia = Membresia::findOrFail($id);
        $membresia->update($request->all());

        return $membresia;
    }

    public function destroy($id)
    {
        $membresia = Membresia::find($id);

        if (!$membresia) {
            return response()->json([
                'status' => 'error',
                'mensaje' => 'Membresía no encontrada',
            ], 404); // Código HTTP 404: no encontrado
        }

        $membresia->delete();

        return response()->json([
            'status' => 'ok',
            'mensaje' => 'Membresía eliminada correctamente',
            'id_eliminado' => $id
        ], 200); // Código HTTP 200: OK
    }

}

