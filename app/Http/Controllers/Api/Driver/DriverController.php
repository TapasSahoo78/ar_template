<?php

namespace App\Http\Controllers\Api\Driver;

use App\Contracts\Admin\Booking\BookingContract;
use App\Contracts\Admin\BusStop\BusStopContract;
use App\Contracts\Admin\Driver\DriverContract;
use App\Http\Controllers\BaseController;
use App\Http\Resources\Api\Driver\DriverResource;
use App\Http\Resources\Api\User\UserResources;
use App\Models\Bus;
use App\Models\BusStop;
use App\Models\Driver;
use App\Models\TimeTableStop;
use App\Models\User;
use App\Models\User\Booking;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class DriverController extends BaseController
{
    private $BusStopContract;
    private $BusStopModel;
    private $BookingContract;
    private $DriverContract;
    // protected  $rules = [
    //     'user_id' => 'required|exists:users,id',
    //     'bus_id' => 'required|exists:buses,id',
    //     'bus_stop_id' => 'somtimes|exists:bus_stops,id',
    //     'route_id' => 'required|exists:routes,id',
    //     'longitude' => 'required|numeric',
    //     'latitude' => 'required|numeric',
    // ];
    public function __construct(DriverContract $DriverContract, BusStopContract $BusStopContract, BusStop $BusStopModel, BookingContract $BookingContract)
    {
        $this->BusStopContract = $BusStopContract;
        $this->BusStopModel = $BusStopModel;
        $this->BookingContract = $BookingContract;
        $this->DriverContract = $DriverContract;
    }
    public function assigenBusRoute(Request $request)
    {
        $rules = [
            'user_id' => 'required'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return $this->responseJson(false, 200, $validator->errors()->first());
        }
        DB::beginTransaction();
        try {
            $profileDetails = User::select('name', 'last_name', 'authozation_no', 'reg_no', 'image')->where('id', $request->user_id)->first();
            $driverDetails = Driver::select('bus_id')->where('user_id', $request->user_id)->first();

            $busDetails = Bus::select('id', 'name', 'vehicle_no', 'route_id', 'from_time', 'to_time')->where('id', $driverDetails?->bus_id)->with('getRoute')->first();

            $busStopWiseQueued = [];
            $date = Carbon::now(); // 2024-01-24
            $dayName = $date->format('l'); // Output: Wednesday
            foreach ($busDetails->getRoute->getBusStop as $key => $value) {
                $busStopWiseQueued[] = [
                    "id" => $value->id,
                    "route_id" => $value->route_id,
                    "name" => $value->name,
                    "slug" => $value->slug,
                    "location" => $value->location,
                    "longitude" => $value->longitude,
                    "latitude" => $value->latitude,
                    "status" => $value->status,
                    "created_at" => $value->created_at,
                    "updated_at" => $value->updated_at,
                    "deleted_at" => $value->deleted_at,
                    "count_queued" => getCountQueued($busDetails->id, $value->route_id, $value->id),
                    "bus_time" => TimeTableStop::where([
                        "route_id" => $value?->route_id,
                        "bus_id" => $driverDetails?->bus_id,
                        "bus_stop_id" => $value->id,
                        "week_days" => strtolower($dayName)
                    ])->first() ?? (object)[]
                ];
            }

            $routeDetails = [
                "id" => $busDetails->id,
                "name" => $busDetails->name,
                "vehicle_no" => $busDetails->vehicle_no,
                "route_id" => $busDetails->route_id,
                "from_time" => $busDetails->from_time,
                "to_time" => $busDetails->to_time,
                "get_route" => [
                    "id" => $busDetails->getRoute->id,
                    "name" => $busDetails->getRoute->name,
                    "slug" => $busDetails->getRoute->slug,
                    "status" => $busDetails->getRoute->status,
                    "created_at" => $busDetails->getRoute->created_at,
                    "updated_at" => $busDetails->getRoute->updated_at,
                    "deleted_at" => $busDetails->getRoute->deleted_at,
                    "get_bus_stop" => $busStopWiseQueued
                ]
            ];

            $first = $busDetails?->getRoute?->getBusStop[0]->name;
            $last = $busDetails?->getRoute?->getBusStop[count($busDetails->getRoute->getBusStop) - 1]->name;

            $data = [
                'baseUrl' => config('arc_config.ASSET_URL') . 'uploads/',
                'profileDetails' => $profileDetails ?? (object)[],
                'busDetails' => [
                    'from_time' => $busDetails->from_time ?? '',
                    'from_lacation' => $first ?? '',
                    'to_time' => $busDetails->to_time ?? '',
                    'to_lacation' => $last ?? '',
                ],
                'routeWithBusStopDetails' => $routeDetails ?? (object)[]
            ];

            if (isset($data) && !empty($data)) {
                DB::commit();
                return response()->json(
                    [
                        'status'    => true,
                        'message'   => 'Data available',
                        'data'  =>  $data
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
                    'message'   =>  'Data not found!',
                    'data'  => (object)[]
                ],
                200
            );
        }
    }
    public function addStore(Request $request)
    {
    }
    public function editUpdate(Request $request)
    {
    }
    public function delete(Request $request)
    {
    }

    public function  coordinateUpdate(Request $request)
    {
        $rules = [
            'user_id' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return $this->responseJson(false, 200, $validator->errors()->first());
        }
        DB::beginTransaction();
        try {
            $coordinateUpdate = $this->DriverContract->coordinateUpdate($request->all());
            $user = User::where('id', $request->user_id)->first();

            if ($coordinateUpdate) {
                DB::commit();
                return response()->json(
                    [
                        'status'    => true,
                        'message'   => config('custom.MSG_RECORD_UPDATE_SUCCESS'),
                        'data'  =>  [
                            'latitude' => $user['latitude'],
                            'longitude' => $user['longitude'],
                        ]
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
                    'message'   =>  config('custom.MSG_ERROR_TRY_AGAIN'),
                    'data'  => (object)[]
                ],
                200
            );
        }
    }

    public function bookingUserValidateList(Request $request)
    {
        $index = $request->all();
        $validator = Validator::make($index, [
            'bus_id' => 'required',
            'customer_data' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()->first()], 422);
        }
        DB::beginTransaction();
        try {
            $searchTerm = $request->customer_data;

            if (!$searchTerm) {
                return collect(); // Return empty collection if no search term
            }

            $busId = $request->bus_id;
            $nameUser = User::where(function ($query) use ($searchTerm) {
                $query->where('name', 'like', $searchTerm . '%')
                    ->orWhere('last_name', 'like', $searchTerm . '%')
                    ->orWhere('phone', $searchTerm)
                    ->orWhere('customer_id', $searchTerm);
            })->whereHas('roles', function ($query) {
                $query->where('name', 'user');
            })
                // ->with(['roles', 'getUserSubscription', 'getUserBooking'])
                ->with(['roles', 'getUserSubscription', 'getUserBooking' => function ($query) use ($busId) {
                    // Filter bookings for today and the specified bus ID
                    $query->whereDate('date', Carbon::now()->toDateString())
                        ->where('bus_id', $busId); // Replace $busId with the actual ID
                }])
                ->has('getUserSubscription')
                ->limit(10)
                ->get();

            if (count($nameUser) > 0) {
                return response()->json(
                    [
                        'status'    => true,
                        'message'   => 'Data available.',
                        'data'  => [
                            'baseUrl' => config('arc_config.ASSET_URL') . 'uploads/',
                            'userListData' => $nameUser
                        ]
                    ],
                    200
                );
            } else {
                $customerData = getCustomerPassDetails($request->customer_data);
                $customerId = $customerData?->id;

                return response()->json(
                    [
                        'status'    => $customerId ? true : false,
                        'message'   => $customerId ? 'Data available' : 'Data not found!',
                        'data'  => [
                            'customerId' => $customerId
                        ]
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
                500
            );
        }
    }

    public function bookingPassValidate(Request $request)
    {
        $index = $request->all();
        $validator = Validator::make($index, [
            'bus_id' => 'required',
            // 'customer_data' => 'required',
            'customer_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()->first()], 422);
        }
        DB::beginTransaction();
        try {
            $currentTime = date('H:i:s', time());
            $todayDate = Carbon::now()->toDateString();
            $customerId = $request->customer_id;
            // $busId = $request->bus_id;
            // $customerData = $request->customer_data;
            // $customerDetails = getCustomerPassDetails($customerData);

            $checkBooking = Booking::where([
                'bus_id' => $request->bus_id,
                'user_id' => $customerId
            ])->whereDate('date', $todayDate)->first();

            /**************************************** Create Booking if not get *************************************************/
            if (empty($checkBooking)) {
                $tokenWithBearer = $request->header('Authorization');

                $token = substr($tokenWithBearer, 7);
                $token = $request->bearerToken();
                $driverDetails = (object)[];
                if (isset($token) && !empty($token)) {
                    $driverDetails = getApiTokenCheck($token);
                }
                $userDetails = User::where('id', $customerId)->first();
                $busDetails = Bus::where('id', $request->bus_id)->first();

                $bus_stop_id = nearestStand($driverDetails->latitude, $driverDetails->longitude);
                // $bus_stop_id = nearestStand(-27.646218, 153.382429);

                if (!empty($userDetails) || !empty($busDetails)) {
                    $booking = Booking::create([
                        'user_id' => $customerId,
                        'bus_id' => $request->bus_id,
                        'bus_stop_id' => $bus_stop_id?->id,
                        'route_id' => $busDetails?->route_id,
                        'longitude' => $userDetails?->longitude,
                        'latitude' => $userDetails?->latitude,
                        'date' => $todayDate,
                        'time' => $currentTime
                    ]);
                    // dd($booking);
                }
            }

            /************************************** Customer Data *****************************************/
            $todayBooking = Booking::where([
                'bus_id' => $request->bus_id,
                'user_id' => $customerId
            ])->whereDate('date', $todayDate)->first();
            // dd($todayBooking);
            if ($todayBooking->is_validate == 1) {
                return response()->json(
                    [
                        'status'    => false,
                        'message'   =>  'Already Validated.',
                        'data'  => (object)[]
                    ],
                    200
                );
            }

            $passCheck = getUserPassDetails($customerId);
            if (empty($passCheck)) {
                return response()->json(
                    [
                        'status'    => false,
                        'message'   =>  'Pass is expired!',
                        'data'  => (object)[]
                    ],
                    200
                );
            }
            $bookingCountUser = Booking::where([
                'user_id' => $customerId,
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

            $insert_arry = [
                "user_id" => $customerId,
                "booking_id" => $todayBooking->id,
                "is_validate" => 1
            ];
            $deductSubscription = makeUserPassDeductions($insert_arry['user_id'], $insert_arry['is_validate']);
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
                        'message'   =>  'Passcode is not validate!',
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
                500
            );
        }
    }

    public function assigenQueuedList(Request $request)
    {
        $rules = [
            "bus_id" => "required",
            "route_id" => "required",
            "bus_stop_id" => "required"
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return $this->responseJson(false, 200, $validator->errors()->first());
        }
        DB::beginTransaction();
        try {
            $todayDate = Carbon::now()->toDateString();
            $busStop = BusStop::where('id', $request->bus_stop_id)->first();
            $bookingDetails = Booking::where([
                "bus_id" => $request->bus_id,
                "route_id" => $request->route_id,
                "bus_stop_id" => $request->bus_stop_id
            ])->with('users')->whereDate('date', $todayDate)->get();

            $passDetails = [];
            foreach ($bookingDetails as $key => $value) {
                $passDetails[] = [
                    "id" => $value->id,
                    "user_id" => $value->user_id,
                    "bus_id" => $value->bus_id,
                    "route_id" => $value->route_id,
                    "bus_stop_id" => $value->bus_stop_id,
                    "longitude" => $value->longitude,
                    "latitude" => $value->latitude,
                    "booking_no" => $value->booking_no,
                    "date" => $value->date,
                    "time" => $value->time,
                    "is_validate" => $value->is_validate,
                    "status" => $value->status,
                    "created_at" => $value->created_at,
                    "updated_at" => $value->updated_at,
                    "users" => [
                        "id" => $value->users->id,
                        "customer_id" => $value->users->customer_id,
                        "name" => $value->users->name,
                        "last_name" => $value->users->last_name,
                        "phone" => $value->users->phone,
                        "email" => $value->users->email,
                        "email_verified_at" => $value->users->email_verified_at,
                        "gender" => $value->users->gender,
                        "image" => $value->users->image
                    ],
                    "passDetails" => getUserPassDetails($value->users->id)
                ];
            }

            $data = [
                'baseUrl' => config('arc_config.ASSET_URL') . 'uploads/',
                'busDetails' => [
                    "bus_stop" => $busStop?->name,
                    "currentTime" => Carbon::now(),
                    "count_queued" => getCountQueued($request->bus_id, $request->route_id, $request->bus_stop_id)
                ],
                'bookingDetails' => $passDetails ?? (object)[]
            ];

            if (isset($data) && !empty($data)) {
                DB::commit();
                return response()->json(
                    [
                        'status'    => true,
                        'message'   => 'Data available',
                        'data'  =>  $data
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
                    'message'   =>  'Data not found!',
                    'data'  => (object)[]
                ],
                200
            );
        }
    }
}
