<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Purchase;
use Auth;

class PurchaseController extends Controller
{
    
    function fetch(Request $request){

        try{

            $auth = Auth::guard('api')->user() ? Auth::guard('api')->user() : Auth::user();

            $dataAmount = 15;
            $skip = ($request->page-1) * 15;

            $purchases = Purchase::with("purchaseProducts", "user", "purchaseProducts.product")->where("user_id", $auth->id)->skip($skip)->take($dataAmount)->orderBy('id', 'desc')->get();
            
            $purchasesCount = Purchase::with("purchaseProducts", "user", "purchaseProducts.product")->where("user_id", $auth->id)->orderBy('id', 'desc')->count();

            return response()->json(["success" => true, "purchases" => $purchases, "purchasesCount" => $purchasesCount, "dataAmount" => $dataAmount]);

        }catch(\Exception $e){

        }

    }

}
