<?php

namespace App\Models;

use Help;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TypeOffres extends Model {

    protected $table = "TypeOffres";
    protected $primaryKey = "ID_TYPE";
    public $timestamps = false;

    protected $fillable = [
        "ID_TYPE" ,
        "LIB_TYPE",
        "STATUT",
        "DATECREA",
        "DATEMAJ",
    ];
    use HasFactory;

    public static function dataListe() {
        return TypeOffres::orderBy('ID_TYPE')
        ->where('STATUT', Help::$ACTIF)->get();
    }

}
