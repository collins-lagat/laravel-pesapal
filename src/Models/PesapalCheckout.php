<?php

namespace CollinsLagat\LaravelPesapal\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PesapalCheckout extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_tracking_id',
        'order_merchant_reference',
        'state',
    ];
}
