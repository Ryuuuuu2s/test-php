<?php

namespace Database\Factories;

use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

class CompanyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->company,
            'name_kana' => $this->faker->company,
            'address' => $this->faker->address, 
            'tel' => $this->faker->phoneNumber, 
            'representative_name' => $this->faker->name, 
            'representative_name_kana' => $this->faker->name,
        ];
    }
}