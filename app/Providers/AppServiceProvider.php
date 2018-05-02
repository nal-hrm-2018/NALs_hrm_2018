<?php

namespace App\Providers;

use App\Service\ChartService;
use App\Service\Implement\ChartServiceImpl;
use App\Service\Implement\SearchServiceImpl;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\App;
use App\Service\SearchService;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        App::bind(SearchService::class, SearchServiceImpl::class);
        App::bind(ChartService::class, ChartServiceImpl::class);
    }
}
