<?php

namespace App\Providers;

use App\Models\BasketItem;
use App\Policies\BasketItemPolicy;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Auth::shouldUse('api');
//        Gate::policy(BasketItem::class, BasketItemPolicy::class);
    }
}
