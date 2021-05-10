<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ConfigurationUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "maxPriceWithoutTax" => "required|numeric|min:0",
            "priceTaxPercent" => "required|numeric|min:0",
            "pricePerPound" => "required|numeric|min:0",
            "dolarPrice" => "required|numeric|min:0",
            "earnPercentage" => "required|numeric|min:0",
        ];
    }

    public function messages()
    {
        return [
            "maxPriceWithoutTax.required" => "Precio máximo sin impuesto es requerido",
            "maxPriceWithoutTax.numeric" => "Precio máximo sin impuesto debe ser un número",
            "maxPriceWithoutTax.min" => "Precio máximo sin impuesto debe ser igual o mayor a 0",

            "priceTaxPercent.required" => "Impuesto por sobreprecio es requerido",
            "priceTaxPercent.numeric" => "Impuesto por sobreprecio debe ser un número",
            "priceTaxPercent.min" => "Impuesto por sobreprecio debe ser igual o mayor a 0",

            "pricePerPound.required" => "Precio por libra es requerido",
            "pricePerPound.numeric" => "Precio por libra debe ser un número",
            "pricePerPound.min" => "Precio por libra debe ser igual o mayor a 0",

            "dolarPrice.required" => "Soles por dolar es requerido",
            "dolarPrice.numeric" => "Soles por dolar debe ser un número",
            "dolarPrice.min" => "Soles por dolar debe ser igual o mayor a 0",
 
            "earnPercentage.required" => "Porcentaje es requerido",
            "earnPercentage.numeric" => "Porcentaje debe ser un número",
            "earnPercentage.min" => "Porcentaje debe ser igual o mayor a 0",
           
        ];
    }
}
