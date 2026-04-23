<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Type;
use Illuminate\Http\Request;

class EventController extends Controller
{
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
            'capacity' => 'required|integer|min:1',
            'id_type' => 'required|exists:types,id',
        ]);

        Event::create($validated);

        return redirect()->route('dashboard')->with('success', 'Evento creado exitosamente.');
    }
}
