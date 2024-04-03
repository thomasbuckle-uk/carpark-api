<?php

namespace App\Models;

use Carbon\Carbon;
use DateInterval;
use DatePeriod;
use DateTime;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Carpark extends Model
{
    use HasFactory;

    // create timetable defaults in case .env vars are not set
    const SUMMER_BEGINS = '31/03';

    const WINTER_BEGINS = '31/10';

    protected $table = 'carpark';

    protected $fillable = [
        'name',
        'total_spaces',
    ];

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    public function pricingCalendar(): HasMany
    {
        return $this->hasMany(PricingCalendar::class, 'car_park_id');
    }

    public function getAvailableSpaces(DateTime $date): int
    {
        $bookings = Booking::where('start_date', '<=', $date)->where('end_date', '>=', $date)->count();

        return $this->total_spaces - $bookings;

    }

    public function availableSpaceForDateRange(DateTime $from, DateTime $to): bool
    {
        $bookings = Booking::where('start_date', '<=', $from)->where('end_date', '>=', $from)
            ->orWhere('start_date', '<=', $to)->where('end_date', '>=', $to)->count();

        return ! ($bookings >= $this->total_spaces);
    }

    public function buildAvailableSpacePerDayList(int $days): array
    {
        $today = new DateTime('now');
        $data = [];
        for ($i = 1; $i <= $days; $i++) {
            $spaces = self::getAvailableSpaces($today);
            $data[] = [$today->format('d/m/Y') => $spaces];
            $today->modify('+1 days');
        }

        return $data;
    }

    /**
     * @throws Exception
     */
    public function getPriceForDate(DateTime $date)
    {

        $seasonType = 'summer';

        $carbonDate = Carbon::instance($date);

        // I dont like this, maybe move winter/summer pricing trigger dates into the Carpark table rather than having config values
        $winterDate = Carbon::createFromFormat('d/m', config('WINTER_PRICING_BEGINS', self::WINTER_BEGINS));
        $summerDate = Carbon::createFromFormat('d/m', config('SUMMER_PRICING_BEGINS', self::SUMMER_BEGINS));

        // Case for dates before summer starts on given year
        if ($carbonDate->lessThanOrEqualTo($summerDate)) {
            $seasonType = 'winter';
        }

        // Check if $date has already passed this year's summer
        if ($carbonDate->greaterThanOrEqualTo($summerDate)) {
            // Summer has already passed this year; consider next year's summer
            $summerDate->addYear();
        }

        if ($carbonDate->greaterThanOrEqualTo($winterDate) && $carbonDate->lessThanOrEqualTo($summerDate)) {
            $seasonType = 'winter';
        }

        $result = $this->pricingCalendar()->where('season', '=', $seasonType);

        if ($date->format('N') >= 6) {
            $result = $result->where('day_type', '=', 'weekend');
        } else {
            $result = $result->where('day_type', '=', 'weekday');
        }

        if (isset($result->first()->price_per_day)) {
            return $result->first()->price_per_day;
        }

        throw new Exception('Unable to find price for given date');
    }

    /**
     * @throws Exception
     */
    public function getPriceForDateRange(DateTime $dateFrom, DateTime $dateTo): array
    {
        // Modify $dateTo by one day, so we include that date in the pricing
        $dateRange = new DatePeriod($dateFrom, new DateInterval('P1D'), $dateTo->modify('+1 day'));

        $priceArray = [];
        $priceArray['totalForRange'] = 0.00;

        foreach ($dateRange as $date) {
            $priceArray[$date->format('d/m/Y')] = $this->getPriceForDate($date);
            $priceArray['totalForRange'] += $priceArray[$date->format('d/m/Y')];
        }

        return $priceArray;
    }
}
