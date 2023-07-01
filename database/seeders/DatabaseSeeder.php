<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\PacientesSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(PacientesSeeder::class);
        // $this->call(OtroSeeder::class);
        // Agrega otros seeders si los tienes
        
    }
}
