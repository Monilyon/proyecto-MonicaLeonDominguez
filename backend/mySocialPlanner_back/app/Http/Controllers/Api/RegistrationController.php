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
     * Muestra las inscripciones.
     * Si es Admin: Ve todas para gestionar el sistema.
     * Si es Usuario: Solo ve las suyas para su perfil.
     */
    public function index()
    {
        $user = Auth::user();

        // Si el usuario es administrador (ajusta 'is_admin' según tu columna en la DB)
        if ($user->is_admin) {
            $registrations = Registration::with(['user', 'event', 'status'])->get();
        } else {
            // El usuario normal solo ve sus propias inscripciones
            $registrations = Registration::where('user_id', $user->id)
                ->with(['event', 'status'])
                ->get();
        }

        return response()->json([
            'status' => 'success',
            'data' => $registrations
        ], 200);
    }

    /**
     * Registrar una nueva inscripción (Desde el Frontend)
     */
    public function store(Request $request)
    {
        $request->validate([
            'event_id' => 'required|exists:events,id',
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();
        $event = Event::findOrFail($request->event_id);

        // 1. Evitar duplicados
        $exists = Registration::where('user_id', $user->id)
            ->where('event_id', $event->id)
            ->exists();

        if ($exists) {
            return response()->json(['message' => 'Ya estás inscrito en este evento'], 400);
        }

        // 2. Verificar disponibilidad de plazas
        $currentRegistrations = Registration::where('event_id', $event->id)->count();
        if ($currentRegistrations >= $event->capacity) {
            return response()->json(['message' => 'El evento está lleno'], 400);
        }

        // 3. Crear la inscripción
        $registration = Registration::create([
            'user_id' => $user->id,
            'event_id' => $event->id,
            'status_id' => 1, // "Pendiente" o "Confirmado" según tu lógica
        ]);

        return response()->json([
            'message' => 'Inscripción realizada con éxito',
            'data' => $registration->load('event')
        ], 201);
    }

    /**
     * Actualizar estado solo para el panel de administración (Ej: Confirmar o Rechazar inscripciones)
     */
    public function update(Request $request, string $id)
    {
        // Solo el admin debería poder cambiar estados de otros
        if (!Auth::user()->is_admin) {
            return response()->json(['message' => 'No tienes permisos para realizar esta acción'], 403);
        }

        $request->validate([
            'status_id' => 'required|exists:statuses,id',
        ]);

        $registration = Registration::findOrFail($id);
        $registration->status_id = $request->status_id;
        $registration->save();

        return response()->json([
            'message' => 'El estado de la inscripción ha sido actualizado',
            'registration' => $registration->load(['user', 'event', 'status'])
        ]);
    }

    /**
     * Eliminar/Cancelar inscripción, el Admin puede borrar cualquiera. El Usuario solo la suya.
     */
    public function destroy(string $id)
    {
        $registration = Registration::findOrFail($id);
        $user = Auth::user();

        // Aqui se verifica si es el usuario o si es administrador
        if ($registration->user_id !== $user->id && !$user->is_admin) {
            return response()->json(['message' => 'Acción no autorizada'], 403);
        }

        $registration->delete();

        return response()->json([
            'message' => 'Inscripción eliminada correctamente'
        ], 200);
    }
}
