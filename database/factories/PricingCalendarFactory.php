<?php

namespace Database\Factories;

use App\Enum\PricingCalendar\DayTypeEnum;
use App\Enum\PricingCalendar\SeasonEnum;
use App\Models\CarPark;
use App\Models\PricingCalendar;
use Illuminate\Database\Eloquent\Factories\Factory;

class PricingCalendarFactory extends Factory
{
    protected $model = PricingCalendar::class;

    public function definition(): array
    {
        return [
            'car_park_id' => CarPark::factory(),
            'season'  => $this->faker->randomElement(SeasonEnum::values()),
            'day_type' => $this->faker->randomElement(DayTypeEnum::values()),
            'price_per_day' => fake()->randomFloat(2, 10.00, 50.00)
        ];
    }
}
