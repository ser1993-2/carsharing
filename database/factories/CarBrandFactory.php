<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CarBrand>
 */
class CarBrandFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $brand = [
          ['brand' => 'Kia', 'model' => 'Rio X', 'year' => rand(2019,2022)],
          ['brand' => 'Volkswagen', 'model' => 'Polo', 'year' => rand(2018,2022)],
          ['brand' => 'Mercedes-Benz', 'model' => 'СLA', 'year' => rand(2018,2022)],
          ['brand' => 'Mercedes-Benz', 'model' => 'GLA', 'year' => rand(2018,2022)],
        ];

        $branIndex = rand(0,3);

        return [
            'brand' => $brand[$branIndex]['brand'],
            'model' => $brand[$branIndex]['model'],
            'year' => $brand[$branIndex]['year'],
        ];
    }
}
