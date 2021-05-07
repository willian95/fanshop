<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ZincapiController extends Controller
{
    
    function requestSucceeded(Request $request){

        $data = print_r($request, true);
        $location = public_path() . '/succeed.txt';
        $store = file_put_contents($location, $data);

    }

    function requestFailed(Request $request){

        $data = print_r($request, true);
        $location = public_path() . '/failed.txt';
        $store = file_put_contents($location, $data);

    }

    function trackingObtained(Request $request){

        $data = print_r($request, true);
        $location = public_path() . '/tracking.txt';
        $store = file_put_contents($location, $data);

    }

    function statusUpdated(Request $request){

        $data = print_r($request, true);
        $location = public_path() . '/updated.txt';
        $store = file_put_contents($location, $data);

    }

}
