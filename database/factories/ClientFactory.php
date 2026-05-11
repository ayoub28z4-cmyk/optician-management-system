<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Client>
 */
class ClientFactory extends Factory
{
    public function definition(): array
    {
        $genre = fake()->randomElement(['homme', 'femme']);
        $nom = fake()->lastName();
        $prenom = $genre === 'homme'
            ? fake()->firstNameMale()
            : fake()->firstNameFemale();

        return [
            'classement_registre' => 'REG-' . fake()->unique()->numberBetween(1, 9999),

            'nom' => $nom,
            'prenom' => $prenom,
            'cin' => strtoupper(fake()->unique()->bothify('??######')),
            'genre' => $genre,
            'date_naissance' => fake()->dateTimeBetween('-70 years', '-18 years')->format('Y-m-d'),

            'telephone' => fake()->unique()->phoneNumber(),
            'email' => fake()->optional()->safeEmail(),
            'adresse' => fake()->optional()->address(),

            'type' => fake()->randomElement(['nouveau', 'ancien']),
            'is_active' => fake()->boolean(90),
            'observations' => fake()->optional()->sentence(),
        ];
    }
}
