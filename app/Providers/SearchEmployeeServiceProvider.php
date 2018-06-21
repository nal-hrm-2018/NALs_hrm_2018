<?php

namespace App\Providers;

use App\Service\AbsencePoTeamService;
use App\Service\Implement\AbsencePoTeamServiceImpl;
use App\Service\Implement\SearchProjectServiceImpl;
use App\Service\SearchEmployeeService;
use App\Service\SearchEmployeeServiceImpl;
use App\Service\SearchProjectService;
use Illuminate\Support\ServiceProvider;

class SearchEmployeeServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(SearchEmployeeService::class, SearchEmployeeServiceImpl::class);
        $this->app->singleton(SearchProjectService::class, SearchProjectServiceImpl::class);
        $this->app->singleton(AbsencePoTeamService::class, AbsencePoTeamServiceImpl::class);
    }
}
