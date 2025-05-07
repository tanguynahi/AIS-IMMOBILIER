<?php

namespace App\Models;

use Help;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Prospect extends Model
{
    protected $table = "ImmoProspect";
    protected $primaryKey = "ID_PROSPECT";
    public $timestamps = false;

    protected $fillable = [
        "ID_PROSPECT",
        "CIVILITE",
        "NOM",
        "PRENOMS",
        "CONTACT",
        "NATIONALITE",
        "ADR_EMAIL",
        "LIB_VILLE",
        "ADRESSE",
        "BOITE_POSTALE",
        "STATUT",
        "DATECREA",
        "DATEMAJ",
        "ID_CLIENT" ,
        "ID_ENTREPRISE" ,
        "ID_PAYS",
        "LIB_PAYS",
        "ID_VILLE",
        "AVATAR",
    ];
    use HasApiTokens, HasFactory, Notifiable;

    public function routeNotificationForMail(){
        return $this->ADR_EMAIL;
    }


    public static function dataListe($identreprise) {
        return Prospect::orderBy('NOM')
        ->where('STATUT', Help::$ACTIF)
        ->where('ID_ENTREPRISE', $identreprise)
        ->where('ID_CLIENT', '=', 0)->get();
    }

    public static function LireSurEmail(String $email): Prospect{
        $client = Prospect::where('ADR_EMAIL', $email)->first();
        if(isset($client->ID_CLIENT) && $client->ID_CLIENT > 0) return $client;
        else return new Prospect();
    }
    public static function checkOthersEmail(String $currentemail, String $email): Prospect{
        $client = Prospect::where('ADR_EMAIL', $email)
        ->where('ADR_EMAIL', '!=', $currentemail)->first();
        if(isset($client->ID_CLIENT) && $client->ID_CLIENT > 0) return $client;
        else return new Prospect();
    }

    public static function dataDesact(int $idProspect): bool{
        $data = Prospect::find($idProspect);
        if (!empty($data->ID_PROSPECT)){
            $data->DATEMAJ = Help::dhSys();
            $data->STATUT = Help::$INACTIF;
        }
        return $data->save();
    }
}
