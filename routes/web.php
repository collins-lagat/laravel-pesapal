<?php

use Illuminate\Support\Facades\Route;

Route::get('payment', 'PaymentController@store')->name('payment');
Route::post('ipn', 'NotificationController@handleNotification')->name('ipn');
