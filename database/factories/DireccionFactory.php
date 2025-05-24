<?php


namespace Database\Factories;

use App\Models\Direccion;
use Illuminate\Database\Eloquent\Factories\Factory;

class DireccionFactory extends Factory
{
    protected $model = Direccion::class;

    public function definition()
{
    return [
        'nombre_direccion' => substr($this->faker->address, 0, 50),
        'id_zona' => function () {
            return \App\Models\Zona::factory()->create()->id_zona;
        },
    ];
}
}
