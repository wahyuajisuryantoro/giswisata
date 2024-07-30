<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wisata extends Model
{
    use HasFactory;

    protected $table = 'wisatas';
    protected $primaryKey = 'id_wisata';
    protected $fillable = ['id_admin', 'nama', 'deskripsi', 'longitude', 'latitude', 'img_url'];

    public function fotos()
    {
        return $this->hasMany(Foto::class, 'id_wisata', 'id_wisata');
    }
}
