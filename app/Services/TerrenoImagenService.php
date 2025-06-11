<?php

namespace App\Services;

use App\Models\Terreno;
use App\Models\TerrenoImagen;
use Illuminate\Http\UploadedFile;

class TerrenoImagenService
{
    private $pathImages = "";
    public function __construct(private  CargarArchivoService $cargarArchivoService)
    {
        $this->pathImages = public_path("imgs/terrenos");
    }

    /**
     * Cargar imagen
     *
     * @param Terreno $terreno
     * @param UploadedFile $foto
     * @return TerrenoImagen
     */
    public function guardarImagenTerreno(Terreno $terreno, UploadedFile $imagen, int $index = -1): TerrenoImagen
    {
        $nombre = ($index != -1 ? $index : 0) . $terreno->id . time();
        return $terreno->imagens()->create([
            "imagen" => $this->cargarArchivoService->cargarArchivo($imagen, $this->pathImages, $nombre)
        ]);
    }

    /**
     * Eliminacion fisica de imagen terreno
     *
     * @param TerrenoImagen $terrenoImagen
     * @return void
     */
    public function eliminarImagenTerreno(TerrenoImagen $terrenoImagen): void
    {
        $imagen = $terrenoImagen->imagen;
        if ($terrenoImagen->delete()) {
            \File::delete($this->pathImages . "/" . $imagen);
        }
        $terrenoImagen->delete();
    }

    /**
     * Obtener extension del nombre de la imagen
     * ejem: image.png -> png
     * 
     * @param string $imagen
     * @return string
     */
    public static function getExtNomImagen(string $imagen): string
    {
        $array = explode(".", $imagen);
        return $array[count($array) - 1];
    }
}
