<?php

namespace App\Providers;

use App\Services\CdnService;
use App\Services\DOCdnServices;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        $this->app->bind(CdnService::class, DOCdnServices::class);
    }
}
