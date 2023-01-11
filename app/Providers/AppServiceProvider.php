<?php

namespace App\Providers;

use App\Models\Settings;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RepositoryServiceProvider::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if(!Schema::hasTable("settings")) {
            return;
        }
       config([
            'global' => Settings::all([
        'name','value'
    ])
        ->keyBy('name') // key every setting by its name
        ->transform(function ($setting) {
            return $setting->value;// return only the value
        })
        ->toArray() // make it an array
    ]);
        //
    }
}
