<?php

namespace App\Interfaces;

interface PaymentGatewayInterface
{
    // Method public
    public function initializePayment($transaksi);
    public function handleCallback($request);
}
