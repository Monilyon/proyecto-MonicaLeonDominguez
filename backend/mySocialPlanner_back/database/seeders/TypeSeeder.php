<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Aquí se insertan los tipos de eventos en la tabla 'types'
        DB::table('types')->insert([
        ['name' => 'Ocio', 'description' => 'Actividades de tiempo libre','created_at' => now(), 'updated_at' => now()],
        ['name' => 'Deportes', 'description' => 'Eventos deportivos','created_at' => now(), 'updated_at' => now()],
        ['name' => 'Cultura', 'description' => 'Teatro, cine, arte','created_at' => now(), 'updated_at' => now()],
        ['name' => 'Acción Social', 'description' => 'Voluntariado y ayuda','created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
