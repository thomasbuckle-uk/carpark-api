<?php

namespace Database\Factories;

use App\Models\CarPark;
use Illuminate\Database\Eloquent\Factories\Factory;

class CarParkFactory extends Factory
{
    protected $model = CarPark::class;

    public function definition(): array
    {
        return [
            'name' => 'Awesome Parking',
            'total_spaces' => 10
        ];
    }
}
