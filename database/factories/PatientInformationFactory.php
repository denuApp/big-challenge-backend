<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PatientInformation>
 */
class PatientInformationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'patient_id' => User::factory()->create(),
            'id_number' => $this->faker->unique()->randomNumber(8),
            'gender' => $this->faker->randomElement(['female', 'male', 'other']),
            'birth_date' =>$this->faker->dateTimeThisCentury->format('Y-m-d H:i:s'),
            'height' => $this->faker->biasedNumberBetween(20, 200),
            'weight' => $this->faker->biasedNumberBetween(1, 300),
        ];
    }
}
