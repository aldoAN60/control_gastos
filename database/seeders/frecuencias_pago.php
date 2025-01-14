<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class frecuencias_pago extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('frecuencias_pago')->insert([
            ['frecuencia' => 'diaria', 'dias' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['frecuencia' => 'semanal', 'dias' => 7, 'created_at' => now(), 'updated_at' => now()],
            ['frecuencia' => 'quincenal', 'dias' => 15, 'created_at' => now(), 'updated_at' => now()],
            ['frecuencia' => 'mensual', 'dias' => 30, 'created_at' => now(), 'updated_at' => now()],
            ['frecuencia' => 'bimestral', 'dias' => 60, 'created_at' => now(), 'updated_at' => now()],
            ['frecuencia' => 'trimestral', 'dias' => 90, 'created_at' => now(), 'updated_at' => now()],
            ['frecuencia' => 'semestral', 'dias' => 180, 'created_at' => now(), 'updated_at' => now()],
            ['frecuencia' => 'anual', 'dias' => 365, 'created_at' => now(), 'updated_at' => now()],
        ]);
        
    }
}
