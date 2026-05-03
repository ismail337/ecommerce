<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use App\Models\GanaralSetting;
// use PSpell\Config;
use Illuminate\Support\Facades\Config;


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
        Paginator::useBootstrap();

        $generalSetting = GanaralSetting::first();

        Config::set('app.timezone', $generalSetting->time_zone ?? 'UTC');

        view()->share([
            'generalSetting' => $generalSetting,
        ]);
    }
}
