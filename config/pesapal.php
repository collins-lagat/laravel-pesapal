<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Pesapal Consumer Key
    |--------------------------------------------------------------------------
    |
    | The key obtained after creating your PesaPal demo or live account
    | When committing this to a repository, remove the default value
    | and put it into your online PESAPAL_KEY config variable
    |
    */
    'consumer_key' => env('PESAPAL_CONSUMER_KEY'),

    /*
   |--------------------------------------------------------------------------
   | Pesapal Consumer Secret
   |--------------------------------------------------------------------------
   |
   | The secret key obtained after creating your PesaPal demo or live account
   | When committing this to a repository, remove the default value and
   | put it into your online PESAPAL_SECRET configuration variable
   |
   */
    'consumer_secret' => env('PESAPAL_CONSUMER_SECRET'),

    /*
   |--------------------------------------------------------------------------
   | Pesapal Environment
   |--------------------------------------------------------------------------
   |
   | false for sandbox environment, true for live environment
   |
   */
    'is_live' => env('PESAPAL_IS_LIVE', false),

    /*
   |--------------------------------------------------------------------------
   | Callback URL
   |--------------------------------------------------------------------------
   |
   | This is the full url pointing to the page that the iframe
   | redirects to after processing the order on pesapal.com
   |
   */
    'callback_url' => env('PESAPAL_CALLBACK_URL'),

    /*
   |--------------------------------------------------------------------------
   | Notification ID
   |--------------------------------------------------------------------------
   |
   | This is the unique id that for the IPN (Instant Payment Notification)
   |
   */
    'notification_id' => env('PESAPAL_NOTIFICATION_ID'),

    /*
    |--------------------------------------------------------------------------
    | PESPAL Path
    |--------------------------------------------------------------------------
    |
    | This is the base URI path where Pesapal's views, such as the payment
    | verification screen
    |
    */
    'path' => env('PESAPAL_PATH', 'pesapal'),

    /*
    |--------------------------------------------------------------------------
    | PESPAL Reference Prefix
    |--------------------------------------------------------------------------
    |
    | This is the prefix that is added to the reference number
    |
    */

    'reference_prefix' => env('PESAPAL_REFERENCE_PREFIX', 'S'),
];
