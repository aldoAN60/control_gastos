<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         // Categorías principales
         $categorias = [
            ['name' => 'Hogar', 'parent_id' => null, 'active' => 1],
            ['name' => 'Transporte', 'parent_id' => null, 'active' => 1],
            ['name' => 'Alimentación', 'parent_id' => null, 'active' => 1],
            ['name' => 'Entretenimiento', 'parent_id' => null, 'active' => 1],
            ['name' => 'Salud', 'parent_id' => null, 'active' => 1],
            ['name' => 'Educación', 'parent_id' => null, 'active' => 1],
            ['name' => 'Ahorro e inversión', 'parent_id' => null, 'active' => 1],
        ];

        // Insertar categorías principales
        foreach ($categorias as $categoria) {
            DB::table('categories')->insert($categoria);
        }

        // Subcategorías de cada categoría
        // Para cada categoría principal, agregamos subcategorías
        DB::table('categories')->insert([
            // Subcategorías para 'Hogar'
            ['name' => 'Alquiler', 'parent_id' => 1, 'active' => 1],
            ['name' => 'Servicios Públicos', 'parent_id' => 1, 'active' => 1],
            ['name' => 'Agua', 'parent_id' => 1, 'active' => 1],
            ['name' => 'Electricidad', 'parent_id' => 1, 'active' => 1],
            ['name' => 'Gas', 'parent_id' => 1, 'active' => 1],
            ['name' => 'Internet', 'parent_id' => 1, 'active' => 1],
            ['name' => 'Telefonia', 'parent_id' => 1, 'active' => 1],

            // Subcategorías para 'Transporte'
            ['name' => 'Gasolina', 'parent_id' => 2, 'active' => 1],
            ['name' => 'Transporte Público', 'parent_id' => 2, 'active' => 1],
            ['name' => 'Mantenimiento', 'parent_id' => 2, 'active' => 1],

            // Subcategorías para 'Alimentación'
            ['name' => 'Despensa', 'parent_id' => 3, 'active' => 1],
            ['name' => 'Restaurantes', 'parent_id' => 3, 'active' => 1],
            ['name' => 'Comida rápida', 'parent_id' => 3, 'active' => 1],

            // Subcategorías para 'Entretenimiento'
            ['name' => 'Cine', 'parent_id' => 4, 'active' => 1],
            ['name' => 'Conciertos', 'parent_id' => 4, 'active' => 1],
            ['name' => 'Suscripciones', 'parent_id' => 4, 'active' => 1],

            // Subcategorías para 'Salud'
            ['name' => 'Medicinas', 'parent_id' => 5, 'active' => 1],
            ['name' => 'Consultas Médicas', 'parent_id' => 5, 'active' => 1],
            ['name' => 'Seguros', 'parent_id' => 5, 'active' => 1],

            // Subcategorías para 'Educación'
            ['name' => 'Cursos', 'parent_id' => 6, 'active' => 1],
            ['name' => 'Libros', 'parent_id' => 6, 'active' => 1],
            ['name' => 'Colegiaturas', 'parent_id' => 6, 'active' => 1],

            // Subcategorías para 'Ahorro e inversión'
            ['name' => 'Ahorro Fijo', 'parent_id' => 7, 'active' => 1],
            ['name' => 'Inversiones', 'parent_id' => 7, 'active' => 1],
            ['name' => 'Fondos de Emergencia', 'parent_id' => 7, 'active' => 1],
        ]);
    }
}
