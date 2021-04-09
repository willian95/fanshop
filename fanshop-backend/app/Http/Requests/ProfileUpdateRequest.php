<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileUpdateRequest extends FormRequest
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
            "name" => "required",
            "lastname" => "required",
            "email" => "required|email",
            "address" => "required",
            "phone" => "required",
            "password" => "nullable|confirmed|min:8"
        ];
    }

    public function messages()
    {
        return [
            "name.required" => "Nombre es requerido",
            "lastname.required" => "Apellido es requerido",
            "email.required" => "Email es requerido",
            "email.email" => "Email no es válido",
            "address.required" => "Dirección es requerida",
            "phone.required" => "Teléfono es requerido",
            "password.confirmed" => "Contraseñas no coinciden",
            "password.min" => "Contraseña debe tener al menos caracteres"
        ];
    }
}
