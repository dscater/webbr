<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VentaStoreRequest extends FormRequest
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
            "preventa_id" => "required",
            "descripcion" => "required",
        ];
    }

    public function messages(): array
    {
        return [
            "terreno_id.required" => "Debes completar este campo",
            "preventa_id.required" => "Debes completar este campo",
            "descripcion.required" => "Debes completar este campo",
        ];
    }
}
