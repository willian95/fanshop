<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Purchase;
use App\Models\PurchaseProduct;
use App\Http\Requests\TrackingStoreRequest;
use App\Models\Tracking;
use Carbon\Carbon;
use Auth;

class SalesController extends Controller
{
    
    function fetch(Request $request){

        $auth = Auth::guard('api')->user() ? Auth::guard('api')->user() : Auth::user();

        $dataAmount = 15;
        $skip = ($request->page-1) * 15;

        $purchases = Purchase::with("purchaseProducts", "user", "purchaseProducts.product", "trackings")->skip($skip)->take($dataAmount);

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

    function addToAmazon(Request $request){

        ini_set("max_execution_time", 0);

        try{

            $productString = "";
            $index = 0;
            foreach($request->products as $product){
                $productString .= $product["asin"]."-".$product["amount"]."-".$product["id"];
                
                if( $index < count($request->products)-1){

                    $productString = $productString.",";

                }
                $index++;
            }

            $result = exec("node /var/www/fanshop/amazoncartbot/index.js ".$productString." ".env("AMAZON_EMAIL")." ".env("AMAZON_PASSWORD"));

            //$result = "B0841787BZ-1-1,B07JZ64BWC-1-2";
            $this->addedToCart($result, "amazon");
            return response()->json(["success" => true, "msg" => "Productos añadidos al carrito de tu plataforma", "test" => $result]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "err" => $e->getMessage(), "ln" => $e->getLine()]); 

        }
    }

    function addedToCart($result, $seller){

        $products = explode(",", $result);

        foreach($products as $product){

            $part = explode("-", $product);
            
            $purchaseProduct = PurchaseProduct::find($part[2]);
            if($purchaseProduct->product->productId == $part[0]){
                if($seller == "amazon"){
                    $purchaseProduct->amazon_cart_added_at = Carbon::now();
                }
                $purchaseProduct->update();
            }

        }


    }

    function addTracking(TrackingStoreRequest $request){

        try{

            $tracking = new Tracking;
            $tracking->tracking = $request->tracking;
            $tracking->url = $request->url;
            $tracking->purchase_id = $request->purchaseId;
            $tracking->save();

            return response()->json(["success" => true, "msg" => "Tracking añadido"]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Algo salió mal", "err" => $e->getMessage(), "ln" => $e->getLine()]);

        }

    }

    function fetchTracking($purchaseId){

        try{

            $trackings = Tracking::where("purchase_id", $purchaseId)->get();

            return response()->json(["success" => true, "trackings" => $trackings]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Algo salió mal", "err" => $e->getMessage(), "ln" => $e->getLine()]);

        }

    }

    function deleteTracking(Request $request){

        $tracking = Tracking::where("id", $request->id)->first();
        $tracking->delete();

        return response()->json(["success" => true, "msg" => "Tracking eliminado"]);

    }



}
