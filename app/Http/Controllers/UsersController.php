<?php

namespace App\Http\Controllers;

use App\Models\User;

class UsersController extends Controller
{
    public function index()
    {
        $usuarios = User::all();

        return response()->json([
            'status' => 'ok',
            'mensaje' => 'Lista de usuarios',
            'data' => $usuarios
        ], 200);
    }
}
