<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Enum\PricingCalendar\DayTypeEnum;
use App\Enum\PricingCalendar\SeasonEnum;
use App\Models\Booking;
use App\Models\CarPark;
use App\Models\Customer;
use App\Models\PricingCalendar;
use App\Models\User;
use Database\Factories\CarParkFactory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {


        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
        ]);

        Carpark::factory()->create([
            'name' => 'Awesome Carpark',
            'total_spaces' => 10
        ]);

        PricingCalendar::factory()->create([
            'car_park_id' => 1,
            'season' => SeasonEnum::Summer,
            'day_type' => DayTypeEnum::Weekday,
            'price_per_day' => 40.00
        ]);
        PricingCalendar::factory()->create([
            'car_park_id' => 1,
            'season' => SeasonEnum::Summer,
            'day_type' => DayTypeEnum::Weekend,
            'price_per_day' => 20.00
        ]);
        PricingCalendar::factory()->create([
            'car_park_id' => 1,
            'season' => SeasonEnum::Winter,
            'day_type' => DayTypeEnum::Weekday,
            'price_per_day' => 50.00
        ]);
        PricingCalendar::factory()->create([
            'car_park_id' => 1,
            'season' => SeasonEnum::Winter,
            'day_type' => DayTypeEnum::Weekend,
            'price_per_day' => 30.00
        ]);

        Customer::factory()->create([
            'name' => 'John Smith',
            'registration' => 'EN17 RAA'
        ]);

        Booking::factory()->create([
            'car_park_id' => 1,
            'customer_id' => 1,
        ]);
    }
}
