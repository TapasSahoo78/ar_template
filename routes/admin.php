<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Auth\{
    AuthController,
    UserController
};
use App\Http\Controllers\Admin\{
    BookingController,
    DashboardController,
    PrivacyPolicyController,
    HelpAndSupportController,
    FeedbackController,
    NotificationController
};
use App\Http\Controllers\Admin\Bus\ManageController as BusManageController;
use App\Http\Controllers\Admin\Timetable\ManageController as TimetableManageController;
use App\Http\Controllers\Admin\BusStop\DataTablesController;
use App\Http\Controllers\Admin\BusStop\ManageController as BusStopManageController;
use App\Http\Controllers\Admin\Driver\ManageController;
use App\Http\Controllers\Admin\Job\ManageController as JobManageController;
use App\Http\Controllers\Admin\Route\ManageController as RouteManageController;
use App\Http\Controllers\Admin\Package\PackageController;
use App\Http\Controllers\Api\Driver\DriverController;

Route::group(['namespace' => 'Admin', 'as' => 'admin.'], function () {
    /************************ For Guest ******************************/
    Route::controller(AuthController::class)->group(function () {
        Route::get('signin', 'showAdminLoginForm')->name('login');
        Route::post('signin', 'adminLogin')->name('login.post');
        Route::get('forgot-password', 'showAdminForgotPasswordForm')->name('forgot.password');
    });
    /************************ For Auth Users ******************************/
    Route::middleware(['role:admin'])->group(function () {
        Route::controller(AuthController::class)->group(function () {
            Route::get('logout', 'logout')->name('logout');
        });

        // Route::get('dashboard', function () {
        //     return view('admin.pages.dashboard');
        // })->name('dashboard');

        Route::controller(DashboardController::class)->group(function () {
            Route::get('dashboard', 'index')->name('dashboard');
            Route::post('change-status', 'changeStatus')->name('status.change');
        });

        /************************ Route Management Start ******************************/
        Route::controller(RouteManageController::class)->group(function () {
            Route::group(['prefix' => 'route', 'as' => 'route.'], function () {
                Route::match(['get', 'post'], 'add-route', 'addStoreRoute')->name('store');
                Route::get('list-route', 'index')->name('list');
                Route::match(['GET', 'POST'], '/edit-route/{id}', 'editUpdateRoute')->name('edit');
                Route::post('delete', 'destroy')->name('delete');
            });
        });

        /************************ Bus Stop Management Start ******************************/
        Route::controller(BusStopManageController::class)->group(function () {
            Route::group(['prefix' => 'bus-stop', 'as' => 'bus.stop.'], function () {
                Route::match(['get', 'post'], 'add', 'addStoreBusStop')->name('store');
                Route::get('list', 'index')->name('list');
                Route::match(['GET', 'POST'], '/edit/{id}', 'editUpdateBusStop')->name('edit');
                Route::post('delete', 'destroy')->name('delete');
            });
        });

        /************************ Bus Management Start ******************************/
        Route::controller(BusManageController::class)->group(function () {
            Route::group(['prefix' => 'bus', 'as' => 'bus.'], function () {
                Route::match(['get', 'post'], 'add', 'addStoreBus')->name('store');
                Route::get('list', 'index')->name('list');
                Route::match(['GET', 'POST'], '/edit/{id}', 'editUpdateBus')->name('edit');
                Route::post('delete', 'destroy')->name('delete');
            });
        });

        /************************ Timetable Management Start ******************************/
        Route::controller(TimetableManageController::class)->group(function () {
            Route::group(['prefix' => 'timetable', 'as' => 'timetable.'], function () {
                Route::match(['get', 'post'], 'add', 'addStoreTimetable')->name('store');
                Route::get('list', 'index')->name('list');
                Route::match(['GET', 'POST'], '/edit/{id}', 'editUpdateTimetable')->name('edit');
                Route::post('delete', 'destroy')->name('delete');
            });
        });

        /************************ Driver Management Start ******************************/
        Route::controller(ManageController::class)->group(function () {
            Route::group(['prefix' => 'driver', 'as' => 'driver.'], function () {
                Route::get('list', 'index')->name('list');
                Route::match(['get', 'post'], 'add', 'addStoreDriver')->name('store');
                Route::match(['GET', 'POST'], '/edit/{id}', 'editUpdateDriver')->name('edit');
                Route::get('/delete/{id}',  'delete')->name('delete');

                /*********************** Assigned Driver Management Start ******************************/
                Route::get('assigne-list', 'assignelist')->name('assignelist');
                Route::match(['get', 'post'], 'assigne-add', 'assigneDriver')->name('assigneDriver');
            });
        });

        /************************ Job Management Start ******************************/
        Route::controller(JobManageController::class)->group(function () {
            Route::group(['prefix' => 'job', 'as' => 'job.'], function () {
                Route::match(['get', 'post'], 'add', 'addStoreJob')->name('store');
                Route::get('list', 'index')->name('list');
                Route::match(['GET', 'POST'], '/edit/{id}', 'editUpdateJob')->name('edit');
                Route::get('/delete/{id}',  'deleteJob')->name('delete');
            });
        });

        /************************ Package Management Start ******************************/
        Route::controller(PackageController::class)->group(function () {
            Route::group(['prefix' => 'passcode', 'as' => 'passcode.'], function () {
                Route::get('list', 'index')->name('list');
                Route::get('add', 'addPlanFormView')->name('add');
                Route::post('create', 'addPlan')->name('create');
                Route::get('edit/{id}', 'editPlanFormView')->name('edit');
                Route::post('update', 'updatePlan')->name('update');
                Route::post('delete', 'destroy')->name('delete');
            });
        });
        /************************ User Management Start ******************************/
        Route::controller(UserController::class)->group(function () {
            Route::group(['prefix' => 'user', 'as' => 'user.'], function () {
                Route::get('list', 'index')->name('list');
                Route::get('add', 'addPlanFormView')->name('add');
                Route::get('details/{id}', 'userDetails')->name('details');
                Route::post('create', 'addPlan')->name('create');
                Route::get('edit/{id}', 'editPlanFormView')->name('edit');

                Route::get('user-subscription', 'subscriptionList')->name('subscriptionList');

                Route::match(['get', 'post'], 'new', 'newCustomer')->name('newCustomer');

                Route::get('bus-pass/{id}', 'getbusPasscode')->name('getbusPasscode');

                Route::get('my-pass/{user_id}/{plan_id}', 'buyPasscodePage')->name('buyPasscodePage');

                Route::post('pass', 'buyPasscode')->name('buyPasscode');
            });
        });
    });
    /************************ Help and Support Management Start ******************************/
    Route::controller(HelpAndSupportController::class)->group(function () {
        Route::group(['prefix' => 'help-support', 'as' => 'help.support.'], function () {
            Route::get('/', 'index')->name('list');
            Route::get('add', 'showHelpAndSupportForm')->name('add');
            Route::post('store', 'storeHelpAndSupport')->name('store');
            Route::get('edit/{id}', 'editHelpAndSupportFormShow')->name('edit');
            Route::post('update', 'updateHelpAndSupportForm')->name('update');
            Route::post('delete', 'destroy')->name('delete');
        });
    });
    /************************ Privacy Policy Management Start ******************************/
    Route::controller(PrivacyPolicyController::class)->group(function () {
        Route::group(['prefix' => 'privacy-policy', 'as' => 'privacy.policy.'], function () {
            Route::get('/', 'index')->name('list');
            Route::get('add', 'addPrivacyPolicyFormShow')->name('add');
            Route::post('store', 'storePrivacyPolicy')->name('store');
            Route::get('edit/{id}', 'editPrivacyPolicy')->name('edit');
            Route::post('update', 'updatePrivacyPolicy')->name('update');
            Route::post('delete', 'destroy')->name('delete');
        });
    });


    /************************ Booking Management Start ******************************/
    Route::controller(BookingController::class)->group(function () {
        Route::group(['prefix' => 'booking', 'as' => 'booking.'], function () {
            Route::get('/', 'index')->name('list');
        });
    });

    /************************ Feedback Management Start ******************************/
    Route::controller(FeedbackController::class)->group(function () {
        Route::group(['prefix' => 'feedback', 'as' => 'feedback.'], function () {
            Route::get('/', 'index')->name('list');
        });
    });
    /************************ Notification Management Start ******************************/
    Route::controller(NotificationController::class)->group(function () {
        Route::group(['prefix' => 'notification', 'as' => 'notification.'], function () {
            Route::get('/', 'notification')->name('list');
        });
    });
});
