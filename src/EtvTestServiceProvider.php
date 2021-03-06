<?php
/**
 * Author: Xavier Au
 * Date: 14/2/2017
 * Time: 6:44 PM
 */

namespace Anacreation\Etvtest;


use Illuminate\Support\ServiceProvider;

class EtvTestServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot() {
        $this->loadMigrationsFrom(__DIR__ . '/Migration');
        $this->publishes([
            __DIR__ . '/Config/test.php' => config_path('test.php'),
        ], 'etvtest');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register() {
        //
    }
}