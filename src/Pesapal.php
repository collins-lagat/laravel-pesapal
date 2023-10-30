<?php

namespace CollinsLagat\LaravelPesapal;

use CollinsLagat\LaravelPesapal\Models\PesapalPayment;
use CollinsLagat\LaravelPesapal\Support\OrderObject;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class Pesapal
{
    protected string $url;
    protected const SANDBOX = "https://cybqa.pesapal.com/pesapalv3";
    protected const LIVE = "https://pay.pesapal.com/v3";

    function __construct(
        protected string $consumerKey,
        protected string $consumerSecret,
        protected bool $isLive,
        protected string $callbackUrl
    ) {
        $this->url = $this->isLive ? Pesapal::LIVE : Pesapal::SANDBOX;
    }

    protected function authenticate()
    {
        $url = "{$this->url}/api/Auth/RequestToken";
        $response =  Http::post($url, [
            'consumer_key' => $this->consumerKey,
            'consumer_secret' => $this->consumerSecret,
        ]);
        ['token' => $token, 'expiryDate' => $expiry, "status" => $status] = $response->json();
        if ($status !== "200") {
            throw new \Exception("Authentication failed with status: {$status}");
        }
        return [
            'token' => $token,
            'expiry' => Carbon::parse($expiry),
        ];
    }

    protected function getToken()
    {
        $token = Cache::get('pesapal_token');

        if ($token) {
            return $token;
        }

        ['token' => $token, 'expiry' => $expiry] = $this->authenticate();
        Cache::put('pesapal_token', $token, $expiry);

        return $token;
    }

    public function makeOrderRequest(OrderObject $order)
    {
        $url = "{$this->url}/api/Transactions/SubmitOrderRequest";

        $payload = [
            'id' => $order->id,
            'currency' => $order->currency,
            'amount' => $order->amount,
            'description' => $order->description,
            'callback_url' => $order->callback_url,
            'notification_id' => $order->notification_id,
            'billing_address' => [
                'email_address' => $order->email_address,
                'phone_number' => $order->phone_number,
            ]
        ];

        $response =  Http::withToken($this->getToken())->post($url, $payload);

        $data = $response->json();
        ['status' => $status, 'error' => $error] = $data;

        if ($status !== "200") {
            throw new \Exception("Order request failed with status: {$status} and error: {$error['message']}");
        }

        [
            'order_tracking_id' => $orderTrackingId,
            'merchant_reference' => $merchantReference,
        ] = $data;

        PesapalPayment::create([
            'order_tracking_id' => $orderTrackingId,
            'merchant_reference' => $merchantReference,
        ]);

        return $data;
    }

    public function getTransactionDetails($orderTrackingId)
    {
        $url = "{$this->url}/api/Transactions/GetTransactionStatus";
        $response =  Http::withToken($this->getToken())->get($url, [
            'orderTrackingId' => $orderTrackingId,
        ]);

        $data = $response->json();
        ['status' => $status] = $data;

        if ($status !== "200") {
            throw new \Exception("Transaction details request failed with status: {$status}");
        }

        return $data;
    }
}
