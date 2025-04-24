<?php

namespace App\Providers;

use App\Repositories\BookingRepository;
use App\Repositories\Interfaces\BookingRepositoryInterface;
use App\Repositories\Interfaces\RoomRepositoryInterface;
use App\Repositories\RoomRepository;
use App\Services\BookingService;
use App\Services\Interfaces\BookingServiceInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Bind repositories
        $this->app->bind(RoomRepositoryInterface::class, RoomRepository::class);
        $this->app->bind(BookingRepositoryInterface::class, BookingRepository::class);

        // Bind services
        $this->app->bind(BookingServiceInterface::class, BookingService::class);
    }

    public function boot()
    {
        //
    }
}
