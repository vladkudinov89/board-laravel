<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\AvatarGenerator\AvatarGenerator;
use App\Support\Contracts\AvatarGeneratorContract;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        if ($this->app->environment() !== 'production') {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }
    }
}
