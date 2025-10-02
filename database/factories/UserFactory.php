<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User; // Make sure this is present if it wasn't before

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class; 

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
       $uniquePart = strtolower(str_replace([' ', '.'], '', $this->faker->unique()->firstName() . $this->faker->unique()->lastName()));
        $email = $uniquePart . $this->faker->unique()->randomNumber(2) . '@gmail.com';

        return [
            'name'      => $this->faker->name(),
            'email'     => $email, 
            'password'  => Hash::make('password'), 
            'role'      => 'customer', 
        ];
    }

    /**
     * Indicate that the user is an admin.
     */
    public function admin(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'role' => 'admin',
            ];
        });
    }
}