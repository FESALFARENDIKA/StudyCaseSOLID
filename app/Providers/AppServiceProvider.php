<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Repositories\TicketRepositoryInterface;
use App\Repositories\EloquentTicketRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            TicketRepositoryInterface::class,
            EloquentTicketRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
