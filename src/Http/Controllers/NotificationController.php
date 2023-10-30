<?php

namespace CollinsLagat\LaravelPesapal\Http\Controllers;

use CollinsLagat\LaravelPesapal\Events\PesapalPaymentCompleted;
use CollinsLagat\LaravelPesapal\Events\PesapalPaymentFailed;
use CollinsLagat\LaravelPesapal\Models\PesapalCheckout;
use CollinsLagat\LaravelPesapal\Pesapal;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class NotificationController extends Controller
{
    public function handleNotification(Request $request, Pesapal $pesapal)
    {
        ['OrderTrackingId' => $orderTrackingId] = $request->validate([
            "OrderTrackingId" => "required|string",
        ]);

        $data =  $pesapal->getTransactionDetails($orderTrackingId);

        ['payment_status_description' => $paymentStatusDescription] = $data;

        $state = strtolower($paymentStatusDescription);

        $checkout = PesapalCheckout::where('order_tracking_id', $orderTrackingId)->firstOrFail();
        $checkout->update([
            'state' => $state,
        ]);

        if ($state === 'completed') {
            event(new PesapalPaymentCompleted($checkout));
        } else {
            event(new PesapalPaymentFailed($checkout));
        }
    }
}
