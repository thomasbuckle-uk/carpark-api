<?php

namespace Database\Factories;

use App\Models\Booking;
use App\Models\CarPark;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookingFactory extends Factory
{
    protected $model = Booking::class;

    public function definition(): array
    {
        return [
            'car_park_id' => CarPark::factory(),
            'customer_id' => Customer::factory(),
            'start_date' => fake()->dateTime(),
            'end_date' => fake()->dateTimeBetween('+1 days', '+5 days')
        ];
    }
}
