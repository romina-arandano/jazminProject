<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MembresiaController;

// Ruta pública para login
Route::post('/login', [AuthController::class, 'login']);

// Rutas protegidas (requieren token)
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('membresias', MembresiaController::class);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/perfil', fn(Request $request) => $request->user());
});

//CONTROLADOR DE USUARIOS
Route::get('/usuarios', [App\Http\Controllers\UsersController::class, 'index']);

//CONTROLADOR DE MEMBRESIAS
Route::post('membresia/usuarios', [MembresiaController::class, 'users']);
Route::get('membresia', [MembresiaController::class, 'list']);
Route::get('membresia/{id}', [MembresiaController::class, 'index']);
Route::post('membresia', [MembresiaController::class, 'store']);
Route::delete('membresia/{id}', [MembresiaController::class, 'destroy']);

