<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PasswordUpdateRequest extends FormRequest
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
            "password" => "required|min:8|confirmed",
            "hash" => "exists:users,recoveryHash"
        ];
    }

    public function messages()
    {
        return [
            "password.required" => "Clave es requerida",
            "password.min" => "Clave debe tener al menos 8 caracteres",
            "password.confirmed" => "Claves no coinciden",
            "hash.exists" => "No está autorizado para el cambio de clave"
        ];
    }

}
