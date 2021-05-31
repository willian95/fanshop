<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Purchase;
use App\Models\PurchaseProduct;
use App\Models\MercadoPagoDetailedStatusMessage;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Configuration;
use App\Models\Configuration as Config;
use Illuminate\Support\Facades\Log;
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
        
        $requestAmazonId = "";
        $requestAmazonResponse = "";
        $requestWalmartId = "";
        $requestWalmartResponse = "";


        SDK::setAccessToken(env("MP_SECRET"));
        $auth = Auth::guard('api')->user() ? Auth::guard('api')->user() : Auth::user();

        $this->updateUserData($request);

        $cartProducts = Cart::where("user_id", $auth->id)->with("product")->get();
        $requestAmazonCategorize = $this->zincapiProductCategorizeAmazon($cartProducts);
        if($requestAmazonCategorize){
            $requestAmazonId = $requestAmazonCategorize->request_id;
            $requestAmazonResponse = $this->checkForRequestCode($requestAmazonId);
        }
        
        $requestWalmartCategorize = $this->zincapiProductCategorizeWalmart($cartProducts);
        if($requestWalmartCategorize){
            $requestWalmartId = $requestWalmartCategorize->request_id;
            $requestWalmartResponse = $this->checkForRequestCode($requestWalmartId);
        }


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

            $this->storePurchase($payment, $auth, $request, $requestAmazonId, $requestAmazonResponse, $requestWalmartId, $requestWalmartResponse);

            return response()->json(["success" => true, "msg" => $status, "title" => "Productos comprados exitosamente"]);
        }else{
            return response()->json(["success" => false, "msg" => $status, "title" => "Hubo un problema con su pago"]);
        }
        
    }

    function updateUserData($request){

        $user = User::find(\Auth::user()->id);
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->update();

    }

    function storePurchase($payment, $auth, $request, $requestAmazonId, $requestAmazonResponse, $requestWalmartId, $requestWalmartResponse){

        $purchase = new Purchase;
        $purchase->purchase_index = Str::random(40);
        $purchase->user_id = $auth->id;
        $purchase->total = $request->usdTotal;
        $purchase->total_peru = $request->transactionAmount;
        $purchase->dolar_price = $request->dolarPrice;
        $purchase->mercado_pago_status = $payment->status;
        $purchase->mercado_pago_id = $payment->id;
        $purchase->mercado_pago_status_detail = $payment->status_detail;
        $purchase->mercado_pago_payment_method_id = $request->paymentMethodId;
        $purchase->mercado_pago_installments = $payment->installments;
        $purchase->zinc_api_request_id = $requestAmazonId;
        $purchase->zinc_api_code = $requestAmazonResponse->code;
        $purchase->zinc_api_message = $requestAmazonResponse->message;
        $purchase->zinc_api_walmart_request_id = $requestWalmartId;
        $purchase->zinc_api_walmart_code = $requestWalmartResponse->code;
        $purchase->zinc_api_walmart_message = $requestWalmartResponse->message;
        $purchase->save();

        if($payment->status != "rejected"){
            //retornar mensajes del status_detail en storePurchasedProducts
            $this->storePurchasedProducts($auth, $purchase);    
            
        }

    }

    function storePurchasedProducts($auth, $purchase){

        $cartProducts = Cart::where("user_id", $auth->id)->with("product")->get();

        foreach($cartProducts as $product){

            $purchaseProduct = new PurchaseProduct;
            $purchaseProduct->product_id = $product->product_id;
            $purchaseProduct->unit_price = $product->unit_price;
            $purchaseProduct->amount = $product->amount;
            $purchaseProduct->destination_payment = $product->destination_payment;
            $purchaseProduct->purchase_id = $purchase->id;
            $purchaseProduct->save();

            $this->deleteProductFromCart($product);

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

    function zincapiProductCategorizeAmazon($cartProducts){

        $amazon = [];
        $maxPrice = 0;

        foreach($cartProducts as $cart){

            if($cart->product->searchType == "amazon"){

                $amazon[]=[
                    'product_id' => $cart->purchase_id,
                    'quantity' => $cart->amount
                ];

                $maxPrice = $maxPrice + ($cart->unit_price * $cart->amount);

            }

        }

        $test = $this->zincapiAmazonOrderPlacement($amazon, $maxPrice);
        return $test;

    }

    function zincapiProductCategorizeWalmart($cartProducts){

        $walmart = [];
        $maxPrice = 0;

        foreach($cartProducts as $cart){

           if($cart->product->searchType == "walmart"){

                $walmart[]=[
                    'product_id' => $cart->product->walmart_us_item_id,
                    'quantity' => $cart->amount
                ];

            }

        }

        $test = $this->zincapiWalmartOrderPlacement($walmart, $maxPrice);
        return $test;

    }

    function zincapiAmazonOrderPlacement($amazon, $maxPrice){

        $amazonOutput = [];
        $walmartOutput = [];

        if(count($amazon) > 0){
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/xml'));
            curl_setopt($ch, CURLOPT_URL, "https://api.zinc.io/v1/orders");
            curl_setopt($ch, CURLOPT_USERPWD, env("ZINCAPI_TOKEN").":");
            
            // SSL important
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

            $data = $this->setJson($maxPrice, $amazon, "amazon");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

            $output = curl_exec($ch);
            curl_close($ch);

            $amazonOutput = json_decode($output);
            return $amazonOutput;
        }

    }

    function zincapiWalmartOrderPlacement($walmart, $maxPrice){

        $amazonOutput = [];
        $walmartOutput = [];

        if(count($walmart) > 0){
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/xml'));
            curl_setopt($ch, CURLOPT_URL, "https://api.zinc.io/v1/orders");
            curl_setopt($ch, CURLOPT_USERPWD, env("ZINCAPI_TOKEN").":");
            
            // SSL important
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

            $data = $this->setJson($maxPrice, $walmart, "walmart");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

            $output = curl_exec($ch);
            curl_close($ch);
            $walmartOutput = json_decode($output);
            return $walmartOutput;
        }

    }

    function setJson($maxPrice, $order, $retailer){

        if($retailer == "amazon"){
            $retailerCredentials = '"retailer_credentials": {
                "email": "'.Config::first()->amazon_email.'",
                "password": "'.Config::first()->amazon_password.'",
                "totp_2fa_key": "NFUO QOFD NXEW CY4A Z2E5 FHCB GMGL CWKN JAXE 6ZZQ 2VP5 3ECQ G63A"
            },
            "payment_method": {
                "use_gift": true
            }
          }';
        }else if($retailer == "walmart"){

            $retailerCredentials = '"retailer_credentials": {
                "email": "'.Config::first()->walmart_email.'",
                "password": "'.Config::first()->walmart_password.'"
            },"payment_method": {
                "name_on_card": "'.Config::first()->name_on_card.'",
                "number": "'.Config::first()->card_number.'",
                "security_code": "'.Config::first()->card_security_code.'",
                "expiration_month": "'.Config::first()->card_expiration_month.'",
                "expiration_year": "'.Config::first()->card_expiration_year.'",
                "use_gift": false
                }
            }';

        }
    
        $data = '{
            "retailer": "'.$retailer.'",
            "products": '.json_encode($order).',
            "max_price": "'.$maxPrice.'",
            "shipping_address": {
              "first_name": "'.Config::first()->shipping_name.'",
              "last_name": "'.Config::first()->shipping_last_name.'",
              "address_line1": "'.Config::first()->shipping_address.'",
              "address_line2": "",
              "zip_code": "'.Config::first()->shipping_zip_code.'",
              "city": "'.Config::first()->shipping_city.'",
              "state": "'.Config::first()->shipping_state.'",
              "country": "'.Config::first()->shipping_country.'",
              "phone_number": "'.Config::first()->shipping_phone_number.'"
            },
            "is_gift": false,
            "shipping_method":"cheapest",
            "billing_address": {
                "first_name": "'.Config::first()->billing_name.'",
                "last_name": "'.Config::first()->billing_last_name.'",
                "address_line1": "'.Config::first()->billing_address.'",
                "address_line2": "",
                "zip_code": "'.Config::first()->billing_zip_code.'",
                "city": "'.Config::first()->billing_city.'",
                "state": "'.Config::first()->billing_state.'",
                "country": "'.Config::first()->billing_country.'",
                "phone_number": "'.Config::first()->billing_phone_number.'"
            },';

        $data = $data.$retailerCredentials;
            
        return $data;

    }

    function checkForRequestCode($requestId){

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/xml'));
        curl_setopt($ch, CURLOPT_URL, "https://api.zinc.io/v1/orders/".$requestId);
        curl_setopt($ch, CURLOPT_USERPWD, env("ZINCAPI_TOKEN").":");
        
        // SSL important
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $output = curl_exec($ch);
        curl_close($ch);

        return json_decode($output);

    }

    function sendEmail(){

        $data = ["purchasedProducts" => $purchase->purchaseProducts, "purchaseIndex" => $purchase->purchase_index, "name" => \Auth::user()->name." ".\Auth::user()->lastname];
        $to_name = \Auth::user()->name;
        $to_email = \Auth::user()->email;

        \Mail::send("emails.adminPurchaseNotification", $data, function($message) use ($to_name, $to_email) {

            $message->to($to_email, $to_name)->subject("¡Haz realizado una compra!");
            $message->from( env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));

        });

    }




}
