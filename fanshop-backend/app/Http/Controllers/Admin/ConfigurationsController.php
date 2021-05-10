<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Configuration;
use App\Http\Requests\ConfigurationUpdateRequest;

class ConfigurationsController extends Controller
{
    
    function fetch(){

        $configuration = Configuration::first();
        return response()->json(["configuration" => $configuration]);

    }

    function update(ConfigurationUpdateRequest $request){

        try{

            $config = Configuration::find(1);
            $config->max_price_without_tax = $request->maxPriceWithoutTax;
            $config->price_tax_percent = $request->priceTaxPercent / 100;
            $config->price_per_pound = $request->pricePerPound;
            $config->dolar_price = $request->dolarPrice;
            $config->earn_percentage = $request->earnPercentage / 100;
            $config->update();

            return response()->json(["success" => true, "msg" => "Configuración actualizada"]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Algo salió mal", "err" => $e->getMessage(), "ln" => $e->getLine()]);

        }


    }

}
