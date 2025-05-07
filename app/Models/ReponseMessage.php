<?php

namespace App\Models;

use Help;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ReponseMessage extends Model
{
    protected $table = "ImmoReponses";
    protected $primaryKey = "ID_REPONSES";
    public $timestamps = false;
    
    protected $fillable = [
        "ID_REPONSES" ,
        "ID_CONTACT" ,
        "MESSAGE" ,
        "EST_LU",
        "EST_RECEPTEUR",
        "STATUT",
        "DATECREA",
        "DATEMAJ",
        "NOM_PRENOMS",
        "NB_FILES",
    ];
    use HasFactory;

    public static function reponseListe($idmess, $recepteur) {
        $discutions = ReponseMessage::selectRaw('
            "ImmoReponses".*,
            "ImmoContact"."NOM_PRENOMS" as "NOM_PRENOMS"
        ')
        ->orderBy('ID_REPONSES', 'asc')
        ->where('ImmoReponses.ID_CONTACT', $idmess)
        ->join('ImmoContact', 'ImmoContact.ID_CONTACT', '=', 'ImmoReponses.ID_CONTACT')
        ->where('ImmoReponses.STATUT', Help::$ACTIF)->get();
        foreach ($discutions as $key=>$m) {
           $discutions[$key]->NB_NON_LU = ReponseMessage::NbNonLu($m->ID_CONTACT, $recepteur);
           $discutions[$key]->NB_FILES = FichiersMessage::NbFichier($m->ID_REPONSES);
        }
        return $discutions;
    }
    
    public static function ListResponses($idmess) {
        return ReponseMessage::selectRaw('"ImmoReponses".*')
        ->orderBy('ID_REPONSES', 'asc')
        ->where('ImmoReponses.ID_CONTACT', $idmess)
        ->join('ImmoContact', 'ImmoContact.ID_CONTACT', '=', 'ImmoReponses.ID_CONTACT')
        ->where('ImmoReponses.STATUT', Help::$ACTIF)->get();
    }
    
    public static function NbNonLu($idmess, $recepteur) {
        return ReponseMessage::where('EST_LU', '=', 0)
        ->where('ID_CONTACT', $idmess)
        ->where('EST_RECEPTEUR', $recepteur)
        ->where('STATUT', Help::$ACTIF)->count();
    }
    
}
