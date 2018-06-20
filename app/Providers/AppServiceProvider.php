<?php

namespace App\Providers;

use App\Service\AbsenceService;
use App\Service\ChartService;
use App\Service\Implement\ChartServiceImpl;

use App\Service\Implement\SearchProjectServiceImpl;
use App\Service\SearchProjectService;
use App\Service\Implement\AbsenceServiceImpl;
use App\Service\Implement\ProjectServiceImpl;
use App\Service\Implement\SearchServiceImpl;
use App\Service\Implement\TeamServiceImpl;
use App\Service\ProjectService;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\App;
use App\Service\SearchService;
use App\Service\TeamService;
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
        App::bind(TeamService::class, TeamServiceImpl::class);
        App::bind(ProjectService::class, ProjectServiceImpl::class);
        App::bind(AbsenceService::class, AbsenceServiceImpl::class);
    }
}
