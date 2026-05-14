<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Type;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $query = Event::with('type');
        if ($request->get('scope') === 'upcoming') {
        $query->where('date', '>', now());
    }
        if ($request->filled('id_type')) {
            $query->where('id_type', $request->id_type);
        }
        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }
        if ($request->filled('location')) {
            $query->where('location', 'like', '%' . $request->location . '%');
        }
        if ($request->filled('date')) {
            $query->whereDate('date', $request->date);
        }
        $events = $query->orderBy('date', 'asc')->get();
        $types = Type::all();

        return view('events.viewAll', compact('events', 'types'));
    }

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

    public function edit(Event $event)
    {
        $types = Type::all();
        return view('events.edit', compact('event', 'types'));
    }

    public function update(Request $request, Event $event)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'description' => 'required|string',
            'date' => 'required|date',
            'location' => 'required|string|max:255',
            'capacity' => 'required|integer|min:1',
            'id_type' => 'required|exists:types,id',
        ]);

        $event->update($validated);

        return redirect()->route('events.index')->with('success', 'Evento actualizado exitosamente.');
    }

    public function destroy(Event $event)
    {
        $event->delete();

        return redirect()->route('events.index')->with('success', 'Evento eliminado exitosamente.');
    }
}
