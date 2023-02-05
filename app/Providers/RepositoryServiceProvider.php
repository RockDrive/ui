<?php

namespace App\Providers;

use App\Repositories\Beget\DomainRepository;
use App\Repositories\Beget\VpsRepository;
use App\Services\BegetAPI\v1\BegetApiService;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(BegetApiService::class, BegetApiService::class);
        $this->app->bind(VpsRepository::class, VpsRepository::class);
        $this->app->bind(DomainRepository::class, DomainRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {

        Route::bind('vps', function ($id) {
            $vps = $this->app->make(VpsRepository::class);
            return $vps->getById($id);
        });

    }
}
