<?php

namespace App\Models;

use Help;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Bannieres extends Model {

    protected $table = "ImmoBannieres";
    protected $primaryKey = "ID_BANNIERES";
    public $timestamps = false;

    protected $fillable = [
        "ID_BANNIERES",
        "TITRE_INFO",
        "CONTENU_INFO",
        "PATH_BAN",
        "STATUT",
        "DATECREA",
        "DATEMAJ",
        "ID_ENTREPRISE"
    ];
    use HasFactory;

    public static function Liste($idE) {
        return Bannieres::where('ID_ENTREPRISE', $idE)
        ->where('STATUT', Help::$ACTIF)
        ->get();
    }

    public static function LireSurID($id): Bannieres {
        $banniere = Bannieres::where('ID_BANNIERES', $id)
        ->first();
        if(!empty($banniere->ID_BANNIERES)) return $banniere;
        else return new Bannieres();
    }

}
