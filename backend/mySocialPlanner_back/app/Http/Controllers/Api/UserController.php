<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function profile(Request $request)
    {
        //obtener el usuario autenticado a través del token de autenticación y devolver su información en formato JSON
        $user = $request->user();
        return response()->json([
            'user' => $user,
            'my_registrations' => $user->registrations()->with('event.type')->get()
        ]);
    }
}
