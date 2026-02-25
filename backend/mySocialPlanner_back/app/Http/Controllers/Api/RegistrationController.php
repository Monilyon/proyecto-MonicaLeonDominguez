<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Registration;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegistrationController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index() {
        //Muestra todas las inscripciones con sus relaciones (usuario, evento, estado)
        return response()->json(['status' => 'success', 'data' => Registration::with(['user', 'event', 'status'])->get()], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
    // 1. Verificar que el usuario no esté ya inscrito en el evento
        $request->validate([
            'event_id' => 'required|exists:events,id',
        ]);
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $event = Event::findOrFail($request->event_id);
        $user = Auth::user();
        $exists = Registration::where('user_id', $user->id)
            ->where('event_id', $event->id)
            ->exists();
        if ($exists) {
            return response()->json(['message' => 'Ya estás inscrito en este evento'], 400);
        }
        // 2. Verificar disponibilidad de plazas (Capacity)
        $currentRegistrations = Registration::where('event_id', $event->id)->count();
        if ($currentRegistrations >= $event->capacity) {
            return response()->json(['message' => 'El evento está lleno'], 400);
        }
        // 3. Crear la inscripción si el usuario no está inscrito y hay plazas disponibles
        $registration = Registration::create([
            'user_id' => $user->id,
            'event_id' => $event->id,
            'status_id' => 1, //ID del estado "Pendiente"
        ]);
        return response()->json(['message' => 'Inscripción realizada con éxito', 'data' => $registration], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Aquí podrías implementar la lógica para mostrar los detalles de una inscripción específica

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Aprobar o Rechazar una solicitud de inscripción (cambiar el estado)
        $request->validate([
            'status_id' => 'required|exists:statuses,id',
        ]);
        $registration = Registration::findOrFail($id);
        //Actualiza el estado de la inscripción
        $registration->status_id = $request->status_id;
        $registration->save();
        return response()->json([
            'message' => 'El estado de la inscripción ha sido actualizado',
            'registration' => $registration->load(['user', 'event', 'status'])
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
