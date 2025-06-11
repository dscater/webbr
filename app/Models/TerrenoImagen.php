<?php

namespace App\Models;

use App\Services\TerrenoImagenService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TerrenoImagen extends Model
{
    use HasFactory;

    protected $fillable = [
        "terreno_id",
        "imagen",
    ];

    protected $appends = ["url_imagen", "imagen_b64", "url_archivo", "url_file", "name", "ext"];

    public function getExtAttribute()
    {
        $array = explode(".", $this->imagen);
        return $array[1];
    }

    public function getNameAttribute()
    {
        return $this->imagen;
    }

    public function getUrlFileAttribute()
    {
        $array_imgs = ["jpg", "jpeg", "png", "webp", "gif"];
        $ext = TerrenoImagenService::getExtNomImagen($this->imagen);
        if (in_array($ext, $array_imgs)) {
            return asset("/imgs/terrenos/" . $this->imagen);
        }
        return asset("/imgs/attach.png");
    }

    public function getUrlArchivoAttribute()
    {
        return asset("imgs/terrenos/" . $this->imagen);
    }

    public function getUrlImagenAttribute()
    {
        if ($this->imagen) {
            return asset("imgs/terrenos/" . $this->imagen);
        }
        return asset("imgs/terrenos/default.png");
    }

    public function getImagenB64Attribute()
    {
        $path = public_path("imgs/terrenos/" . $this->imagen);
        if (!$this->imagen || !file_exists($path)) {
            $path = public_path("imgs/terrenos/default.png");
        }
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
        return $base64;
    }

    public function terreno()
    {
        return $this->belongsTo(Terreno::class, 'terreno_id');
    }
}
