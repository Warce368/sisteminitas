<?php

namespace Database\Factories;

use App\Models\Antena;
use Illuminate\Database\Eloquent\Factories\Factory;

class AntenaFactory extends Factory
{
    protected $model = Antena::class;

    public function definition()
    {
        return [
            'nombre_antena' => 'Antena ' . $this->faker->unique()->word,
            'ip' => $this->faker->ipv4,
            // id_direccion se asigna desde el Seeder
        ];
    }
}