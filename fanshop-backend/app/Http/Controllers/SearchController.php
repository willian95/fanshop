<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Configuration;

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

        return response()->json(["success" => true, "products" => $response, "configuration" => Configuration::first()]);

    }

    function amazonSearch($queryWord, $page){
    

        $response = Http::withHeaders([
            'axesso-api-key' => env('AXESSO_KEY'),
            'Content-Type' => 'application/json'
        ])->get('http://api-prd.axesso.de/amz/amazon-search-by-keyword-asin?keyword='.$queryWord.'&domainCode=com&prime=true&sortBy=relevanceblender&page='.$page);
        
        
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
