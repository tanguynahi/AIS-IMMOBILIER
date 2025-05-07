<?php

namespace App\Models;

use Help;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProprietesAffaire extends Model
{
    protected $table = "ImmoProprietesAffaire";
    protected $primaryKey = "ID_PROPRIETES_AFF";
    public $timestamps = false;

    protected $fillable = [
        "ID_PROPRIETES_AFF",
        "ID_PROPRIETES",
        "LIB_PROPRIETE",
        "ID_CATEGORIES",
        "LIB_CATEGORIE",
        "ID_TYPE_PROPRIETE",
        "LIB_TYPE_PROP",
        "EST_NOUVEAU",
        "PRIX_HT",
        "SUPERFICIE",
        "NB_PIECES",
        "IMG_DEFAULT",
        "LONGITUDE",
        "LATITUDE",
        "ID_PAYS",
        "ID_VILLE",
        "ADRESSE",
        "DESCRIPTIF",
        "ANNEE_CONST",
        "NB_CHAMBRES",
        "NB_SALLE_DE_BAIN",
        "NB_GARAGE",
        "WIFI",
        "PISCINE",
        "CUSINE_EQUIPE",
        "CLIMATISATION",
        "PARKING",
        "SECURITE",
        "SALLE_DE_SPORT",
        "STATUT",
        "DATECREA",
        "DATEMAJ",
        "ID_AFFAIRES",
        "ID_ENTREPRISE",
        "ANNEE",
        "LIB_TYPE",
        "PRIX_PROMO",
    ];
    use HasFactory;

    public static function LireSurID($idAff, int $idProprietes){
        $propriete = ProprietesAffaire::selectRaw('"ImmoProprietesAffaire".*')
        ->join('ImmoAffaires', 'ImmoAffaires.ID_AFFAIRES', '=', 'ImmoProprietesAffaire.ID_AFFAIRES')
        ->where('ImmoProprietesAffaire.ID_AFFAIRES', $idAff)
        ->where('ImmoProprietesAffaire.ID_PROPRIETES', $idProprietes)->first();
        if(isset($propriete->ID_PROPRIETES_AFF)) return $propriete;
        else return new ProprietesAffaire();
    }

    public static function ProprietesAcquisClient($idClient, $idEntreprise){
        return ProprietesAffaire::selectRaw('"ImmoProprietesAffaire".*')
        ->join('ImmoAffaires', 'ImmoAffaires.ID_AFFAIRES', '=', 'ImmoProprietesAffaire.ID_AFFAIRES')
        ->join('ImmoClient', 'ImmoClient.ID_CLIENT', '=', 'ImmoAffaires.ID_CLIENT')
        ->where('ImmoClient.ID_CLIENT', $idClient)
        ->where('ImmoAffaires.STATUT', Help::$ACTIF)
        ->where('ImmoAffaires.ID_ENTREPRISE', $idEntreprise)
        ->orderBy('ImmoProprietesAffaire.ID_AFFAIRES', 'desc')->get();
    }
}
