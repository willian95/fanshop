<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SearchController extends Controller
{
    
    function search(Request $request){

        $response = null;
        if($request->type == "amazon"){
            $response = $this->amazonSearch($request->queryWord, $request->page);
        }

        else if($request->type == "walmart"){
            $response = $this->walmartSearch($request->queryWord, $request->page);
        }

        return response()->json(["success" => true, "products" => $response]);

    }

    function amazonSearch($queryWord, $page){
    

        $response = Http::withHeaders([
            'axesso-api-key' => env('AXESSO_KEY'),
            'Content-Type' => 'application/json'
        ])->get('http://api-prd.axesso.de/amz/amazon-search-by-keyword-asin?keyword='.$queryWord.'&domainCode=com&sortBy=relevanceblender&page='.$page);
        
        return $response->json();
    

    }

    function walmartSearch($queryWord, $page){
        
        
        $response = Http::withHeaders([
            'axesso-api-key' => env('AXESSO_KEY'),
            'Content-Type' => 'application/json'
        ])->get('http://api-prd2.axesso.de/wlm/walmart-search-by-keyword?keyword='.$queryWord.'&page='.$page.'&type=text&sortBy=best_match');
        
        return $response->json();
    
    }

}
