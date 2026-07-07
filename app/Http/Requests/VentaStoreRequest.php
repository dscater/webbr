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
        $rules = [
            "terreno_id" => "required",
            "preventa_id" => "required",
            "descripcion" => "required",
            "sw_preventa" => "required",
        ];

        if ($this->sw_preventa == 1) {
            $rules["preventa_id"] = "required";
            $rules["cliente_id"] = "nullable";
        } else {
            $rules["preventa_id"] = "nullable";
            $rules["cliente_id"] = "required";
        }
        return $rules;
    }

    public function messages(): array
    {
        return [
            "terreno_id.required" => "Debes completar este campo",
            "preventa_id.required" => "Debes completar este campo",
            "cliente_id.required" => "Debes completar este campo",
            "descripcion.required" => "Debes completar este campo",
        ];
    }
}
