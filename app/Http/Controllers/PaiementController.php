<?php

namespace App\Http\Controllers;

use Help;
use App\Models\Logs;
use App\Models\Paiements;
use App\Models\RefPaiement;
use Illuminate\Http\Request;
use App\Models\NumeroPaiement;
use App\Models\ClientRedevances;

class PaiementController extends Controller
{
    public function wsCallBack(Request $request){

        $log = new Logs();
        (string) $RetourPaiementEnJSON = json_encode($request->input());
        (string) $Chaine = "Debut callback paiement, recu: ".$RetourPaiementEnJSON;

        try {

            (int) $Code = $request->code;
            (int) $Montant = $request->montant;
            (string) $CodePaiement = $request->codePaiement;

            $requetePaiementCode = RefPaiement::selectRaw('
                "ImmoRefPaiement".*,
                "ImmoClientRedevances"."ID_CLIENT" as "ID_CLIENT"
            ')
            ->join('ImmoClientRedevances', 'ImmoClientRedevances.ID_LIAIS', '=', 'ImmoRefPaiement.ID_LIAIS')
            ->where('ImmoClientRedevances.ID_CLIENT', '>', 0)
            ->where('ImmoRefPaiement.STATUT_CODE', '=', 0)
            ->where('ImmoRefPaiement.CODE_PAIEMENT', $CodePaiement)
            ->where('ImmoRefPaiement.STATUT', Help::$ACTIF)->first();

            if (isset($requetePaiementCode->ID_REFPAIEMENT) && $requetePaiementCode->ID_REFPAIEMENT>0) {

                $data = Paiements::where('ID_REFPAIEMENT', $requetePaiementCode->ID_REFPAIEMENT)
                ->where('STATUT', Help::$ACTIF)->first();

                if (!isset($data->ID_PAIEMENTS)) {

                    $log->IDCONCERNE = $requetePaiementCode->ID_ENTREPRISE;

                    $ref = NumeroPaiement::GetNumTransaction();
                    ($ref=='')? $Reference = Help::dhSys(): $Reference=$ref;

                    $paiement = new Paiements;
                    $paiement->MONTANT = $Montant;
                    $paiement->REFERENCE_P = $Reference;
                    $paiement->DATE_PAIEMENT = $request->datePaiement;
                    $paiement->HEURE_PAIEMENT = $request->HeurePaiement;
                    $paiement->ID_CLIENT = $requetePaiementCode->ID_CLIENT;
                    $paiement->ID_REFPAIEMENT = $requetePaiementCode->ID_REFPAIEMENT;
                    $paiement->ID_LIAIS = $requetePaiementCode->ID_LIAIS;
                    $paiement->NO_TRANSACTION = $request->no_transation;
                    $paiement->SERVICE_ID = $request->service_id;
                    $paiement->LIB_SERVICE_ID = $request->moyenPaiement;
                    $paiement->SOLDE_AVANT = $request->p_last_wallet_amount;
                    $paiement->SOLDE_APRES = $request->p_new_wallet_amount;
                    $paiement->CHAINEJSON = $RetourPaiementEnJSON;
                    ($Code===200)? $paiement->STATUT = 2: $paiement->STATUT=4;
                    $paiement->DATECREA = Help::dhSys();
                    $paiement->ID_ENTREPRISE = $requetePaiementCode->ID_ENTREPRISE;
                    $paiement->save();
                    
                    if ($Code===200){
                        $liaison = ClientRedevances::find($paiement->ID_LIAIS);
                        if (isset($liaison->ID_LIAIS)) {
                            $liaison->TOTAL_PAYER = $liaison->TOTAL_PAYER + $requetePaiementCode->MONTANT;
                            $liaison->REST_A_PAYER = $liaison->REST_A_PAYER - $requetePaiementCode->MONTANT;
                            $liaison->save();
                        }else{ $Chaine .= "\n** Information 'ClientRedevances' introuvable pour mise a jour du REST_A_PAYER."; }
                    }

                    $requetePaiementCode->STATUT_CODE = $Code;
                    $requetePaiementCode->REFERENCE_P = $Reference;
                    ($Code==200)? $requetePaiementCode->MESSAGE_P = 'SUCCESSFUL': $requetePaiementCode->MESSAGE_P=$request->cleretour;
                    $requetePaiementCode->DATEMAJ = Help::dhSys();
                    $requetePaiementCode->save();

                }

                $log->IDCONCERNE = $paiement->ID_LIAIS;
                $log->CONTENU = $Chaine;
                $log->DATECREA	= Help::dhSys();
                $log->TITRE = "Log callback paiement";
                $log->save();

            }else{

                $requetePaiementCode = RefPaiement::where('ImmoRefPaiement.STATUT_CODE', '!=', 0)
                ->where('ImmoRefPaiement.CODE_PAIEMENT', $CodePaiement)->first();

                if (!isset($requetePaiementCode->ID_REFPAIEMENT)) {
                    $Chaine .= "\n//// verification code paiement:#".$CodePaiement."# introuvable ou déjà notifié dans 'ImmoRefPaiement'";
                    $log->CONTENU = $Chaine;
                    $log->DATECREA	= Help::dhSys();
                    $log->TITRE = "Log callback paiement";
                    $log->save();
                }

            }

        } catch (\Throwable $th) {
            $Chaine .= "\n/// Une erreur s'est produite. DETAIL_ERR: ".$th->getMessage();
            $log->IDCONCERNE = 0;
            $log->CONTENU = $Chaine;
            $log->DATECREA	= Help::dhSys();
            $log->TITRE = "Log callback cas erreur";
            $log->save();
        }

        return 'Ok';
    }
}
