<?php

namespace App\Providers;

use App\Cv\CvRepository;
use App\Cv\Locales;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(CvRepository::class, fn () => new CvRepository(base_path('content/cv')));
        $this->app->singleton(Locales::class, fn () => new Locales(config('cv.locales'), config('app.url')));
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
