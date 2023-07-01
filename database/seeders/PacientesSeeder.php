<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Paciente;

class PacientesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Paciente::create([
            'nombre' => 'Juan Pérez',
            'fecha_nacimiento' => '1990-05-15',
            'direccion' => 'Calle Principal 123',
        ]);

        Paciente::create([
            'nombre' => 'María González',
            'fecha_nacimiento' => '1985-08-10',
            'direccion' => 'Avenida Central 456',
        ]);

        // Agrega más pacientes si lo deseas

    }
}
