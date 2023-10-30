<?php

namespace CollinsLagat\LaravelPesapal\Http\Controllers;

use CollinsLagat\LaravelPesapal\Events\PesapalPaymentCompleted;
use CollinsLagat\LaravelPesapal\Events\PesapalPaymentFailed;
use CollinsLagat\LaravelPesapal\Models\PesapalPayment;
use CollinsLagat\LaravelPesapal\Pesapal;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class NotificationController extends Controller
{
    public function handleNotification(Request $request, Pesapal $pesapal)
    {
        [
            'OrderTrackingId' => $orderTrackingId,
            'OrderNotificationType' => $orderNotificationType,
            'OrderMerchantReference' => $orderMerchantReference,
        ] = $request->validate([
            "OrderTrackingId" => "required|string",
            "OrderNotificationType" => "required|string",
            "OrderMerchantReference" => "required|string",
        ]);

        $data =  $pesapal->getTransactionDetails($orderTrackingId);

        ['payment_status_description' => $paymentStatusDescription] = $data;

        $payment_status = strtolower($paymentStatusDescription);

        $checkout = PesapalPayment::where('order_tracking_id', $orderTrackingId)->firstOrFail();
        $checkout->update([
            'payment_method' => $data['payment_method'],
            'transaction_amount' => $data['transaction_amount'],
            'confirmation_code' => $data['confirmation_code'],
            'payment_status_description' => $data['payment_status_description'],
            'description' => $data['description'],
            'message' => $data['message'],
            'payment_account' => $data['payment_account'],
            'call_back_url' => $data['call_back_url'],
            'status_code' => $data['status_code'],
            'payment_status_code' => $data['payment_status_code'],
            'currency' => $data['currency'],
            'error' => $data['error'],
        ]);

        if ($payment_status === 'completed') {
            event(new PesapalPaymentCompleted($checkout));
        } else {
            event(new PesapalPaymentFailed($checkout));
        }

        return response()->json([
            "orderNotificationType" => $orderNotificationType,
            "orderTrackingId" => $orderTrackingId,
            "orderMerchantReference" => $orderMerchantReference,
            'status' => 200,
        ]);
    }
}
