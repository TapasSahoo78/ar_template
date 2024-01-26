<?php

namespace App\Providers;

use App\Contracts\Admin\Booking\BookingContract;
use App\Contracts\Admin\BusStop\BusStopContract;
use App\Contracts\Admin\Package\PackageContract;
use App\Contracts\Admin\Bus\BusContract;
use App\Contracts\Admin\Job\JobContract;
use App\Contracts\Admin\Route\RouteContract;
use App\Contracts\Admin\Driver\DriverContract;
use App\Services\Admin\Package\PackageService;
use App\Contracts\Auth\AuthContract;
use App\Contracts\Subscription\SubscriptionContract;
use App\Contracts\Transaction\TransactionContract;
use App\Services\Admin\Booking\BookingService;
use App\Services\Admin\BusStop\BusStopService;
use App\Services\Admin\Bus\BusService;
use App\Services\Admin\Driver\DriverService;
use App\Services\Admin\Job\JobService;
use App\Services\Admin\Route\RouteService;
use App\Services\Auth\AuthService;
use App\Services\Subscription\SubscriptionService;
use App\Services\Transaction\TransactionService;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    protected $repositories = [
        AuthContract::class => AuthService::class,
        PackageContract::class => PackageService::class,
        RouteContract::class => RouteService::class,
        BusStopContract::class => BusStopService::class,
        BusContract::class => BusService::class,
        JobContract::class => JobService::class,
        BookingContract::class => BookingService::class,
        SubscriptionContract::class => SubscriptionService::class,
        TransactionContract::class => TransactionService::class,
        DriverContract::class => DriverService::class
    ];
    /**
     * Register services.
     * 
     * @return void
     */
    public function register()
    {
        foreach ($this->repositories as $interface => $implementation) {
            $this->app->bind($interface, $implementation);
        }
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
