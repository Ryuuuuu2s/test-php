<?php

namespace Database\Factories;

use App\Models\CompanyBilling;
use Illuminate\Database\Eloquent\Factories\Factory;

class CompanyBillingFactory extends Factory
{
    protected $model = CompanyBilling::class;

    public function definition()
    {
        return [
            'company_id' => \App\Models\Company::factory(),
            'name' => $this->faker->company,
            'name_kana' => $this->faker->companySuffix,
            'address' => $this->faker->address,
            'tel' => $this->faker->phoneNumber,
            'department' => $this->faker->word,
            'billing_name' => $this->faker->name,
            'billing_name_kana' => $this->faker->name
        ];
    }
}