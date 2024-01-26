<?php

namespace App\Http\Controllers\Api\User;

use App\Contracts\Admin\Booking\BookingContract;
use App\Contracts\Admin\BusStop\BusStopContract;
use App\Http\Controllers\BaseController;
use App\Http\Resources\Api\Booking\BookingResource;
use App\Models\BusStop;
use App\Models\Driver;
use App\Models\Plan;
use App\Models\Subscription;
use App\Models\TimeTableStop;
use App\Models\User\Booking;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class BookingController extends BaseController
{
    private $BusStopContract;
    private $BusStopModel;
    private $BookingContract;
    protected  $rules = [
        'user_id' => 'required|exists:users,id',
        'bus_id' => 'required|exists:buses,id',
        'bus_stop_id' => 'somtimes|exists:bus_stops,id',
        'route_id' => 'required|exists:routes,id',
        'longitude' => 'required|numeric',
        'latitude' => 'required|numeric',
    ];
    public function __construct(BusStopContract $BusStopContract, BusStop $BusStopModel, BookingContract $BookingContract)
    {
        $this->BusStopContract = $BusStopContract;
        $this->BusStopModel = $BusStopModel;
        $this->BookingContract = $BookingContract;
    }
    public function index()
    {
        $query = $this->BookingContract->allBooking();
        return response()->json(
            [
                'status'    => true,
                'message'   => 'Booking List Fetch Successfully!',
                'data'  => BookingResource::collection($query)
            ],
            200
        );
    }
    public function userWiseBookList(Request $request)
    {
        $id = $request->user_id;
        $query = $this->BookingContract->userWiseBookList($id);
        return response()->json(
            [
                'status'    => true,
                'message'   => 'Booking List Fetch Successfully!',
                'data'  => BookingResource::collection($query)
            ],
            200
        );
    }
    public function creatingBooking(Request $request)
    {

        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), $this->rules);
            if ($validator->fails()) {
                return $this->responseJson(false, 400, $validator->errors()->first());
            }
            DB::beginTransaction();
            try {
                // $passCheck = getUserPassDetails($request->user_id);
                // if (empty($passCheck)) {
                //     return response()->json(
                //         [
                //             'status'    => false,
                //             'message'   =>  'Your pass is not available or expired!',
                //             'data'  => (object)[]
                //         ],
                //         200
                //     );
                // }
                // $todayDate = Carbon::now()->toDateString();
                // $bookingCountUser = Booking::where([
                //     'user_id' => $request->user_id,
                //     'is_validate' => 1
                // ])->whereDate('date', $todayDate)->count();
                // if (isset($bookingCountUser) && $bookingCountUser == $passCheck->daily_ride) {
                //     return response()->json(
                //         [
                //             'status'    => false,
                //             'message'   => 'Pass daily ride is not available!',
                //             'data'  => (object)[]
                //         ],
                //         200
                //     );
                // }
                // if (isset($passCheck) && $passCheck->total_ride == 0) {
                //     return response()->json(
                //         [
                //             'status'    => false,
                //             'message'   => 'Pass total ride is not available.Please buy again!',
                //             'data'  => (object)[]
                //         ],
                //         200
                //     );
                // }

                $bus_stop_id = nearestStand($request->latitude, $request->longitude);
                $insert_arry = $request->merge(['bus_stop_id' => $bus_stop_id?->id])->except(['_token', '_method', 'id']);
                $addBooking = $this->BookingContract->addBooking($insert_arry);
                if ($addBooking) {
                    DB::commit();
                    return response()->json(
                        [
                            'status'    => true,
                            'message'   => 'Booking added Successfully.',
                            'data'  => $addBooking
                        ],
                        200
                    );
                }
            } catch (Exception $e) {
                DB::rollback();
                logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
                return response()->json(
                    [
                        'status'    => false,
                        'message'   =>  'Unavailable Buses',
                        'data'  => (object)[]
                    ],
                    200
                );
            }
        }
    }
    public function cancelBooking(Request $request)
    {
        DB::beginTransaction();
        try {
            $insert_arry = $request->except(['_token', '_method', 'id']);
            $addBooking = $this->BookingContract->cancelBooking($insert_arry);
            if ($addBooking) {
                DB::commit();
                return response()->json(
                    [
                        'status'    => true,
                        'message'   => 'Booking added Successfully!',
                        'data'  => $addBooking
                    ],
                    200
                );
            }
        } catch (Exception $e) {
            DB::rollback();
            logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
            return response()->json(
                [
                    'status'    => false,
                    'message'   =>  'Something went wrong!!',
                    'data'  => (object)[]
                ],
                200
            );
        }
    }
    public function bookingDetails(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'booking_id' => 'required|string'
        ]);
        if ($validator->fails()) {
            return $this->apiResponseJson(false, 422, $validator->errors()->first(), (object) []);
        }

        try {
            $data = [];
            $booking = Booking::where('id', $request->booking_id)->first();
            $busStopList = BusStop::where('route_id', $booking?->route_id)->orderBy('order_column', 'asc')->get();

            $driverDetails = Driver::where('bus_id', $booking?->bus_id)
                ->with('getUser:id,latitude,longitude')
                ->first();
            $driverCoordinate = $driverDetails?->getUser;

            $nearBusStop = nearestStand($driverCoordinate?->latitude, $driverCoordinate?->longitude, 200);
            // dd($nearBusStop);
            $previousBusStopId = null;  // Initialize to track the previous bus stop ID

            $busStandList = collect($busStopList)->map(function ($busStop) use ($nearBusStop, $previousBusStopId, $driverCoordinate, $booking) {

                $status = $busStop?->id === $nearBusStop?->id;

                $previousBusStopId = $nearBusStop->id ?? nearestStand($driverCoordinate?->latitude, $driverCoordinate?->longitude, 3000)?->id;

                if ($nearBusStop === null && $busStop?->id === $previousBusStopId) {
                    $status = true;  // Set status to true for the previous bus stop if $nearBusStop is null
                }

                $date = Carbon::parse($booking?->date); // 2024-01-24
                $dayName = $date->format('l'); // Output: Wednesday

                $busStopTimeTable = TimeTableStop::where([
                    "route_id" => $booking?->route_id,
                    "bus_id" => $booking?->bus_id,
                    "bus_stop_id" => $busStop?->id,
                    "week_days" => strtolower($dayName)
                ])->first();

                return [
                    'id' => $busStop->id,
                    'near_bus_stop_id' => $nearBusStop ? $nearBusStop->id : null,
                    'name' => $busStop?->name,
                    'slug' => $busStop?->slug,
                    'location' => $busStop?->location,
                    'longitude' => $busStop?->longitude,
                    'latitude' => $busStop?->latitude,
                    'status' => $status,
                    "bus_time" => $busStopTimeTable ?? (object)[]
                ];
            })->all();

            $data = [
                'driverCoordinate' => $driverCoordinate,
                'busStandList' => $busStandList
            ];

            $message = $data ? "Booking deatails fetch successfully." : "Data not found!";
            if ($data) {
                return $this->apiResponseJson(true, 200, $message, $data);
            }
        } catch (Exception $e) {
            logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
            return $this->apiResponseJson(false, 500, 'Something went wrong', (object) []);
        }
    }
    public function bookingPassValidate(Request $request)
    {
        $index = $request->all();
        $validator = Validator::make($index, [
            'user_id' => 'required',
            'booking_id' => 'required',
            'is_validate' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()->first()], 422);
        }
        DB::beginTransaction();
        try {
            $insert_arry = $request->except(['_token', '_method', 'id']);

            if ($request->is_validate == 1) {
                $passCheck = getUserPassDetails($request->user_id);
                if (empty($passCheck)) {
                    return response()->json(
                        [
                            'status'    => false,
                            'message'   =>  'Your pass is expired!',
                            'data'  => (object)[]
                        ],
                        200
                    );
                }
                $todayDate = Carbon::now()->toDateString();
                $bookingCountUser = Booking::where([
                    'user_id' => $request->user_id,
                    'is_validate' => 1
                ])->whereDate('date', $todayDate)->count();
                if (isset($bookingCountUser) && $bookingCountUser == $passCheck->daily_ride) {
                    return response()->json(
                        [
                            'status'    => false,
                            'message'   => 'Pass daily ride is not available!',
                            'data'  => (object)[]
                        ],
                        200
                    );
                }
                if (isset($passCheck) && $passCheck->total_ride == 0) {
                    return response()->json(
                        [
                            'status'    => false,
                            'message'   => 'Pass total ride is not available.Please buy again!',
                            'data'  => (object)[]
                        ],
                        200
                    );
                }
            }

            $deductSubscription = makeUserPassDeductions($request->user_id, $request->is_validate);
            if (isset($deductSubscription) && !empty($deductSubscription)) {
                $passValidateBooking = $this->BookingContract->passValidateBooking($insert_arry);
                if ($passValidateBooking) {
                    DB::commit();
                    return response()->json(
                        [
                            'status'    => true,
                            'message'   => 'Pass Validate Successfully!',
                            'data'  => $passValidateBooking
                        ],
                        200
                    );
                }
            } else {
                return response()->json(
                    [
                        'status'    => false,
                        'message'   =>  'Passcode is expired or not available!',
                        'data'  => (object)[]
                    ],
                    200
                );
            }
        } catch (Exception $e) {
            DB::rollback();
            logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
            return response()->json(
                [
                    'status'    => false,
                    'message'   =>  'Something went wrong!!',
                    'data'  => (object)[]
                ],
                200
            );
        }
    }

    public function getTimeTable(Request $request)
    {
        $index = $request->all();
        $validator = Validator::make($index, [
            'route_id' => 'required',
            'week_days' => 'required|string'
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()->first()], 422);
        }
        try {
            $busStops = BusStop::select('id', 'name')->where('route_id', $request->route_id)->get()->groupBy('id');

            $setArr = [];
            foreach ($busStops as $key1 => $busStop) {
                foreach ($busStop as $key2 => $value) {
                    $setArr[] = [
                        "id" => $key1,
                        "name" => $value->name,
                        "bus_time" => TimeTableStop::select('id', 'bus_id', 'bus_time')->with('getBus')->where([
                            "route_id" => $request->route_id,
                            "bus_stop_id" => $value?->id,
                            "week_days" => $request->week_days
                        ])->get()
                    ];
                }
            }

            return response()->json(
                [
                    'status'    => true,
                    'message'   =>  'Data available.',
                    'data'  => $setArr
                ],
                200
            );
        } catch (Exception $e) {
            logger($e->getMessage() . ' -- ' . $e->getLine() . ' -- ' . $e->getFile());
            return response()->json(
                [
                    'status'    => false,
                    'message'   =>  'Something went wrong!!',
                    'data'  => (object)[]
                ],
                200
            );
        }
    }
}
