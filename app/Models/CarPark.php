<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CarPark extends Model
{
    use HasFactory;

    protected $table = 'carpark';

    protected $fillable = [
        'name',
        'total_spaces'
    ];

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    public function pricingCalendar(): HasMany
    {
        return $this->hasMany(PricingCalendar::class);
    }
}
