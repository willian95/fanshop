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

            $product = Product::firstOrCreate([
                "productId" => $request->productId
            ], [
                "object" => $request->object,
                "searchType" => $request->searchType
            ]);

            $cart = Cart::where("user_id", $auth->id)->where("product_id", $product->id)->first();
            if($cart){

                $cart->amount = $cart->amount + 1;
                $cart->update();

            }else{

                $cart = new Cart;
                $cart->product_id = $product->id;
                $cart->user_id = $auth->id;
                $cart->amount = 1;
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
            Cart::where("user_id", $auth->id)->where("product_id", $request->id)->delete();

            return response()->json(["success" => true, "msg" => "Producto eliminado"]);

        }catch(\Exception $e){
            return response()->json(["success" => false, "err" => $e->getMessage()]);
        }

    }
    

}
