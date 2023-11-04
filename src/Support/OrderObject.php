<?php

namespace CollinsLagat\LaravelPesapal\Support;

class OrderObject
{
    public string $id;
    public string $callbackUrl;

    public function __construct(
        string $id,
        public string $currency,
        public string|float $amount,
        public string $description,
        public string $emailAddress,
        public string $phoneNumber,
        public string $notificationId,
    ) {
        $this->id = config('pesapal.reference_prefix') ? strtoupper(str_replace(" ", "", config('pesapal.reference_prefix'))) . $id : $id;
        $this->callbackUrl = config('pesapal.callback_url');
    }
}
