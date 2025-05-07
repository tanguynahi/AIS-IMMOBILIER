<?php

namespace App\Models;

use Help;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RefPaiement extends Model
{
    use HasFactory;

    protected $table = "ImmoRefPaiement";
    protected $primaryKey = "ID_REFPAIEMENT";
    public $timestamps = false;

    protected $fillable = [
        "ID_REFPAIEMENT",
        "CODE_PAIEMENT",
        "MONTANT",
        "ID_LIAIS",
        "DATE_PAIEMENT",
        "TYPE_PAIEMENT",
        "REFERENCE_P",
        "STATUT_CODE",
        "MESSAGE_P",
        "STATUT",
        "DATECREA",
        "DATEMAJ",
        "ID_ENTREPRISE",
    ];

    public static function GenereCodePaiement(int $idEntrep, String $idLiais, int $amount, int $type,  RefPaiement $obj) {
        $bFound = true;
        $customer_data = "";
        while ($bFound == true) {
            $customer_data = Help::strRefPaiement(8).'-'.Help::strRefPaiement(6);
            $refPaiement = self::LireSurCode($customer_data);
            if (!isset($refPaiement->ID_REFPAIEMENT)) {
                $obj->CODE_PAIEMENT = $customer_data;
                $obj->MONTANT = $amount;
                $obj->ID_LIAIS = $idLiais;
                $obj->DATE_PAIEMENT = date('Ymd');
                $obj->TYPE_PAIEMENT = $type;
                $obj->STATUT = Help::$ACTIF;
                $obj->DATECREA = Help::dhSys();
                $obj->STATUT_CODE = 0;
                $obj->ID_ENTREPRISE = $idEntrep;
                $obj->save();
                $bFound = false;
            }
        }
        return $customer_data;
    }

    public static function LireSurCode($code) {
        return RefPaiement::where('STATUT', '=', Help::$ACTIF)
        ->where('CODE_PAIEMENT', $code)->first();
    }

}
