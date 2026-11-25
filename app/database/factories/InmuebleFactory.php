<?php

namespace Database\Factories;

use App\Models\Cliente;
use App\Models\Inmueble;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Inmueble>
 */
class InmuebleFactory extends Factory
{
    protected $model = Inmueble::class;

    public function definition(): array
    {
        return [
            'cliente_id' => Cliente::factory(),
            'direccion' => fake()->address(),
            'tipo' => fake()->randomElement(Inmueble::TIPOS),
            'habitaciones' => fake()->numberBetween(0, 5),
            'banos' => fake()->numberBetween(0, 3),
            'cocinas' => fake()->numberBetween(0, 2),
            'oficinas' => fake()->numberBetween(0, 4),
        ];
    }
}
