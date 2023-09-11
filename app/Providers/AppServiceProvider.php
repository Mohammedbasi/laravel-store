<?php

namespace App\Providers;

use App\Services\CurrencyConverter;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use Symfony\Component\Intl\Locale;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind('currency.converter', function () {
            return new CurrencyConverter(config('services.currency_converter.api_key'));
        });

        $this->app->bind('stripe.client', function () {
            return new \Stripe\StripeClient(config('services.stripe.secret_key'));
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

        JsonResource::withoutWrapping();
        Validator::extend('filter', function ($attribute, $value, $params) {
            return !(in_array(strtolower($value), $params));
        }, 'The value is BLOCKED');
        Paginator::useBootstrapFour();
        // Paginator::defaultView('name of the view when using custom pagination');
        // Locale::setDefault('en');
    }
}
