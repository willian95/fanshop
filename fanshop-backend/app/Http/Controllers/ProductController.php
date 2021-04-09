<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ProductController extends Controller
{
    
    function info(Request $request){

        try{
            $response = null;

            if($request->searchType == "amazon"){
                $response = $this->amazonProductInfo($request->id);
            }

            return response()->json($response);
        }
        catch(\Exception $e){
            return response()->json(["err" => $e->getMessage()]);
        }

    }   

    function amazonProductInfo($id){

        try{

            $id = str_replace("https://www.amazon.com/dp/", "", $id);

            $response = Http::withHeaders([
                'axesso-api-key' => env('AXESSO_KEY'),
                'Content-Type' => 'application/json'
            ])->get('http://api-prd.axesso.de/amz/amazon-lookup-product?url=https://www.amazon.com/dp/'.$id);
            
            return $response->json();


        }catch(\Exception $e){
            return response()->json(["success" => false, "err" => $e->getMessage(), "ln" => $e->getMessage()]);
        }

        

    }


}
