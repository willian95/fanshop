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

        $cartProducts = Cart::where("user_id", $auth->id)->get();

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


}
