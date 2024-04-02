<?php

namespace Database\Factories;

use App\Models\Carpark;
use Illuminate\Database\Eloquent\Factories\Factory;

class CarparkFactory extends Factory
{
    protected $model = Carpark::class;

    public function definition(): array
    {
        return [
            'name' => 'Awesome Parking',
            'total_spaces' => 10,
        ];
    }
}
