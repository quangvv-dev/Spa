<?php

namespace App\Providers;

use App\Models\CallCenter;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Schedule;
use App\Observers\CallObserver;
use App\Observers\CustomerObserver;
use App\Observers\OrderObserver;
use App\Observers\ScheduleObserver;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        Schedule::observe(ScheduleObserver::class);
        CallCenter::observe(CallObserver::class);
        Customer::observe(CustomerObserver::class);
        Order::observe(OrderObserver::class);
    }
}
