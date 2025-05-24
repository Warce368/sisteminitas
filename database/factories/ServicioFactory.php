<?php

namespace Database\Factories;

use App\Models\Servicio;
use Illuminate\Database\Eloquent\Factories\Factory;

class ServicioFactory extends Factory
{
    protected $model = Servicio::class;

    public function definition()
    {
        return [
            'nombre_servicio' => $this->faker->word . ' Internet',
            'descripcion' => $this->faker->text(50),
            'valor_servicio' => $this->faker->numberBetween(50, 300),
            'velocidad_subida' => $this->faker->numberBetween(5, 50),
            'velocidad_bajada' => $this->faker->numberBetween(10, 100),
            'fecha' => $this->faker->date(),
        ];
    }
}
