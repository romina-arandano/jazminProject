<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MembresiaController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\ClaseController;
use App\Http\Controllers\PagoController;
use App\Http\Controllers\AsistenciaController;

// Ruta pública para login
Route::post('/login', [AuthController::class, 'login']);

// Rutas protegidas (requieren token)
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('membresias', MembresiaController::class);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/perfil', fn(Request $request) => $request->user());
});

//CONTROLADOR DE USUARIOS
Route::get('usuarios', [UsersController::class, 'index']);
Route::get('usuarios/{id}', [UsersController::class, 'show']);
Route::post('usuarios', [UsersController::class, 'store']);
Route::put('usuarios/{id}', [UsersController::class, 'update']);
Route::delete('usuarios/{id}', [UsersController::class, 'destroy']);
Route::get('/profesores', [UsersController::class, 'indexProfesores']);


//CONTROLADOR DE MEMBRESIAS
Route::post('membresia/usuarios', [MembresiaController::class, 'users']);
Route::get('membresia', [MembresiaController::class, 'list']);
Route::get('membresia/{id}', [MembresiaController::class, 'index']);
Route::post('membresia', [MembresiaController::class, 'store']);
Route::delete('membresia/{id}', [MembresiaController::class, 'destroy']);

Route::apiResource('clases', ClaseController::class);
Route::apiResource('asistencias', AsistenciaController::class);
Route::apiResource('pagos', PagoController::class);
