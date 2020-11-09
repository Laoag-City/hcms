<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        Validator::extend('alpha_spaces', function($attribute, $value)
        {
            return preg_match('/^[\pL\s.,-]+$/u', $value);
        });

        Validator::extend('alpha_num_spaces', function($attribute, $value)
        {
            return preg_match('/^[\pL0-9\s.,-]+$/u', $value);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
