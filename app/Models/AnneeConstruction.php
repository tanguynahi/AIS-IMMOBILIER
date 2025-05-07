<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnneeConstruction extends Model
{
    protected $table = "AnneeConstruction";
    protected $primaryKey = "ANNEE_CONST_ID";
    public $timestamps = false;

    protected $fillable = [
        "ANNEE_CONST_ID" ,
        "LIB_ANNEE_CONST" ,
        "STATUT",
        "DATECREA",
        "DATEMAJ",
    ];
    use HasFactory;

    public static function dataListe(int $statut) {
       return AnneeConstruction::orderBy('LIB_ANNEE_CONST', 'desc')
       ->where('STATUT', $statut)->get();
    }
}
