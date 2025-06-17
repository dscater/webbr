<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClienteUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "nombre" => "required",
            "paterno" => "required",
            "materno" => "nullable",
            "ci" => "required",
            "ci_exp" => "required",
            "fono" => "required",
            "correo" => "required",
            "dir" => "required",
        ];
    }

    public function messages(): array
    {
        return [
            "nombre.required" => "Debes completar este campo",
            "paterno.required" => "Debes completar este campo",
            "materno.required" => "Debes completar este campo",
            "ci.required" => "Debes completar este campo",
            "ci_exp.required" => "Debes completar este campo",
            "fono.required" => "Debes completar este campo",
            "correo.required" => "Debes completar este campo",
            "dir.required" => "Debes completar este campo",
        ];
    }
}
