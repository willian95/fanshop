<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MercadoPagoDetailedStatusMessage;

class MercadoPagoStatusDetailController extends Controller
{
    
    function getMercadoPagoDetails(){

        $details = MercadoPagoDetailedStatusMessage::all();
        return response()->json(["details" => $details]);

    }

}
