<?php

namespace App\Models;

use Help;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Droits extends Model {

    protected $table = "DroitsAcces";
    protected $primaryKey = "ID_DROITS_ACCES";
    public $timestamps = false;

    protected $fillable = [
        "ID_DROITS_ACCES",
        "CODE_ACCES",
        "LIB_ACCES",
        "STATUT",
        "DATECREA",
        "DATEMAJ",
    ];
    use HasFactory;

    public static function liste() {
        return Droits::where('STATUT', Help::$ACTIF)
        ->orderBy('ID_DROITS_ACCES')->get();
    }
    public static function LireCode($code) {
        return Droits::where('CODE_ACCES', $code)
        ->where('STATUT', Help::$ACTIF)->first();
    }
    public static function NbOcc() {
        return Droits::count();
    }

}
