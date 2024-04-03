<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Helpers\DateFromStringHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\CheckDatesPostRequest;
use App\Http\Requests\CheckPriceRequest;
use App\Http\Resources\CarparkCollection;
use App\Http\Resources\CarparkResource;
use App\Models\Carpark;
use Exception;

class CarparkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new CarparkCollection(Carpark::paginate());
    }

    /**
     * Display the specified resource.
     */
    public function show(Carpark $carpark): CarparkResource
    {
        return new CarparkResource($carpark);
    }

    /**
     * Checks for an available space given a date range in d/m/Y format
     *
     * @throws Exception
     */
    public function spaceCheck(Carpark $carpark, CheckDatesPostRequest $request)
    {
        // In real life we would want all this passed off into a service however for the purposes of this test there is no need to complicate things
        $result = $carpark->availableSpaceForDateRange(
            from: DateFromStringHelper::dateFromString($request->get('dateFrom')),
            to: DateFromStringHelper::dateFromString($request->get('dateTo')),
        );

        return response()->json([
            'spaceAvailable' => $result,
            'dateFrom' => $request->get('dateFrom'),
            'dateTo' => $request->get('dateTo'),
        ]);
    }

    /**
     * Returns a list of dates & available spaces for the next 7 days
     */
    public function availableSpacesForNextWeek(Carpark $carpark)
    {
        // Future improvement make the number of days configurable via a query param
        $data = $carpark->buildAvailableSpacePerDayList(7);

        return response()->json($data);
    }

    /**
     * @throws Exception
     */
    public function checkPriceForDates(Carpark $carpark, CheckPriceRequest $request)
    {

        $result = $carpark->getPriceForDateRange(
            dateFrom: DateFromStringHelper::dateFromString($request->get('dateFrom')),
            dateTo: DateFromStringHelper::dateFromString($request->get('dateTo')),
        );

        return response()->json($result);
    }
}
