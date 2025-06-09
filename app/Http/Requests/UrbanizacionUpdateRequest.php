<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UrbanizacionUpdateRequest extends FormRequest
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
            "municipio_id" => "required",
            "nombre" => "required|min:2",
        ];
    }

    public function messages(): array
    {
        return [
            "municipio_id.required" => "Debes completar este campo",
            "nombre.required" => "Debes completar este campo",
            "nombre.min" => "Debes ingresar al menos :min caracteres"
        ];
    }
}
