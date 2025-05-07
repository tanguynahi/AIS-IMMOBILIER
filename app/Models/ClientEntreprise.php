<?php

namespace App\Models;

use Help;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ClientEntreprise extends Model
{
    protected $table = "ImmoClientEntreprise";
    protected $primaryKey = "ID_CLIENTREPRISE";
    public $timestamps = false;

    protected $fillable = [
        "ID_CLIENTREPRISE",
        "ID_CLIENT",
        "ADR_EMAIL",
        "ID_ENTREPRISE",
        "STATUT",
        "DATECREA",
        "DATEMAJ",
    ];
    use HasFactory;

    public static function dataListe() {
        return ClientEntreprise::orderBy('ID_CLIENT')
        ->where('STATUT', Help::$ACTIF)->get();
    }
    public static function entrepriseCliListe() {
        return ClientEntreprise::orderBy('ID_CLIENT')
        ->where('ID_ENTREPRISE', Help::$ENTREPRISE)
        ->where('STATUT', Help::$ACTIF)->get();
    }

    public static function CheckClientEntreprise($email, $identreprise): ClientEntreprise{
        $client = ClientEntreprise::where('ADR_EMAIL', $email)
        ->where('ID_ENTREPRISE', $identreprise)->get()->first();
        if(isset($client->ID_CLIENTREPRISE) && $client->ID_CLIENTREPRISE>0) return $client;
        else return new ClientEntreprise();
    }
}
