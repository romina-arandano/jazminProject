<?php

namespace App\Http\Controllers;

use App\Models\Membresia;
use Illuminate\Http\Request;

class MembresiaController extends Controller
{
    public function index()
    {
        // Trae membresías junto con su usuario (Eager loading)
        $membresias = Membresia::with('user')->get();

        // Mapea para incluir sólo el nombre como 'cliente'
        $data = $membresias->map(function ($membresia) {
            return [
                'id' => $membresia->id,
                'id_usuario' => $membresia->id_usuario,
                'cliente' => $membresia->user->name ?? 'N/A',
                'clases_adquiridas' => $membresia->clases_adquiridas,
                'clases_disponibles' => $membresia->clases_disponibles,
                'clases_ocupadas' => $membresia->clases_ocupadas,
                'created_at' => $membresia->created_at,
                'updated_at' => $membresia->updated_at,
            ];
        });

        return response()->json([
            'status' => 'ok',
            'mensaje' => 'Lista de membresías',
            'data' => $data
        ], 200);
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
        ], 201);
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
            ], 404);
        }

        $membresia->delete();

        return response()->json([
            'status' => 'ok',
            'mensaje' => 'Membresía eliminada correctamente',
            'id_eliminado' => $id
        ], 200);
    }
}
