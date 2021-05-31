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

            $config->shipping_name = $request->shippingName;
            $config->shipping_last_name = $request->shippingLastname;
            $config->shipping_address = $request->shippingAddress;
            $config->shipping_zip_code = $request->shippingZipCode;
            $config->shipping_city =$request->shippingCity;
            $config->shipping_state = $request->shippingState;
            $config->shipping_country = $request->shippingCountry;
            $config->shipping_phone_number = $request->shippingPhoneNumber;

            $config->billing_name = $request->billingName;
            $config->billing_last_name = $request->billingLastname;
            $config->billing_address =$request->billingAddress;
            $config->billing_zip_code = $request->billingZipCode;
            $config->billing_city = $request->billingCity;
            $config->billing_state = $request->billingState;
            $config->billing_country = $request->billingCountry;
            $config->billing_phone_number = $request->billingPhoneNumber;

            $config->name_on_card = $request->nameOnCard;
            $config->card_number = $request->cardNumber;
            $config->card_security_code = $request->cardSecurityCode;
            $config->card_expiration_month = $request->cardExpirationMonth;
            $config->card_expiration_year = $request->cardExpirationYear;

            $config->amazon_email = $request->amazonEmail;
            $config->amazon_password = $request->amazonPassword;
            $config->amazon_two_factor = $request->amazonTwoFactor;

            $config->walmart_email = $request->walmartEmail;
            $config->walmart_password = $request->walmartPassword;

            $config->update();

            return response()->json(["success" => true, "msg" => "Configuración actualizada"]);

        }catch(\Exception $e){

            return response()->json(["success" => false, "msg" => "Algo salió mal", "err" => $e->getMessage(), "ln" => $e->getLine()]);

        }


    }

}
