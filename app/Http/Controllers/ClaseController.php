<?php

namespace App\Http\Controllers;

use App\Models\Clase;
use App\Models\User;
use Illuminate\Http\Request;

class ClaseController extends Controller
{
    public function index()
    {
        $clases = Clase::with('profesor')->get();

        $data = $clases->map(fn($clase) => [
            'id' => $clase->id,
            'fecha' => $clase->fecha,
            'tipo' => $clase->tipo,
            'lugares' => $clase->lugares,
            'lugares_ocupados' => $clase->lugares_ocupados,
            'lugares_disponibles' => $clase->lugares_disponibles,
            'profesor' => $clase->profesor->name ?? 'N/A'
        ]);

        return response()->json([
            'status' => 'ok',
            'mensaje' => 'Lista de clases',
            'data' => $data
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'fecha' => 'required|date',
            'tipo' => 'required|string',
            'lugares' => 'required|integer',
            'lugares_ocupados' => 'required|integer',
            'lugares_disponibles' => 'required|integer',
            'id_profesor' => [
                'required',
                'exists:users,id',
                function ($attribute, $value, $fail) {
                    $u = User::find($value);
                    if (!$u || $u->rol !== 'profesor') {
                        $fail('El usuario asignado no es un Profesor.');
                    }
                }
            ],
        ]);

        $clase = Clase::create($request->all());

        return response()->json([
            'status' => 'ok',
            'mensaje' => 'Clase creada correctamente',
            'data' => $clase
        ], 201);
    }

    public function show($id)
    {
        return Clase::with('profesor')->findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $clase = Clase::findOrFail($id);

        $request->validate([
            'fecha' => 'sometimes|date',
            'tipo' => 'sometimes|string',
            'lugares' => 'sometimes|integer',
            'lugares_ocupados' => 'sometimes|integer',
            'lugares_disponibles' => 'sometimes|integer',
            'id_profesor' => [
                'sometimes',
                'exists:users,id',
                function ($attribute, $value, $fail) {
                    $u = User::find($value);
                    if (!$u || $u->rol !== 'profesor') {
                        $fail('El usuario asignado no es un Profesor.');
                    }
                }
            ],
        ]);

        $clase->update($request->all());
        return response()->json([
            'status' => 'ok',
            'mensaje' => 'Clase actualizada correctamente',
            'data' => $clase
        ]);
    }

    public function destroy($id)
    {
        $clase = Clase::find($id);
        if (!$clase) {
            return response()->json([
                'status' => 'error',
                'mensaje' => 'Clase no encontrada'
            ], 404);
        }

        $clase->delete();
        return response()->json([
            'status' => 'ok',
            'mensaje' => 'Clase eliminada correctamente',
            'id_eliminado' => $id
        ]);
    }
}
