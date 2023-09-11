<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class StripeWebhooksController extends Controller
{

    public function handle(Request $request)
    {
        $endpoint_secret = 'whsec_6f4204dc1c0e9bfdf14d757bf904ddb37232810cde8fe6c77fb0ed2afb255672';
        $payload = @file_get_contents('php://input');
        $sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
        $event = null;

        try {
            $event = \Stripe\Webhook::constructEvent(
                $payload,
                $sig_header,
                $endpoint_secret
            );
        } catch (\UnexpectedValueException $e) {
            // Invalid payload
            http_response_code(400);
            echo json_encode(['Error parsing payload: ' => $e->getMessage()]);
            exit();
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            // Invalid signature
            http_response_code(400);
            echo json_encode(['Error verifying webhook signature: ' => $e->getMessage()]);
            exit();
        }

        // Handle the event
        switch ($event->type) {
            case 'payment_intent.succeeded':
                $paymentIntent = $event->data->object; // contains a \Stripe\PaymentIntent
                Log::debug('Payment succeeded', [$paymentIntent->id]);
                break;
        }
    }
}
