<?php

use Illuminate\Support\Facades\Route;
use App\Models\Event;
use App\Models\User;
use App\Models\Registration;
use App\Http\Controllers\EventController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

// Redirige al login del frontend cuando el backend intenta usar la ruta login.
Route::get('/login', function () {
    return redirect('http://localhost:5174/login');
})->name('login');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        return view('dashboard', [
            'eventosCount' => Event::count(), // Contar el número total de eventos
            'usuariosCount' => User::count(), //Contar el número total de usuarios
            'solicitudesCount' => Registration::count(), // Contar el número total de solicitudes de registro
        ]);
    })->name('dashboard');
    Route::get('/events', [EventController::class, 'index'])->name('events.index'); // Listado de eventos
    Route::get('/events/create', [EventController::class, 'create'])->name('events.create'); // Formulario de creación de eventos
    Route::post('/events/create', [EventController::class, 'store'])->name('events.store'); // Guardar nuevo evento
    Route::get('/events/{event}/edit', [EventController::class, 'edit'])->name('events.edit'); // Formulario de edición de eventos
    Route::put('/events/{event}', [EventController::class, 'update'])->name('events.update'); // Actualizar evento existente
    Route::delete('/events/{event}', [EventController::class, 'destroy'])->name('events.destroy'); // Eliminar evento

});
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', function () { // Vista del panel de administración
        return view('admin.dashboard');
    })->name('admin.dashboard');
});
require __DIR__.'/settings.php';
