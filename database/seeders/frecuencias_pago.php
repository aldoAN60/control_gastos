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
        DB::table('payment_frequency')->insert([
            ['frequency' => 'diaria', 'days' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['frequency' => 'semanal', 'days' => 7, 'created_at' => now(), 'updated_at' => now()],
            ['frequency' => 'quincenal', 'days' => 15, 'created_at' => now(), 'updated_at' => now()],
            ['frequency' => 'mensual', 'days' => 30, 'created_at' => now(), 'updated_at' => now()],
            ['frequency' => 'bimestral', 'days' => 60, 'created_at' => now(), 'updated_at' => now()],
            ['frequency' => 'trimestral', 'days' => 90, 'created_at' => now(), 'updated_at' => now()],
            ['frequency' => 'semestral', 'days' => 180, 'created_at' => now(), 'updated_at' => now()],
            ['frequency' => 'anual', 'days' => 365, 'created_at' => now(), 'updated_at' => now()],
        ]);
        
    }
}
