<?php

use App\Http\Controllers\Auth\SocialeLoginController;
use App\Http\Controllers\Front\CartController;
use App\Http\Controllers\Front\CheckoutController;
use App\Http\Controllers\Front\CurrencyConverterController;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\OrdersController;
use App\Http\Controllers\Front\PaymentsController;
use App\Http\Controllers\Front\ProductsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StripeWebhooksController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::group([
    'prefix' => LaravelLocalization::setLocale()
], function () {
    Route::get('/', [HomeController::class, 'index'])
        ->name('home');

    Route::get('/products', [ProductsController::class, 'index'])
        ->name('products.index');

    Route::get('/products/{product:slug}', [ProductsController::class, 'show'])
        ->name('products.show');

    Route::resource('cart', CartController::class);


    Route::get('checkout', [CheckoutController::class, 'create'])->name('checkout');
    Route::post('checkout', [CheckoutController::class, 'store']);


    Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });

    Route::view('auth/user/2fa', 'front.auth.two-factor-auth')
        ->name('front.2fa');

    Route::post('currency', [CurrencyConverterController::class, 'store'])
        ->name('currency.store');
});


Route::get('auth/{provider}/redirect', [SocialeLoginController::class, 'redirect'])
    ->name('auth.socialite.redirect');
Route::get('auth/{provider}/callback', [SocialeLoginController::class, 'callback'])
    ->name('auth.socialite.callback');

Route::post('orders/{order}/stripe/paymeny-intent', [PaymentsController::class, 'createStripePaymentIntent'])
    ->name('stripe.paymentIntent.create');

Route::get('orders/{order}/pay', [PaymentsController::class, 'create'])
    ->name('orders.payments.create');



Route::get('orders/{order}/pay/stripe/callback', [PaymentsController::class, 'confirm'])
    ->name('stripe.return');

Route::any('stripe/webhook', [StripeWebhooksController::class, 'handle'])
    ->name('stripe.webhook');

Route::get('/orders/{order}', [OrdersController::class, 'show'])
    ->name('orders.show');

// require __DIR__ . '/auth.php';
require __DIR__ . '/dashboard.php';
