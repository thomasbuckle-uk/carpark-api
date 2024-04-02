<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Collection;
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


    public function getAvailableSpaces(DateTime $date): int
    {
        $bookings = Booking::where('start_date', '<=', $date)->where('end_date', '>=', $date)->count();
        return $this->total_spaces - $bookings;

    }

    public function availableSpaceForDateRange(DateTime $from, DateTime $to): bool
    {
        $bookings = Booking::where('start_date', '<=', $from)->where('end_date', '>=', $from)
            ->orWhere('start_date', '<=', $to)->where('end_date', '>=',$to)->count();
        return !($bookings >= $this->total_spaces);
    }
}
