<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProprieteImages extends Model
{
    protected $table = "ImmoProprieteImages";
    protected $primaryKey = "ID_PROP_IMAGES";
    public $timestamps = false;

    protected $fillable = [
        "ID_PROP_IMAGES" ,
        "PATH_IMAGES",
        "STATUT",
        "ID_PROPRIETES",
        "DATECREA",
        "DATEMAJ",
    ];
    use HasFactory;

    public static function dataListe(int $id, int $statut) {
        return ProprieteImages::orderBy('ID_PROP_IMAGES', 'desc')
        ->where('ID_PROPRIETES', $id)->where('STATUT', $statut)->get();
    }

}
