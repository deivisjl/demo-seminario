<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use App\Services\Region\IRegionService;
use Illuminate\Support\ServiceProvider;
use App\Services\Region\RegionServiceImpl;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //Services
        $this->app->singleton(IRegionService::class, RegionServiceImpl::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('layouts.thegem','App\Http\View\Composers\MetaComposer');

        View::composer('layouts.app','App\Http\View\Composers\MetaComposer');
    }
}
