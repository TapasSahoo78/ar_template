<?php

use App\Models\Bus;
use App\Models\BusStop;
use App\Models\Plan;
use App\Models\Route;
use App\Models\Subscription;
use App\Models\User;
use App\Models\User\Booking;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

if (!function_exists('getUserList')) {
    function getUserList($role)
    {
        $users = User::whereHas('roles', function ($query) use ($role) {
            $query->where('name', $role);
        })->get();

        return $users;
    }
}

if (!function_exists('getPackageNameList')) {
    function getPackageNameList($name)
    {
        $data = [
            1 => 'Silver',
            2 => 'Gold',
            3 => 'Platinum'
        ];

        echo "<option value='' selected> Select Package</option>";

        foreach ($data as $key => $value) {
            if ($name == $value) {

                echo "<option value='" . $value . "' selected>" . $value . "</option>";
            } else {
                echo "<option value='" . $value . "'>" . $value . "</option>";
            }
        }
    }
}

if (!function_exists('getPackageDurationList')) {
    function getPackageDurationList($duration)
    {
        $data = [
            1 => 'One Day',
            7 => 'One Week',
            14 => 'Two Week',
            30 => 'One Month'
        ];

        echo "<option value='' selected> Select Duration</option>";

        foreach ($data as $key => $value) {
            if ($duration == $key) {

                echo "<option value='" . $key . "' selected>" . $value . "</option>";
            } else {
                echo "<option value='" . $key . "'>" . $value . "</option>";
            }
        }
    }
}

if (!function_exists('showPackageDurationList')) {
    function showPackageDurationList($duration)
    {
        $data = [
            1 => 'One Day',
            7 => 'One Week',
            14 => 'Two Week',
            30 => 'One Month'
        ];

        return $data[$duration];
    }
}

if (!function_exists('packageExpiryDate')) {
    function packageExpiryDate($date, $duration)
    {
        // 2024-01-02 14:59:53
        $expireDate =  Carbon::parse($date)->addDays($duration);
        return $expireDate->format('Y-m-d H:i:s');
    }
}

if (!function_exists('getPackageList')) {
    function getPackageList()
    {
        $plans = Plan::limit(3)->get();

        return $plans;
    }
}

if (!function_exists('getRoute')) {
    function getRoute($type)
    {
        $data = Route::get();

        echo "<option value='' selected> Select Route</option>";

        foreach ($data as $key => $value) {
            if ($type == $value->id) {

                echo "<option value='" . $value->id . "' selected>" . $value->name . "</option>";
            } else {
                echo "<option value='" . $value->id . "'>" . $value->name . "</option>";
            }
        }
    }
}
if (!function_exists('getBus')) {
    function getBus($type)
    {
        $data = Bus::get();

        echo "<option value='' selected> Select Bus</option>";

        foreach ($data as $key => $value) {
            if ($type == $value->id) {

                echo "<option value='" . $value->id . "' selected>" . $value->name . "</option>";
            } else {
                echo "<option value='" . $value->id . "'>" . $value->name . "</option>";
            }
        }
    }
}
if (!function_exists('getDriver')) {
    function getDriver($type)
    {
        // $data = getUserList('driver');
        $data = User::whereHas('roles', function ($query) {
            $query->where('name', 'driver');
        })->with('getDriver')->doesnthave('getDriver')->get();

        echo "<option value='' selected> Select Driver</option>";

        foreach ($data as $key => $value) {
            if ($type == $value->id) {

                echo "<option value='" . $value->id . "' selected>" . $value->name . '[' . $value->phone . ']' . "</option>";
            } else {
                echo "<option value='" . $value->id . "'>" . $value->name . '[' . $value->phone . ']' . "</option>";
            }
        }
    }
}

if (!function_exists('getApiTokenCheck')) {
    function getApiTokenCheck($token)
    {
        $user = User::where('access_token', $token)->first();
        return $user;
    }
}
if (!function_exists('getDatacheck')) {
    function getDatacheck($filed, $data, $table)
    {
        $dbDetails = DB::table($table)
            ->select($filed)
            ->where($filed, $data)->first();
        return $dbDetails;
    }
}

if (!function_exists('fileUpload')) {
    function fileUpload($file)
    {
        if ($file->isValid()) {
            $name = time() . rand(1, 100) . '.' . $file->extension();
            $file->move(public_path('upload/profile'), $name);
            return $name;
        }
        return null;
    }
}

if (!function_exists('nearestStand')) {
    function nearestStand($latitude, $longitude, $radius = 2000)
    {
        $stands = BusStop::selectRaw("id, name,  longitude, latitude,
                        ( 6371000 * acos( cos( radians(?) ) *
                        cos( radians( latitude ) )
                        * cos( radians( longitude ) - radians(?)
                        ) + sin( radians(?) ) *
                        sin( radians( latitude ) ) )
                        ) AS distance", [$latitude, $longitude, $latitude])
            ->where('status', 1)
            ->with('route')
            ->having("distance", "<", $radius)
            ->orderBy("distance", 'asc')
            ->has('route')
            ->first();

        return $stands;
    }
}

if (!function_exists('getCountQueued')) {
    function getCountQueued($bus_id, $route_id, $bus_stop_id)
    {
        $todayDate = Carbon::now()->toDateString();
        return Booking::where([
            "bus_id" => $bus_id,
            "route_id" => $route_id,
            "bus_stop_id" => $bus_stop_id
        ])->whereDate('date', $todayDate)->count();
    }
}

if (!function_exists('getUserPassDetails')) {
    function getUserPassDetails($user_id)
    {
        $subscriptions = Subscription::where(
            "user_id",
            $user_id
        )->where('expiry_date', '>=', Carbon::now())->with('passCodePlan')->first();

        return $subscriptions;
    }
}

// if (!function_exists('getCustomerPassDetails')) {
//     function getCustomerPassDetails($customerData)
//     {
//         $getCustomer = User::where('phone', $customerData)->orWhere('customer_id', $customerData)->first();
//         return $getCustomer;
//     }
// }

if (!function_exists('getCustomerPassDetails')) {
    function getCustomerPassDetails($customerData)
    {
        $getCustomer = User::where('phone', $customerData)->orWhere('customer_id', $customerData)->whereHas('roles', function ($query) {
            $query->where('name', 'user');
        })->with('roles', 'getUserSubscription')->has('getUserSubscription')->first();
        return $getCustomer;
    }
}


if (!function_exists('makeUserPassDeductions')) {
    function makeUserPassDeductions($user_id, $bookingStatus)
    {
        /*****
         * 0 -> Waiting
         * 1 -> Cancel Waiting
         */
        $subscriptions = Subscription::where(
            "user_id",
            $user_id
        )->where('expiry_date', '>=', Carbon::now())->first();
        if (!empty($subscriptions)) {
            if ($bookingStatus == 1) {
                $subscriptions->total_ride -= 1;
            } else {
                $subscriptions->total_ride += 1;
            }

            $subscriptions->save();
        }
        return $subscriptions;
    }
}

if (!function_exists('getRouteById')) {
    function getRouteById($route_id)
    {
        $route = Route::select('name')->where('id', $route_id)->first();
        return $route->name;
    }
}

if (!function_exists('getBusById')) {
    function getBusById($bus_id)
    {
        $bus = Bus::select('name')->where('id', $bus_id)->first();
        return $bus->name;
    }
}

if (!function_exists('getWeekDays')) {
    function getWeekDays($day)
    {
        $daysOfWeek = [
            'sunday' => 'Sunday',
            'monday' => 'Monday',
            'tuesday' => 'Tuesday',
            'wednesday' => 'Wednesday',
            'thursday' => 'Thursday',
            'friday' => 'Friday',
            'saturday' => 'Saturday'
        ];

        $selectedOption = function ($key) use ($day) {
            return $day === $key ? 'selected' : '';
        };

        $options = array_map(function ($key, $value) use ($selectedOption) {
            return "<option value='{$key}' {$selectedOption($key)}>{$value}</option>";
        }, array_keys($daysOfWeek), $daysOfWeek);

        echo implode('', $options);
    }
}
