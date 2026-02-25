<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RegistrationStatus extends Model
{
protected $table = 'registration_status';
    protected $fillable = [
        'name',
        'description',
    ];
    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }
}
