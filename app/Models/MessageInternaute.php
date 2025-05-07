<?php

namespace App\Models;

use Help;
use App\Models\ReponseMessage;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MessageInternaute extends Model
{
    protected $table = "ImmoContact";
    protected $primaryKey = "ID_CONTACT";
    public $timestamps = false;

    protected $fillable = [
        "ID_CONTACT" ,
        "NOM_PRENOMS",
        "ID_CLIENT", // ID du client
        "CONTACT",
        "ADRESSE",
        "ADR_EMAIL",
        "SUJET",
        "EST_LU",
        "STATUT",
        "DATECREA",
        "DATEMAJ",
        "ID_ENTREPRISE",
        "ADR_IP_INTERNAUT",
        "NB_NON_LU",
    ];
    use HasFactory;

    public static function dataListe($idEntreprise) {
       $messages = MessageInternaute::orderBy('ID_CONTACT', 'desc')
       ->where('STATUT', Help::$ACTIF)
       ->where('ID_ENTREPRISE', $idEntreprise)->get();
       foreach ($messages as $key=>$m) {
           $messages[$key]->NB_NON_LU = ReponseMessage::NbNonLu($m->ID_CONTACT, Help::$E);
       }
       return $messages;
    }

    public static function dataListeCli($email) {
       $messages = MessageInternaute::orderBy('ID_CONTACT', 'desc')
       ->where('STATUT', Help::$ACTIF)
       ->where('ADR_EMAIL', $email)->get();
       foreach ($messages as $key=>$m) {
           $messages[$key]->NB_NON_LU = ReponseMessage::NbNonLu($m->ID_CONTACT, Help::$C);
       }
       return $messages;
    }

    public static function LireMessage($id) {
       return MessageInternaute::where('ID_CONTACT', $id)
       ->where('STATUT', Help::$ACTIF)->first();
    }

    public static function checkMessParJour($idEntreprise, $email){
        $data = DB::select('
            SELECT
                "ImmoContact".*
            FROM
                "ImmoContact"
            WHERE
                "ImmoContact"."ADR_EMAIL" = \''.$email.'\'
                AND "ImmoContact"."ID_ENTREPRISE" = '.$idEntreprise.'
                AND LEFT("ImmoContact"."DATECREA", 8) = \''.date("Ymd").'\'
            LIMIT 2
        ');
        return $data;
    }
}
