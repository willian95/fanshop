<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Purchase;
use Auth;

class SalesController extends Controller
{
    
    function fetch(Request $request){

        $auth = Auth::guard('api')->user() ? Auth::guard('api')->user() : Auth::user();

        $dataAmount = 15;
        $skip = ($request->page-1) * 15;

        $purchases = Purchase::with("purchaseProducts", "user", "purchaseProducts.product")->skip($skip)->take($dataAmount);

        if($request->orderBy == 1){

            $purchases = $purchases->orderBy('created_at', 'asc')->get();

        }

        else if($request->orderBy == 2){

            $purchases = $purchases->orderBy('created_at', 'desc')->get();

        }

        else if($request->orderBy == 3){

            $purchases = $purchases->with(['user' => function ($query) {
                $query->orderBy('name', "asc");
            }])->get();

        }

        else if($request->orderBy == 4){

            $purchases = $purchases->with(['user' => function ($query) {
                $query->orderBy('name', "desc");
            }])->get();

        }

        else if($request->orderBy == 5){

            $purchases = $purchases->with(['user' => function ($query) {
                $query->orderBy('email', "asc");
            }])->get();

        }

        else if($request->orderBy == 6){

            $purchases = $purchases->with(['user' => function ($query) {
                $query->orderBy('email', "desc");
            }])->get();

        }
        
        $purchasesCount = Purchase::with("purchaseProducts", "user", "purchaseProducts.product")->count();

        return response()->json(["success" => true, "purchases" => $purchases, "purchasesCount" => $purchasesCount, "dataAmount" => $dataAmount]);

    }

}
