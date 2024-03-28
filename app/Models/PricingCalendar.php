<?php

namespace App\Models;

use App\Enum\PricingCalendar\DayTypeEnum;
use App\Enum\PricingCalendar\SeasonEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PricingCalendar extends Model
{
    use HasFactory;

    protected $table = 'pricing_calendar';

    protected $fillable = ['season', 'day_type', 'price_per_day'];

    protected $casts = [
        'season' => SeasonEnum::class,
        'day_type' => DayTypeEnum::class,
    ];
    public function carpark(): BelongsTo
    {
        return $this->belongsTo(CarPark::class);
    }
}
