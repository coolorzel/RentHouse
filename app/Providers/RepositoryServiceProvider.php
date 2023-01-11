<?php

namespace App\Providers;

use App\Http\Repositories\BasicRepositoryInterface;
use App\Http\Repositories\CategoryRepositoryInterface;
use App\Http\Repositories\Implementation\BasicRepository;
use App\Http\Repositories\Implementation\CategoryRepository;
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
        $this->app->bind(BasicRepositoryInterface::class, BasicRepository::class);
        $this->app->bind(CategoryRepositoryInterface::class, CategoryRepository::class);
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
