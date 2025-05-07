<?php

namespace App\Models;

use Help;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FichiersMessage extends Model
{
    protected $table = "ImmoFichierMessage";
    protected $primaryKey = "ID_FICHIERS";
    public $timestamps = false;

    protected $fillable = [
        "ID_FICHIERS" ,
        "ID_MESSAGES" ,
        "ID_REPONSES" ,
        "PATH_FILES" ,
        "STATUT",
        "DATECREA",
        "DATEMAJ",
    ];
    use HasFactory;

    public static function fichiersListe($idreponse) {
        return FichiersMessage::orderBy('ID_FICHIERS', 'asc')
        ->where('ID_REPONSES', $idreponse)
        ->where('STATUT', Help::$ACTIF)->get();
    }
    public static function NbFichier($idreponse) {
        return FichiersMessage::where('ID_REPONSES', $idreponse)
        ->where('STATUT', Help::$ACTIF)->count();
    }
}
