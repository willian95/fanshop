<?php

namespace App\PaymentMethods;

use App\Order;
use Illuminate\Http\Request;
use MercadoPago\Item;
use MercadoPago\MerchantOrder;
use MercadoPago\Payer;
use MercadoPago\Payment;
use MercadoPago\Preference;
use MercadoPago\SDK;

class MercadoPago
{

    public function setupPaymentAndGetRedirectURL($order, $payer)
    {

        SDK::setAccessToken('MP_SECRET');

        $payment = new Payment();
        $payment->transaction_amount = (float)$_POST['transactionAmount'];
        $payment->token = $_POST['token'];
        $payment->description = $_POST['description'];
        $payment->installments = (int)$_POST['installments'];
        $payment->payment_method_id = $_POST['paymentMethodId'];
        $payment->issuer_id = (int)$_POST['issuer'];

        $payer = new Payer();
        $payer->email = $_POST['email'];
        $payer->identification = array(
            "type" => $_POST['docType'],
            "number" => $_POST['docNumber']
        );
        $payment->payer = $payer;

        $payment->save();

        $response = array(
            'status' => $payment->status,
            'status_detail' => $payment->status_detail,
            'id' => $payment->id
        );
        return response()->json($response);

        /*# Create a preference object
        $preference = new Preference();

        //$items = [];

        # Create an item object
        $item = new Item();
        $item->id = 9;
        $item->title = "test";
        $item->quantity = 1;
        $item->currency_id = 'PEN';
        $item->unit_price = 2300;
        //$item->picture_url = "https://m.media-amazon.com/images/S/aplus-media/vc/b3a4a67e-6bfa-4585-b551-a24fa5b78458.__CR0,56,1902,588_PT0_SX970_V1___.png";
        
        # Create a payer object
        $payer = new Payer();
        $payer->email = $payer->email;

        # Setting preference properties
        $preference->items = [$item];
        $preference->payer = $payer;
        $preference->binary_mode = true;

        # Save External Reference
        $preference->external_reference = 34;

        $preference->back_urls = [
            "success" => route('checkout.success'),
            "failure" => route('checkout.failure'),
        ];
        
        $preference->auto_return = "all";
        //$preference->notification_url = route('ipn');
        
        # Save and POST preference
        $preference->save();
        return $preference;
        if (config('payment-methods.use_sandbox')) {
            return $preference->sandbox_init_point;
        }

        return $preference->init_point;*/
    }
}