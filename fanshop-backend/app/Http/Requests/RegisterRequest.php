<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            "email" => "required|unique:users,email|email",
            "password" => "required|confirmed|min:8"
        ];
    }

    public function messages()
    {
        return [
            "name.required" => "Nombre es requerido",
            "lastname.required" => "Apellido es requerido",
            "email.required" => "Email es requerido",
            "email.unique" => "Este email ya existe",
            "email.email" => "Email no es válido",
            "password.required" =>"Claves requerida",
            "password.confirmed" => "Claves no coinciden",
            "password.min" => "Clave debe tener al menos 8 carácteres"
        ];
    }
}
