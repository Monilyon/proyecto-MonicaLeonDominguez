<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Str;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Illuminate\Support\Facades\Storage; // Importante para la foto

class User extends Authenticatable
{
    use HasFactory, HasApiTokens, Notifiable, TwoFactorAuthenticatable;

    /**
     * Atributos asignables masivamente.
     * Añadimos last_name, phone y profile_photo_path.
     */
    protected $fillable = [
        'name',
        'last_name',   // Nuevo
        'email',
        'phone',       // Nuevo
        'password',
        'rol',
        'profile_photo_path', // Nuevo
    ];

    /**
     * Atributos ocultos para la serialización (API).
     */
    protected $hidden = [
        'password',
        'two_factor_secret',
        'two_factor_recovery_codes',
        'remember_token',
    ];

    /**
     * Conversión de tipos.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // --- RELACIONES ---

    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }

    // --- MÉTODOS Y ACCESORES ---

    /**
     * Mejora de las iniciales: Ahora usa Nombre y Apellido si existen.
     */
    public function initials(): string
    {
        if ($this->last_name) {
            return strtoupper(substr($this->name, 0, 1) . substr($this->last_name, 0, 1));
        }

        return Str::of($this->name)
            ->explode(' ')
            ->take(2)
            ->map(fn($word) => Str::substr($word, 0, 1))
            ->implode('');
    }

    /**
     * Accesor para obtener la URL completa de la foto.
     * Esto facilita mostrar la imagen en Vue simplemente usando user.profile_photo_url
     */
    public function getProfilePhotoUrlAttribute(): string
    {
        return $this->profile_photo_path
            ? asset('storage/' . $this->profile_photo_path)
            : 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&color=7F9CF5&background=EBF4FF';
    }

    /**
     * Añadimos la URL de la foto al JSON automáticamente.
     */
    protected $appends = [
        'profile_photo_url',
    ];
}
