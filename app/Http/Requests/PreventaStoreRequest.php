<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PreventaStoreRequest extends FormRequest
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
            "terreno_id" => "required",
            "cliente_id" => "required",
            "descripcion" => "required",
            "estado" => "nullable",
            "calificacion" => "nullable",
        ];
    }

    public function messages(): array
    {
        return [
            "terreno_id.required" => "Debes completar este campo",
            "cliente_id.required" => "Debes completar este campo",
            "descripcion.required" => "Debes completar este campo",
            "estado.required" => "Debes completar este campo",
        ];
    }
}
