<?php

namespace App\Http\Controllers;

use App\Models\Asistencia;
use App\Models\User;
use Illuminate\Http\Request;

class AsistenciaController extends Controller
{
    public function index()
    {
        $asistencias = Asistencia::with(['clase', 'usuario', 'profesor'])->get();

        $data = $asistencias->map(fn($a) => [
            'id' => $a->id,
            'clase' => $a->clase->tipo ?? 'N/A',
            'fecha_clase' => $a->clase->fecha ?? null,
            'usuario' => $a->usuario->name ?? 'N/A',
            'profesor' => $a->profesor->name ?? 'N/A',
            'id_membresia' => $a->id_membresia
        ]);

        return response()->json([
            'status' => 'ok',
            'mensaje' => 'Lista de asistencias',
            'data' => $data
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_clase' => 'required|exists:clases,id',
            'id_usuario' => 'required|exists:users,id',
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
            'id_membresia' => 'nullable|exists:membresias,id',
        ]);

        $asist = Asistencia::create($request->all());

        return response()->json([
            'status' => 'ok',
            'mensaje' => 'Asistencia registrada correctamente',
            'data' => $asist
        ], 201);
    }

    public function show($id)
    {
        return Asistencia::with(['clase','usuario','profesor'])->findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $asist = Asistencia::findOrFail($id);

        $request->validate([
            'id_clase' => 'sometimes|exists:clases,id',
            'id_usuario' => 'sometimes|exists:users,id',
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
            'id_membresia' => 'nullable|exists:membresias,id',
        ]);

        $asist->update($request->all());
        return response()->json([
            'status' => 'ok',
            'mensaje' => 'Asistencia actualizada correctamente',
            'data' => $asist
        ]);
    }

    public function destroy($id)
    {
        $a = Asistencia::find($id);
        if (!$a) {
            return response()->json([
                'status' => 'error',
                'mensaje' => 'Asistencia no encontrada'
            ], 404);
        }

        $a->delete();
        return response()->json([
            'status' => 'ok',
            'mensaje' => 'Asistencia eliminada correctamente',
            'id_eliminado' => $id
        ]);
    }
}
