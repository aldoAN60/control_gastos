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
            ['nombre' => 'Hogar', 'padre_id' => null, 'activo' => 1],
            ['nombre' => 'Transporte', 'padre_id' => null, 'activo' => 1],
            ['nombre' => 'Alimentación', 'padre_id' => null, 'activo' => 1],
            ['nombre' => 'Entretenimiento', 'padre_id' => null, 'activo' => 1],
            ['nombre' => 'Salud', 'padre_id' => null, 'activo' => 1],
            ['nombre' => 'Educación', 'padre_id' => null, 'activo' => 1],
            ['nombre' => 'Ahorro e inversión', 'padre_id' => null, 'activo' => 1],
        ];

        // Insertar categorías principales
        foreach ($categorias as $categoria) {
            DB::table('categorias')->insert($categoria);
        }

        // Subcategorías de cada categoría
        // Para cada categoría principal, agregamos subcategorías
        DB::table('categorias')->insert([
            // Subcategorías para 'Hogar'
            ['nombre' => 'Alquiler', 'padre_id' => 1, 'activo' => 1],
            ['nombre' => 'Servicios Públicos', 'padre_id' => 1, 'activo' => 1],
            ['nombre' => 'Agua', 'padre_id' => 1, 'activo' => 1],
            ['nombre' => 'Electricidad', 'padre_id' => 1, 'activo' => 1],
            ['nombre' => 'Gas', 'padre_id' => 1, 'activo' => 1],
            ['nombre' => 'Internet', 'padre_id' => 1, 'activo' => 1],
            ['nombre' => 'Telefonia', 'padre_id' => 1, 'activo' => 1],

            // Subcategorías para 'Transporte'
            ['nombre' => 'Gasolina', 'padre_id' => 2, 'activo' => 1],
            ['nombre' => 'Transporte Público', 'padre_id' => 2, 'activo' => 1],
            ['nombre' => 'Mantenimiento', 'padre_id' => 2, 'activo' => 1],

            // Subcategorías para 'Alimentación'
            ['nombre' => 'Despensa', 'padre_id' => 3, 'activo' => 1],
            ['nombre' => 'Restaurantes', 'padre_id' => 3, 'activo' => 1],
            ['nombre' => 'Comida rápida', 'padre_id' => 3, 'activo' => 1],

            // Subcategorías para 'Entretenimiento'
            ['nombre' => 'Cine', 'padre_id' => 4, 'activo' => 1],
            ['nombre' => 'Conciertos', 'padre_id' => 4, 'activo' => 1],
            ['nombre' => 'Suscripciones', 'padre_id' => 4, 'activo' => 1],

            // Subcategorías para 'Salud'
            ['nombre' => 'Medicinas', 'padre_id' => 5, 'activo' => 1],
            ['nombre' => 'Consultas Médicas', 'padre_id' => 5, 'activo' => 1],
            ['nombre' => 'Seguros', 'padre_id' => 5, 'activo' => 1],

            // Subcategorías para 'Educación'
            ['nombre' => 'Cursos', 'padre_id' => 6, 'activo' => 1],
            ['nombre' => 'Libros', 'padre_id' => 6, 'activo' => 1],
            ['nombre' => 'Colegiaturas', 'padre_id' => 6, 'activo' => 1],

            // Subcategorías para 'Ahorro e inversión'
            ['nombre' => 'Ahorro Fijo', 'padre_id' => 7, 'activo' => 1],
            ['nombre' => 'Inversiones', 'padre_id' => 7, 'activo' => 1],
            ['nombre' => 'Fondos de Emergencia', 'padre_id' => 7, 'activo' => 1],
        ]);
    }
}
