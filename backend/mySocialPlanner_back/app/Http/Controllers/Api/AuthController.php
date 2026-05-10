<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash; // Importante para el registro
use App\Models\User;

class AuthController extends Controller
{
    // --- MÉTODO LOGIN (Tu código mejorado) ---
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json(['message' => 'Credenciales inválidas'], 401);
        }

        /** @var User $user */
        $user = Auth::user();

        $user->tokens()->delete();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => [
                'name' => $user->name,
                'last_name' => $user->last_name,
                'phone' => $user->phone,
                'rol'  => $user->rol,
                'email' => $user->email,
                'profile_photo_url' => $user->profile_photo_url
            ]
        ]);
    }
    public function register(Request $request)
    {
        $request->validate([
            'name'      => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'email'     => 'required|string|email|max:255|unique:users',
            'phone'     => 'nullable|string|max:20',
            'password'  => 'required|string|min:8',
            'photo'     => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);
$path = null;
        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('profile-photos', 'public');
        }

        $user = User::create([
            'name'               => $request->name,
            'last_name'          => $request->last_name,
            'email'              => $request->email,
            'phone'              => $request->phone,
            'password'           => Hash::make($request->password),
            'rol'                => 'usuario',
            'profile_photo_path' => $path,
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type'   => 'Bearer',
            'user' => [
                'name' => $user->name,
                'last_name' => $user->last_name,
                'email' => $user->email,
                'phone' => $user->phone,
                'rol'  => $user->rol,
                'profile_photo_url' => $user->profile_photo_url
            ]
        ], 201);
    }

    // --- NUEVO MÉTODO: LOGOUT ---
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Sesión cerrada correctamente']);
    }
}
