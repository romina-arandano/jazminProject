<?php

namespace App\Http\Controllers;

use App\Models\Pago;
use Illuminate\Http\Request;

class PagoController extends Controller
{
    public function index()
    {
        $pagos = Pago::with(['usuario', 'clase', 'membresia'])->get();

        $data = $pagos->map(function ($pago) {
            return [
                'id' => $pago->id,
                'usuario' => $pago->usuario->name ?? 'N/A',
                'clase' => $pago->clase->tipo ?? null,
                'membresia' => $pago->membresia ? "Membresía #" . $pago->membresia->id : null,
                'monto' => $pago->monto,
                'fecha' => $pago->fecha,
            ];
        });

        return response()->json([
            'status' => 'ok',
            'mensaje' => 'Lista de pagos',
            'data' => $data
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_usuario' => 'required|exists:users,id',
            'monto' => 'required|numeric',
            'fecha' => 'required|date',
            'id_membresia' => 'nullable|exists:membresias,id',
            'id_clase' => 'nullable|exists:clases,id',
        ]);

        $pago = Pago::create($request->all());

        return response()->json([
            'status' => 'ok',
            'mensaje' => 'Pago registrado correctamente',
            'data' => $pago
        ], 201);
    }

    public function show($id)
    {
        return Pago::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $pago = Pago::findOrFail($id);
        $pago->update($request->all());

        return $pago;
    }

    public function destroy($id)
    {
        $pago = Pago::find($id);

        if (!$pago) {
            return response()->json([
                'status' => 'error',
                'mensaje' => 'Pago no encontrado'
            ], 404);
        }

        $pago->delete();

        return response()->json([
            'status' => 'ok',
            'mensaje' => 'Pago eliminado correctamente',
            'id_eliminado' => $id
        ]);
    }
}
