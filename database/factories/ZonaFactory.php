<?php

namespace Database\Factories;

use App\Models\Zona;
use Illuminate\Database\Eloquent\Factories\Factory;

class ZonaFactory extends Factory
{
    protected $model = Zona::class;

    public function definition()
    {
        return [
            'nombre_zona' => $this->faker->city,
        ];
    }
}
