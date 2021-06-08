<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Configuration;

class RecommendationController extends Controller
{
    
    function getRecommendations(Request $request){

        if($request->searchType == "amazon"){
            $response = $this->amazonRecommendation($request->asin);
        }

        return response()->json(["recommendations" => $response, "configuration" =>Configuration::select("dolar_price", "earn_percentage", "max_price_without_tax", "price_per_pound", "price_tax_percent")->first()]);

    }

    function amazonRecommendation($asin){

        $response = Http::withHeaders([
            'axesso-api-key' => env('AXESSO_KEY'),
            'Content-Type' => 'application/json'
        ])->get('http://api-prd.axesso.de/amz/amazon-search-by-keyword-asin?keyword='.$asin.'&domainCode=com&prime=true&sortBy=relevanceblender&page='.rand(1, 30));
        
        return $response->json();

    }

}
