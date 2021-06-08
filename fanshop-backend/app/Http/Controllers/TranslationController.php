<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;

use Illuminate\Http\Request;

class TranslationController extends Controller
{
    
    function translate(Request $request){

        $stringToTranslate = $request[0]["title"];

        $codificado = urlencode($stringToTranslate);
        $response = Http::withHeaders([
            'Content-Type' => 'application/json'
        ])->get("https://api.mymemory.translated.net/get?q=".$codificado."&langpair=en|es");

        $data = json_decode($response->body());

        return response()->json(["test" => $request->all(), "translation" => $data]);

    }

}
