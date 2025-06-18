<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    // GET /api/usuarios
    public function index()
    {
        return response()->json([
            'status' => 'ok',
            'mensaje' => 'Lista de usuarios',
            'data' => User::all()
        ]);
    }

    // GET /api/usuarios/{id}
    public function show($id)
    {
        $usuario = User::findOrFail($id);

        return response()->json([
            'status' => 'ok',
            'mensaje' => 'Usuario encontrado',
            'data' => $usuario
        ]);
    }

    // POST /api/usuarios
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6',
            'rol' => 'nullable|string|in:admin,cliente,profesor,administrador'
        ]);

        $usuario = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'rol' => $request->rol ?? 'cliente'
        ]);

        return response()->json([
            'status' => 'ok',
            'mensaje' => 'Usuario creado correctamente',
            'data' => $usuario
        ]);
    }

    // PUT /api/usuarios/{id}
    public function update(Request $request, $id)
    {
        $usuario = User::findOrFail($id);

        $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|unique:users,email,' . $id,
            'password' => 'nullable|string|min:6',
            'rol' => 'nullable|string|in:admin,cliente,profesor,administrador'
        ]);

        $usuario->update([
            'name' => $request->name ?? $usuario->name,
            'email' => $request->email ?? $usuario->email,
            'password' => $request->password ? Hash::make($request->password) : $usuario->password,
            'rol' => $request->rol ?? $usuario->rol
        ]);

        return response()->json([
            'status' => 'ok',
            'mensaje' => 'Usuario actualizado correctamente',
            'data' => $usuario
        ]);
    }

    // DELETE /api/usuarios/{id}
    public function destroy($id)
    {
        $usuario = User::findOrFail($id);
        $usuario->delete();

        return response()->json([
            'status' => 'ok',
            'mensaje' => 'Usuario eliminado correctamente'
        ]);
    }
}
