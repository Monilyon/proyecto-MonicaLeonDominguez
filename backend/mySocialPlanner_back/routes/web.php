<?php

use Illuminate\Support\Facades\Route;
use App\Models\Event;
use App\Models\User;
use App\Models\Registration;
use App\Http\Controllers\EventController;

Route::get('/', function () {
    return view('welcome');
})->name('home');
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        return view('dashboard', [
            'eventosCount' => Event::count(),
            'usuariosCount' => User::count(),
            'solicitudesCount' => Registration::count(),
        ]);
    })->name('dashboard');
    Route::get('/events/create', [EventController::class, 'create'])->name('events.create');
    Route::post('/events/create', [EventController::class, 'store'])->name('events.store');

});
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
});
require __DIR__.'/settings.php';
