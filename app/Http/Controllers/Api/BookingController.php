<?php

namespace App\Http\Controllers\Api;

use App\Helpers\DateFromStringHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\BookingRequest;
use App\Http\Resources\BookingCollection;
use App\Http\Resources\BookingResource;
use App\Models\Booking;
use App\Models\Carpark;
use App\Models\Customer;
use Exception;
use Throwable;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new BookingCollection(Booking::all());
    }

    /**
     * Display the specified resource.
     */
    public function show(Booking $booking)
    {
        return new BookingResource($booking);
    }

    /**
     * @throws Throwable
     */
    public function destroy(Booking $booking)
    {
        $booking->deleteOrFail();

        return response()->json(
            'success'
        );
    }

    public function update(Booking $booking)
    {
        //TODO Update booking here
    }

    /**
     * @throws Exception
     */
    public function createBooking(Carpark $carpark, BookingRequest $booking)
    {

        $name = $booking->get('name');
        $registration = $booking->get('registration');
        $dateFrom = DateFromStringHelper::dateFromString($booking->get('dateFrom'));
        $dateTo = DateFromStringHelper::dateFromString($booking->get('dateTo'));

        // Perform search on existing customers based on name and registration
        // A lot of room for improvement here, such as creating accounts based on Emails, tying to users table etc
        $customer = Customer::where('name', '=', $name)->where('registration', '=', $registration)->first();

        if (! $customer) {
            $customer = new Customer(['name' => $name, 'registration' => $registration]);
            $customer->save();
        }

        $checkSpace = $carpark->availableSpaceForDateRange($dateFrom, $dateTo);

        if ($checkSpace !== true) {
            return response()->json(
                'No spaces available for given dates'
            );
        }

        $newBooking = new Booking();

        $newBooking->carpark()->associate($carpark);
        $newBooking->customer()->associate($customer);
        $newBooking->start_date = $dateFrom;
        $newBooking->end_date = $dateTo;

        $newBooking->save();

        return response()->json(
            [
                'bookingId' => $newBooking->id,
                'dateFrom' => $newBooking->start_date,
                'dateTo' => $newBooking->end_date,
                'totalPrice' => $carpark->getPriceForDateRange($dateFrom, $dateTo),
                'registration' => $newBooking->customer->registration,
                'customerName' => $newBooking->customer->name,
            ]
        );
    }
}
