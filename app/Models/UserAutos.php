<?php

namespace App\Models;

use Help;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserAutos extends Model {

    protected $table = "UserAutorises";
    protected $primaryKey = "ID_USER_AUTORISES";
    public $timestamps = false;

    protected $fillable = [
        "ID_USER_AUTORISES",
        "ID_DROITS_ACCES",
        "ID_UTILISATEUR",
        "STATUT",
        "DATECREA",
        "DATEMAJ",
        "CODE_ACCES",
    ];
    use HasFactory;

    public static function accesSA($idsa) {
        return UserAutos::where('ID_UTILISATEUR', $idsa)
        ->count();
    }

    public static function Liste($iduser) {
        return UserAutos::selectRaw('"UserAutorises".*, "DroitsAcces"."CODE_ACCES" as "CODE_ACCES"')
        ->join('DroitsAcces', 'DroitsAcces.ID_DROITS_ACCES', '=', 'UserAutorises.ID_DROITS_ACCES')
        ->where('ID_UTILISATEUR', $iduser)
        ->where('UserAutorises.STATUT', Help::$ACTIF)->get();
    }
    
    public static function LireSurID($idacces, $iduser): UserAutos{
        $acces = UserAutos::where('ID_DROITS_ACCES', $idacces)
        ->where('ID_UTILISATEUR', $iduser)->where('STATUT', Help::$ACTIF)->first();
        if(!empty($acces->ID_USER_AUTORISES)) return $acces;
        else return new UserAutos();
    }

    public static function AccesOPT(array $codeListe, $iduser): bool{
        $acces = UserAutos::orderBy('ID_USER_AUTORISES')
        ->join('DroitsAcces', 'DroitsAcces.ID_DROITS_ACCES', '=', 'UserAutorises.ID_DROITS_ACCES')
        ->whereIn('DroitsAcces.CODE_ACCES', $codeListe)
        ->where('UserAutorises.ID_UTILISATEUR', $iduser)
        ->where('DroitsAcces.STATUT', Help::$ACTIF)
        ->where('UserAutorises.STATUT', Help::$ACTIF)->get();
        if(count($acces)>0) return true;
        else return false;
    }
    
}
