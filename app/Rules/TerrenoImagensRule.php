<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class TerrenoImagensRule implements ValidationRule
{

    /**
     * Tipos de archivos permitidos.
     */
    protected $tiposPermitidos = ['image/webp', 'image/png', 'image/jpeg', 'image/jpg'];

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!is_array($value)) {
            $fail("Debes enviar un array de archivos(imagenes)");
            return;
        }

        foreach ($value as $archivo) {
            if ($archivo["id"] == 0) {
                if (is_string($archivo["file"])) {
                    $fail("El archivo {$archivo->getClientOriginalName()} no es válido.");
                    return;
                }

                // Validar tamaño (Máximo 4MB)
                if ($archivo["file"]->getSize() > 4 * 1024 * 1024) {
                    $fail("El archivo {$archivo["file"]->getClientOriginalName()} supera los 4MB.");
                    return;
                }

                // Validar tipo MIME
                if (!in_array($archivo["file"]->getMimeType(), $this->tiposPermitidos)) {
                    $fail("El archivo {$archivo["file"]->getClientOriginalName()} debe ser una imagen válida (webp, png, jpeg, jpg).");
                    return;
                }
            }
        }
    }
}
