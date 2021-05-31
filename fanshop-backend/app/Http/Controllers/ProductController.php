<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Configuration;

class ProductController extends Controller
{
    
    function info(Request $request){

        try{
            $response = null;

            if($request->searchType == "amazon"){
                $response = $this->amazonProductInfo($request->id, $request->ref);
            }

            else if($request->searchType == "walmart"){
                $response = $this->walmartProductInfo($request->id);
            }

            return response()->json(["product" => $response, "configuration" => Configuration::select("dolar_price", "earn_percentage", "max_price_without_tax", "price_per_pound", "price_tax_percent")->first()]);
        }
        catch(\Exception $e){
            return response()->json(["err" => $e->getMessage()]);
        }

    }   

    function amazonProductInfo($id, $ref){

        try{

            $refString = "";
            $id = str_replace("https://www.amazon.com/dp/", "", $id);

            if(isset($ref)){
                $refString = '/'.$ref;
            }
            
            $response = Http::withHeaders([
                'axesso-api-key' => env('AXESSO_KEY'),
                'Content-Type' => 'application/json'
            ])->get('http://api-prd.axesso.de/amz/amazon-lookup-product?url=https://www.amazon.com/dp/'.$id.$refString);
            
            return $response->json();


        }catch(\Exception $e){
            return response()->json(["success" => false, "err" => $e->getMessage(), "ln" => $e->getMessage()]);
        }

    
    }

    function walmartProductInfo($id){

        try{

            $response = [];

            $id = str_replace("https://www.walmart.com/ip/", "", $id);

            $productInfo = Http::withHeaders([
                'axesso-api-key' => env('AXESSO_KEY'),
                'Content-Type' => 'application/json'
            ])->get('http://api-prd2.axesso.de/wlm/walmart-lookup-product?url=https://www.walmart.com/ip/'.$id);

            $searchInfo = Http::withHeaders([
                'axesso-api-key' => env('AXESSO_KEY'),
                'Content-Type' => 'application/json'
            ])->get('http://api-prd2.axesso.de/wlm/walmart-search-by-keyword?keyword='.$id.'&page=1&type=text&sortBy=best_match');
            
            $response[] = [

                "productInfo" => json_decode($productInfo->body()),
                "searchInfo" => json_decode($searchInfo->body())

            ];

            return $response;


        }catch(\Exception $e){
            return response()->json(["success" => false, "err" => $e->getMessage(), "ln" => $e->getMessage()]);
        }

    
    }


}
