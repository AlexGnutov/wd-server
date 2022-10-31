<?php

namespace App\Providers;

use App\Interfaces\FilmRepositoryInterface;
use App\Interfaces\HallRepositoryInterface;
use App\Interfaces\SeanceRepositoryInterface;
use App\Interfaces\TicketRepositoryInterface;
use App\Repositories\FilmRepository;
use App\Repositories\HallRepository;
use App\Repositories\SeanceRepository;
use App\Repositories\TicketRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(FilmRepositoryInterface::class, FilmRepository::class);
        $this->app->bind(HallRepositoryInterface::class, HallRepository::class);
        $this->app->bind(SeanceRepositoryInterface::class, SeanceRepository::class);
        $this->app->bind(TicketRepositoryInterface::class, TicketRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
