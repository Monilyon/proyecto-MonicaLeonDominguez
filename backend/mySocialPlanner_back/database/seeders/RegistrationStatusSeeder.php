<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RegistrationStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    // Aquí se insertan los estados de inscripción en la tabla 'registration_status'
    public function run(): void
    {
        //
        DB::table('registration_status')->insert([
            ['name' => 'Pendiente', 'description' => 'La inscripción está pendiente de revisión.', 'created_at' => now(), 'updated_at' => now() ],
            ['name' => 'Aprobada', 'description' => 'La inscripción ha sido aprobada.', 'created_at' => now(), 'updated_at' => now() ],
            ['name' => 'Rechazada', 'description' => 'La inscripción ha sido rechazada.', 'created_at' => now(), 'updated_at' => now() ],
            ['name' => 'Cancelada', 'description' => 'La inscripción ha sido cancelada por el usuario.', 'created_at' => now(), 'updated_at' => now() ],
        ]);
    }
}
