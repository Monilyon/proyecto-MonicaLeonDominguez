<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'name',
        'description',
        'date',
        'location',
        'capacity',
        'id_type',
    ];

    protected $dates = ['date'];
    //Relación evento con tipo (un evento pertenece a un tipo)
    public function type()
    {
        return $this->belongsTo(Type::class, 'id_type');
    }
    //Relacion con inscripciones (un evento puede tener muchas inscripciones)
    public function registrations(){
        return $this->hasMany(Registration::class);
    }
    //Método para saber si hay plazas disponibles
    public function hasAvailableSpots(){
        return $this->registrations()->count() < $this->capacity;
    }
}
