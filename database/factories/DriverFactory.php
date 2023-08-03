<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Driver>
 */
class DriverFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'full_name' => $this->faker->name(),
            'gender' => 'male',
            'birth_date' => '1999-03-13',
            'phone' => '994516783741',
            'email' => $this->faker->unique()->safeEmail(),
            'password' => 'reshad2022', // password
        ];
    }
}
