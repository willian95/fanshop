<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class RecommendationController extends Controller
{
    
    function getRecommendations(Request $request){

        if($request->searchType == "amazon"){
            $response = $this->amazonRecommendation($request->asin);
        }

        return response()->json(["recommendations" => $response]);

    }

    function amazonRecommendation($asin){

        $response = Http::withHeaders([
            'axesso-api-key' => env('AXESSO_KEY'),
            'Content-Type' => 'application/json'
        ])->get('http://api-prd.axesso.de/amz/amazon-search-by-keyword-asin?keyword='.$asin.'&domainCode=com&sortBy=relevanceblender&page='.rand(1, 30));
        
        return $response->json();

    }

}
