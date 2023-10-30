<?php

namespace CollinsLagat\LaravelPesapal\Events;

use CollinsLagat\LaravelPesapal\Models\PesapalCheckout;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PesapalPaymentFailed
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(public PesapalCheckout $pesapalCheckout)
    {
    }
}
