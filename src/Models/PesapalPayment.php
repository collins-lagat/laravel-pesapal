<?php

namespace CollinsLagat\LaravelPesapal\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PesapalPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_tracking_id',
        'merchant_reference',
        'payment_method',
        'amount',
        'confirmation_code',
        'payment_status_description',
        'description',
        'message',
        'payment_account',
        'call_back_url',
        'status_code',
        'payment_status_code',
        'currency',
        'error',
        'created_date'
    ];

    public $timestamps = false;

    protected function originalMerchantReference(): Attribute
    {
        return Attribute::make(
            get: function () {
                $merchantReference = $this->merchant_reference;
                $prefix = strtoupper(str_replace(" ", "", config('pesapal.reference_prefix')));
                return (int)str_replace($prefix, '', $merchantReference);
            },
        );
    }
}
