<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use App\Models\Type;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Obtenemos todos los eventos con su tipo asociado y los devolvemos en formato JSON
        $events = Event::with('type')->get();
        return response()->json(['$status' => 'success', 'data' => $events], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function create()
    {
        $types = Type::all();
        return view('events.create', compact('types'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'description' => 'required|string',
            'date' => 'required|date',
            'location' => 'required|string|max:255',
            'type_id' => 'required|exists:types,id',
        ]);

        Event::create($validated);

        return redirect()->route('dashboard')->with('success', 'Evento creado exitosamente.');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //obtener un evento especifico segun su id, con su tipo asociado y devolverlo en formato JSON
        $event = Event::with('type')->findOrFail($id);
        return response()->json(['status' => 'success', 'data' => $event], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
