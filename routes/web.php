<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\StripePaymentController;
  
Route::controller(StripePaymentController::class)->group(function(){
    Route::get('stripe', 'stripe');
    Route::post('stripe', 'stripePost')->name('stripe.post');
});


// php artisan make:controller StripePaymentController
//composer require stripe/stripe-php
//php artisan make:model payment
//php artisan make:mail PaymentSuccessful

// Route::get('/', function () {
//     return view('welcome');
// });



  
