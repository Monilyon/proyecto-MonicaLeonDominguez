<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Muestra la vista con todos los usuarios para el admin (Con Filtros)
     */
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        if ($request->filled('email')) {
            $query->where('email', 'like', '%' . $request->email . '%');
        }

        if ($request->filled('created_at')) {
            $query->whereDate('created_at', $request->created_at);
        }

        $users = $query->latest()->get();

        return view('users.viewAll', compact('users'));
    }

    /**
     * Muestra el perfil del usuario autenticado (Versión Web)
     */
    public function profile(Request $request)
    {
        $user = $request->user();
        $registrations = $user->registrations()->with('event.type')->get();

        return view('users.profile', compact('user', 'registrations'));
    }
}
