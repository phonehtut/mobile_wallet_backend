<?php

namespace App\Providers;

use App\Repository\PaymentRepository;
use App\Repository\PaymentRepositoryInterface;
use App\Repository\UserRepository;
use App\Repository\UserRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            UserRepositoryInterface::class,
            UserRepository::class
        );

        $this->app->bind(
            PaymentRepositoryInterface::class,
            PaymentRepository::class
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
