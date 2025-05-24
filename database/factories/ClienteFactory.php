<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Direccion;
use App\Models\Servicio;

class ClienteFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nombre' => $this->faker->name,
            'tipo_persona' => $this->faker->randomElement(['NATURAL', 'JURIDICA']),
            'tipo_documento' => $this->faker->randomElement(['DNI', 'RUC']),
            'documento' => $this->faker->unique()->numerify('########'),
            'sexo' => $this->faker->randomElement(['M', 'F']),
            'telefono1' => $this->faker->phoneNumber,
            'telefono2' => $this->faker->phoneNumber,
            'email' => $this->faker->unique()->safeEmail,
            'fecha_nacimiento' => $this->faker->date(),
            'fecha_creacion' => now(),
            'ip' => $this->faker->ipv4,
            'ip_fija' => $this->faker->ipv4,
            'coordenadas' => $this->faker->latitude . ', ' . $this->faker->longitude,
            'modo_pago' => $this->faker->randomElement(['efectivo', 'tarjeta']),
            'prestado' => $this->faker->boolean,
            'estado' => $this->faker->randomElement(['ACTIVO', 'INACTIVO']),
            'id_direccion' => Direccion::factory(),
            'id_servicio' => Servicio::factory(),
        ];
    }
}
