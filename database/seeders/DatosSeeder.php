<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Zona;
use App\Models\Direccion;
use App\Models\Antena;
use App\Models\Servicio;
use App\Models\Cliente;

class DatosSeeder extends Seeder
{
    public function run()
    {
        // 1. Crear zonas
        $zonas = Zona::factory()->count(3)->create();

        $zonas->each(function ($zona) {
            Direccion::factory()->count(5)->create([
                'id_zona' => $zona->id_zona
            ])->each(function ($direccion) {
                Antena::factory()->count(2)->create([
                    'id_direccion' => $direccion->id_direccion
                ]);
            });
        });

        // 4. Crear servicios
        $servicios = Servicio::factory()->count(5)->create();

        // 5. Crear clientes asegurando relaciones válidas
        Cliente::factory()->count(10)->make()->each(function ($cliente) use ($servicios) {
            $cliente->id_direccion = Direccion::inRandomOrder()->first()->id_direccion;
            $cliente->id_servicio = $servicios->random()->id_servicio;
            $cliente->save();
        });
    }
}
