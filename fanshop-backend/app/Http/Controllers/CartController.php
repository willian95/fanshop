<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;
use Auth;

class CartController extends Controller
{
    
    function store(Request $request){

        try{
           
            $auth = Auth::guard('api')->user() ? Auth::guard('api')->user() : Auth::user();
            
            if(Product::where("productId", $request->productId)->exists() == true){
                $product = Product::where("productId", $request->productId)->first();
                $product->object = $request->object;
                $product->searchType = $request->searchType;
                $product->image = $request->image;
                $product->unit_price = $request->price;
                $product->minimun_quantity = $request->amount;
                $product->update();
            }else{
                $product = new Product;
                $product->productId = $request->productId;
                $product->object = $request->object;
                $product->searchType = $request->searchType;
                $product->image = $request->image;
                $product->minimun_quantity = $request->amount;
                $product->unit_price = $request->price;
                $product->save();
            }

            $cart = Cart::where("user_id", $auth->id)->where("product_id", $product->id)->first();
            if($cart){

                $cart->amount = $cart->amount + 1;
                $cart->unit_price = $product->unit_price;
                $cart->update();

            }else{

                $cart = new Cart;
                $cart->product_id = $product->id;
                $cart->user_id = $auth->id;
                $cart->amount = $request->amount;
                $cart->unit_price = $product->unit_price;
                $cart->destination_payment = $request->destinationPayment;
                $cart->save();

            }

            return response()->json(["success" => true, "msg" => "Producto agregado al carrito"]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "err" => $e->getMessage()]);

        }

    }

    function fetch(){

        try{

            $auth = Auth::guard('api')->user() ? Auth::guard('api')->user() : Auth::user();

            $cart = Cart::where("user_id", $auth->id)->with("product")->get();

            return response()->json(["products" => $cart]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "err" => $e->getMessage()]);

        }

    }

    function delete(Request $request){

        try{

            $auth = Auth::guard('api')->user() ? Auth::guard('api')->user() : Auth::user();
            $cart = Cart::where("user_id", $auth->id)->where("id", $request->id)->first();
            $cart->delete();

            return response()->json(["success" => true, "msg" => "Producto eliminado"]);

        }catch(\Exception $e){
            return response()->json(["success" => false, "err" => $e->getMessage()]);
        }

    }

    function update(Request $request){

        $cart = Cart::where("id", $request->id)->first();
        $cart->amount = $request->amount;
        $cart->update();

    }
    

}
