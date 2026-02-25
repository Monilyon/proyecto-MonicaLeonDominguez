<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\EventController;
use App\Http\Controllers\Api\RegistrationController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AuthController;

// --- RUTAS PÚBLICAS ---
// Cualquiera (incluso sin estar logueado) puede ver eventos y loguearse
Route::post('/login', [AuthController::class, 'login']);
Route::get('/events', [EventController::class, 'index']);


// --- RUTAS PROTEGIDAS (Requieren Token Sanctum) ---
Route::middleware('auth:sanctum')->group(function () {

    // Perfil y datos del usuario
    Route::get('/user/profile', [UserController::class, 'profile']);

    // Inscripciones
    Route::post('/registrations', [RegistrationController::class, 'store']);
    //nadie puede crear eventos, solo el admin a través del panel de administración, por lo que no es necesario proteger esta ruta con autenticación
    Route::post('/events', [EventController::class, 'store']);

});
