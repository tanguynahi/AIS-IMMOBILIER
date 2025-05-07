<?php

namespace App\Models;

use Help;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Entreprise extends Model {

    protected $table = "ImmoEntreprise";
    protected $primaryKey = "ID_ENTREPRISE";
    public $timestamps = false;

    protected $fillable = [
        "ID_ENTREPRISE" ,
        "RAISON_SOCIALE",
        "ADRESSE",
        "CONTACT1",
        "CONTACT2",
        "ADR_EMAIL",
        "DESCRIPTIF",
        "SLOGAN",
        "TERMS_CONDITIONS",
        "LOGO",
        "URLFBK",
        "URLTWT",
        "URLLINK",
        "URLDEMO",
        "STATUT",
        "DATECREA",
        "DATEMAJ",
    ];
    use HasFactory;

    public static function LireSurID($id){
        $entreprise = Entreprise::where('STATUT', Help::$ACTIF)
        ->where('ID_ENTREPRISE', $id)->first();
        if(isset($entreprise->ID_ENTREPRISE)) return $entreprise;
        else return new Entreprise();
    }
    public static function LibelleEntreprise($id){
        $entreprise = Entreprise::where('STATUT', Help::$ACTIF)
        ->where('ID_ENTREPRISE', $id)->first();
        if(isset($entreprise->ID_ENTREPRISE)) return $entreprise->RAISON_SOCIALE;
        else return 'TANDEM';
    }

}
