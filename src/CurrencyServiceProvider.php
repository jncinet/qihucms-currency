<?php

namespace Qihucms\Currency;

use Illuminate\Support\ServiceProvider;

class CurrencyServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Currency::class, function () {
            return new Currency();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/../routes.php');

        $this->loadMigrationsFrom(__DIR__ . '/../migrations');

        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'currency');

        $this->publishes([
            __DIR__ . '/../resources/lang' => resource_path('lang/vendor/currency'),
        ], 'lang');
    }
}
