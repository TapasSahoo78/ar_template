<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\{
    AuthController,
    CommonController,
    RouteController,
    UserController,
    PlansController,
    StripeController,
    SubscriptionController
};
use App\Http\Controllers\Api\Driver\DriverController;
use App\Http\Controllers\Api\User\BookingController;
use App\Models\Subscription;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::controller(AuthController::class)->group(function () {
    Route::group(['prefix' => 'auth', 'as' => 'auth'], function () {
        Route::post('register', 'register')->name('register.api');
        Route::post('otp-verify', 'otpVerify')->name('list');
        // Route::post('driver-register', 'driverRegister');
        Route::post('driver-login', 'driverLogin');
    });
});

Route::controller(CommonController::class)->group(function () {
    Route::group(['prefix' => 'common', 'as' => 'common'], function () {
        Route::get('privacy-policy', 'termConditionPrivacyPolicy');
    });
});

Route::group(['middleware' => 'api.auth', 'role:user'], function () {
    Route::controller(AuthController::class)->group(function () {
        Route::group(['prefix' => 'auth', 'as' => 'auth'], function () {
            Route::post('logout', 'logout')->name('logout.api');
            Route::post('driver-logout', 'driverlogout');
            Route::post('user-profile', 'userProfile');
            Route::post('update-profile', 'updateProfile');
        });
    });

    Route::controller(PlansController::class)->group(function () {
        Route::group(['prefix' => 'plan', 'as' => 'plan'], function () {
            Route::get('plan-list', 'plansList');
            Route::post('plan-details', 'plansDetails');
        });
    });

    Route::controller(RouteController::class)->group(function () {
        Route::group(['prefix' => 'route', 'as' => 'route'], function () {
            Route::get('route-list', 'routeList');
            Route::post('available-bus', 'availableBus');
            Route::post('available-route-wise-bus-stop', 'availableBusStop');
            Route::post('time-wise-available-bus', 'timeWiseAvailableBus');
            Route::post('bus-details', 'BusDetails');
        });
    });

    Route::controller(BookingController::class)->group(function () {
        Route::post('get-timetable', 'getTimeTable');
        Route::group(['prefix' => 'booking', 'as' => 'booking'], function () {
            Route::get('list', 'index');
            Route::post('user-wise-book-list', 'userWiseBookList');
            Route::post('add', 'creatingBooking');
            Route::post('cancel_booking', 'cancelBooking');
            Route::post('deatails', 'bookingDetails');

            Route::post('pass-validate', 'bookingPassValidate');
        });
    });

    Route::controller(SubscriptionController::class)->group(function () {
        Route::group(['prefix' => 'subscription', 'as' => 'subscription'], function () {
            // Route::get('list', 'index');
            // Route::post('user-wise-book-list', 'userWiseBookList');
            Route::post('subscribe-pass', 'subscribePass');
        });
    });

    Route::controller(StripeController::class)->group(function () {
        Route::post('customer-create', 'createCustomerAndEphemeralKey');
        Route::post('payment-intent', 'createPaymentIntent');

        Route::post('stripe-token', 'createStripeToken');
        Route::post('stripe-payment', 'makeStripePaymet');
    });
});

Route::group(['middleware' => 'api.auth', 'role:driver'], function () {
    Route::controller(AuthController::class)->group(function () {
        Route::group(['prefix' => 'driver', 'as' => 'driver'], function () {
            Route::post('logout', 'logout')->name('logout.api');
            Route::post('user-profile', 'userProfile');
            Route::post('update-profile', 'updateProfile');
        });
    });

    Route::controller(DriverController::class)->group(function () {
        Route::group(['prefix' => 'driver', 'as' => 'driver.'], function () {
            Route::post('assigen-bus-route', 'assigenBusRoute');
            Route::post('coordinate-update', 'coordinateUpdate');
            Route::post('queued-list', 'assigenQueuedList');

            Route::post('manually-user-list', 'bookingUserValidateList');

            Route::post('manually-pass-validate', 'bookingPassValidate');
        });
    });
});
