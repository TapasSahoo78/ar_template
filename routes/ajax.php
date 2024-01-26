<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Ajax\AjaxController;

Route::controller(AjaxController::class)->group(function () {
    Route::group(['prefix' => 'ajax', 'as' => 'ajax.'], function () {
        Route::post('fetch-bus', 'fetchBus')->name('fetch.bus');
        Route::post('fetch-bus-time', 'fetchBusTime')->name('fetch.bus.time');

        Route::post('fetch-timetable', 'fetchTimeTableStop')->name('fetch.time.table');
    });
});
