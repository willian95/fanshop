<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Purchase;
use App\Models\PurchaseProduct;
use App\Models\MercadoPagoDetailedStatusMessage;
use Auth;

use MercadoPago\Item;
use MercadoPago\MerchantOrder;
use MercadoPago\Payer;
use MercadoPago\Payment;
use MercadoPago\Preference;
use MercadoPago\SDK;

class CheckoutController extends Controller
{
    
    function checkout(Request $request){
     
        SDK::setAccessToken(env("MP_SECRET"));
        $auth = Auth::guard('api')->user() ? Auth::guard('api')->user() : Auth::user();

        $cartProducts = Cart::where("user_id", $auth->id)->with("product")->get();
        $test = $this->zincapiProductCategorize($cartProducts);

        return response()->json($test);

        $payment = new Payment();
        $payment->transaction_amount = (float)$request->transactionAmount;
        $payment->token = $request->token;
        $payment->description = $request->description;
        $payment->installments = (int)$request->installments;
        $payment->payment_method_id = $request->paymentMethodId;
        $payment->issuer_id = (int)$request->issuer;

        $payer = new Payer();
        $payer->email = $request->email;
        $payer->identification = array(
            "type" => $request->docType,
            "number" => $request->docNumber
        );
        $payment->payer = $payer;

        $payment->save();

        $response = array(
            'status' => $payment->status,
            'status_detail' => $payment->status_detail,
            'id' => $payment->id
        );


        $status = $this->statusDetailMessage($response["status_detail"], $payment);

        if($payment->status != "rejected"){

            $this->storePurchase($payment, $auth, $request);

            return response()->json(["success" => true, "msg" => $status, "title" => "Productos comprados exitosamente"]);
        }else{
            return response()->json(["success" => false, "msg" => $status, "title" => "Hubo un problema con su pago"]);
        }
        
    

    }


    function storePurchase($payment, $auth, $request){

        $purchase = new Purchase;
        $purchase->user_id = $auth->id;
        $purchase->total = $request->usdTotal;
        $purchase->mercado_pago_status = $payment->status;
        $purchase->mercado_pago_id = $payment->id;
        $purchase->mercado_pago_status_detail = $payment->status_detail;
        $purchase->mercado_pago_payment_method_id = $request->paymentMethodId;
        $purchase->mercado_pago_installments = $payment->installments;
        $purchase->save();

        if($payment->status != "rejected"){
            //retornar mensajes del status_detail en storePurchasedProducts
            $this->storePurchasedProducts($auth, $purchase);    
            
        }

    }

    function storePurchasedProducts($auth, $purchase){

        $cartProducts = Cart::where("user_id", $auth->id)->with("product")->get();
        $this->zincapiProductCategorize($cartProducts);

        foreach($cartProducts as $product){

            $purchaseProduct = new PurchaseProduct;
            $purchaseProduct->product_id = $product->product_id;
            $purchaseProduct->unit_price = $product->unit_price;
            $purchaseProduct->amount = $product->amount;
            $purchaseProduct->destination_payment = $product->destination_payment;
            $purchaseProduct->purchase_id = $purchase->id;
            $purchaseProduct->save();

            //$this->deleteProductFromCart($product);

        }

    }

    function deleteProductFromCart($product){

        Cart::where("id", $product->id)->delete();
        

    }

    function statusDetailMessage($status, $payment){

        $description = MercadoPagoDetailedStatusMessage::where("status", $status)->first()->description;

        $description = str_replace("/amount/", "S. ".$payment->transaction_amount, $description);
        $description = str_replace("/payment_method_id/", $payment->payment_method_id, $description);
        $description = str_replace("/installments/", $payment->payment_method_id, $description);

        return $description;

    }

    function zincapiProductCategorize($cartProducts){

        $amazon = [];
        $walmart = [];

        foreach($cartProducts as $cart){

            if($cart->product->searchType == "amazon"){

                $amazon[]=[
                    "product_id" => $cart->product->productId,
                    "quantity" => $cart->amount
                ];

            }else if($cart->product->searchType == "walmart"){

                $walmart[]=[
                    "product_id" => $cart->product->productId,
                    "quantity" => $cart->amount
                ];

            }

        }

        $test = $this->zincapiOrderPlacement($amazon, $walmart);
        return $test;

    }

    function zincapiOrderPlacement($amazon, $walmart){

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/xml'));
        curl_setopt($ch, CURLOPT_URL, "https://api.zinc.io/v1/orders");
        curl_setopt($ch, CURLOPT_USERPWD, env("B9C027D6BDE0DC0707087057"));
        
        // SSL important
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);


        $data = '{
            "retailer": "amazon",
            "products": '.json_encode($amazon).',
            "max_price": 0,
            "shipping_address": {
              "first_name": "Darío",
              "last_name": "Oliveira",
              "address_line1": "8301 NW 66TH ST",
              "address_line2": "",
              "zip_code": "33166",
              "city": "MIAMI",
              "state": "FL",
              "country": "US",
              "phone_number": "5168374845‬"
            },
            "is_gift": false,
            "shipping_method":"cheapest",
            "addax":true,
            "billing_address": {
              "first_name": "Darío",
              "last_name": "Oliveira",
              "address_line1": "8301 NW 66TH ST",
              "address_line2": "",
              "zip_code": "33166",
              "city": "MIAMI",
              "state": "FL",
              "country": "US",
              "phone_number": "5168374845‬"
            },
            "retailer_credentials": {
              "email": "'.env("AMAZON_EMAIL").'",
              "password": "'.env("AMAZON_PASSWORD").'",
              "totp_2fa_key": "NFUO QOFD NXEW CY4A Z2E5 FHCB GMGL CWKN JAXE 6ZZQ 2VP5 3ECQ G63A"
            },
            "webhooks": {
              "request_succeeded": "'.url('/zinc/request_succeeded').'",
              "request_failed": "'.url('/zinc/request_failed').'",
              "tracking_obtained": "'.url('/zinc/tracking_obtained').'",
              "status_updated": "'.url('/zinc/status_updated').'"
            }
          }';
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

        $output = curl_exec($ch);
        curl_close($ch);

        return $output;

    }




}
