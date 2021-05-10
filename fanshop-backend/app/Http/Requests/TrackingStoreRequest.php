<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TrackingStoreRequest extends FormRequest
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
            "tracking" => "required|unique:trackings,tracking"
        ];
    }

    public function messages()
    {
        return [
            "tracking.required" => "Tracking es requerido",
            "tracking.unique" => "Tracking ya existe"
        ];
    }
}
