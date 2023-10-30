<?php

namespace CollinsLagat\LaravelPesapal\Support;

class OrderObject
{
    public string $id;
    public string $callback_url;
    public string $notification_id;

    public function __construct(
        string $id,
        public string $currency,
        public string|float $amount,
        public string $description,
        public string $email_address,
        public string $phone_number,
    ) {
        $this->id = config('pesapal.reference_prefix') ? strtoupper(str_replace(" ", "", config('pesapal.reference_prefix'))) . $id : $id;
        $this->callback_url = config('pesapal.callback_url');
        $this->notification_id = config('pesapal.notification_id');
    }
}
