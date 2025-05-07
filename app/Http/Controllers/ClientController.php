<?php

namespace App\Http\Controllers;

use Help;
use App\Models\Pays;
use App\Models\User;
use App\Models\Ville;
use App\Models\Client;
use App\Models\Affaires;
use App\Models\Paiements;
use App\Models\Entreprise;
use App\Models\Redevances;
use App\Models\RefPaiement;
use App\Models\ajaxResponse;
use Illuminate\Http\Request;
use App\Models\DemandeVisite;
use App\Models\PreuvePaiement;
use App\Models\ClientRedevances;
use App\Models\MessageInternaute;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class ClientController extends Controller
{

    public $clError = [];
    function TestRetourAPI($Param1 = []): Bool
    {
        if (is_array($Param1)) {
            if (array_key_exists("codehttp", $Param1)) {
                $this->clError = $Param1;
                return true;
            }
        } else {
            if (isset($Param1['codehttp'])) {
                $this->clError = $Param1;
                return true;
            } else {
                $this->clError = $Param1;
            }
        }
        return false;
    }
    function dmToastVersIHM($ErrorContent): string
    {
        $msg = ' ';
        if (array_key_exists("fault", $ErrorContent)) {
            if (isset($ErrorContent['fault']['faultstring'])) {
                // Retire les RC (\r\n) dans la chaine
                $msg = str_replace(array("\r\n", "\n", "\r", "\t"), ' ', $ErrorContent['fault']['faultstring']);
            }
            if (isset($ErrorContent['fault']['detail'])) {
                // Retire les RC (\r\n) dans la chaine
                $msg .= str_replace(array("\r\n", "\n", "\r", "\t"), ' ', $ErrorContent['fault']['detail']);
            }
        }
        return $msg;
    }


    public function clientTDB()
    {
        $us = Help::getAuthUser();
        $titre = "Dashboard | Immobilier-Store";
        $stats = Client::tdbStats($us->ID_CLIENT);
        $paiements = Client::paiementEnCours($us->ID_CLIENT);
        $nbProp = Affaires::NbAffaireClient($us->ID_CLIENT);
        return view('pages.client.dashboardclient', compact('titre', 'us', 'nbProp', 'paiements', 'stats'));
    }

    public function messagesClient()
    {
        $us = Help::getAuthUser();
        $titre = "Liste Messages | Immobilier-Store";
        $messages = MessageInternaute::dataListeCli($us->ADR_EMAIL);
        $entreprise = Entreprise::find(1);
        return view('pages.client.messagesclient', compact('titre', 'us', 'messages', 'entreprise'));
    }
    public function discutionMessage($id)
    {
        $us = Help::getAuthUser();
        $titre = "Discution | Immobilier-Store";
        $infosmessage = MessageInternaute::LireMessage($id);
        if (!empty($infosmessage->ID_CONTACT) && ($infosmessage->EST_LU === 0) && ($infosmessage->CONTACT === '')) {
            $infosmessage->EST_LU = 1;
            $infosmessage->save();
        }
        return view('pages.client.discutionsclient', compact('titre', 'us', 'infosmessage', 'id'));
    }
    public function nouveauMessage()
    {
        $us = Help::getAuthUser();
        $titre = "Formulaire message | Immobilier-Store";
        return view('pages.client.formmessageclient', compact('titre', 'us'));
    }

    public function demandClient()
    {
        $us = Help::getAuthUser();
        $titre = "Liste Demandes Visite | Immobilier-Store";
        $demandes = DemandeVisite::listeDemandeClient($us->ID_CLIENT);
        return view('pages.client.demandesclient', compact('titre', 'us', 'demandes'));
    }
    public function detailDemande($idDemand)
    {
        $us = Help::getAuthUser();
        $titre = "Detail Demande Visite | Immobilier-Store";
        $demande = DemandeVisite::LireSurID($idDemand);
        // dd($demande,$idDemand);
        if (!empty($demande[0])) $demande = $demande[0];
        if (!empty($demande->ID_DEMANDE_VISIT) && $demande->STATUT == Help::$ENATTENTE) {
            return view('pages.client.updatdemand', compact('titre', 'us', 'demande'));
        } else {
            return view('pages.client.detaildemand', compact('titre', 'us', 'demande'));
        }
    }
    public function saveDemande(Request $request)
    {
        $res = new ajaxResponse;
        $us = Help::getAuthUser();
        if ((isset($request->param) && $request->param > 0) && (isset($request->mess) && ($request->mess != '' && strlen($request->mess) > 10))) {
            if (isset($request->demtype) && $request->demtype <= 0) {
                $res->code = 422;
                $res->mess = "Veuillez indiquer le type de votre demande.";
                return $res;
            } else {
                if ($request->demtype == 1) {
                    $validator = Validator::make($request->all(), [
                        'date' => [
                            'required',
                            'date_format:Y-m-d',
                            'after_or_equal:' . date("Y-m-d")
                        ],
                    ]);
                    if ($validator->fails()) {
                        $res->code = 422;
                        $res->mess = "Veuillez renseigner une date de visite valide.";
                        return $res;
                    }
                }
                $data = DemandeVisite::find($request->param);
                if (isset($data->ID_DEMANDE_VISIT)) {
                    $data->DATEMAJ = Help::dhSys();
                    $data->MESSAGE = $request->mess;
                    $data->DATE_VISIT = $request->date;
                    $data->HEUR_VISIT = $request->heure;
                    $data->TYPE_DEMAND = $request->demtype;
                    if ($data->save()) {
                        $res->code = 200;
                        $res->mess = 'Enregistrée avec succès';
                    } else {
                        $res->code = 500;
                        $res->mess = "Echec de validation !";
                    }
                } else {
                    $res->code = 500;
                    $res->mess = "Une erreur s'est produite, data not found !";
                }
            }
        } else {
            $res->code = 500;
            $res->mess = "Une erreur s'est produite";
        }
        return $res;
    }
    public function desactDemande($idDemand)
    {
        $res = DemandeVisite::dataDesact($idDemand);
        return redirect()->route('demClientList');
    }


    public function listProprieteAcquis()
    {
        $us = Help::getAuthUser();
        $titre = "Proprietes Acquis | Immobilier-Store";
        $affaires = Affaires::proprieteAcquisClient($us->ID_CLIENT);
        return view('pages.client.affairesconclues', compact('titre', 'us', 'affaires'));
    }
    public function detailAffaire($idAffaire)
    {
        $us = Help::getAuthUser();
        $titre = "Detail Affaire | Immobilier-Store";
        $affaire = Affaires::cliLireAffaireClient($idAffaire);
        $liaisons = ClientRedevances::cliListeRedevanceSurAffaire($idAffaire);
        return view('pages.client.detailaffaire', compact('titre', 'us', 'affaire', 'liaisons'));
    }


    public function paiementClient()
    {
        $us = Help::getAuthUser();
        $idclient = $us->ID_CLIENT;
        $titre = "Liste Paiements | Immobilier-Store";
        return view('pages.client.paiementsclient', compact('titre', 'us', 'idclient'));
    }
    public function getLiaisAffaireSurID($id)
    {
        $us = Help::getAuthUser();
        return ClientRedevances::cliListeRedevanceSurAffaire($id);
    }
    public function getPaiementFiltre($param1, $param2)
    {
        $us = Help::getAuthUser();
        $dmin ='';
        $dmax ='';
        return Paiements::paiementSurCliIDAffIDLiaisID($us->ID_CLIENT, $param1, $param2,$dmin,$dmax);
    }
    public function paiementAffaire($idAffaire)
    {
        $us = Help::getAuthUser();
        $titre = "Liste Paiements Propriété | Immobilier-Store";
        $affaire = Affaires::cliLireAffaireClient($idAffaire);
        $paiements = Paiements::listePaiementAffaireSurID($idAffaire);
        $liaisons = ClientRedevances::cliListeRedevanceSurAffaire($idAffaire);
        return view('pages.client.paiementaffaire', compact('titre', 'us', 'affaire', 'paiements', 'liaisons', 'idAffaire'));
    }
    public function formPaiement($type, $idAffaire, $idLiais)
    {
        $lib = '';
        $us = Help::getAuthUser();
        if ($type == 'manu') $lib = ' manuel';
        else $lib = ' en ligne';
        $titre = "Paiement$lib de redevance | Immobilier-Store";
        $affaire = Affaires::cliLireAffaireClient($idAffaire);
        $liaison = ClientRedevances::cliLireFacturationSurID($idLiais);
        return view('pages.client.formpaiementP', compact('titre', 'us', 'affaire', 'liaison', 'type'));
    }
    public function savePaiement(Request $request)
    {

        $us = Help::getAuthUser();

        if ((isset($request->id) && $request->id > 0) && isset($request->refID) && isset($request->moyen) && isset($request->mont)) {

            if ($request->refID == '' || strlen($request->refID) < 4) {
                return back()->with('error', 'Veuillez renseigner une reférence valide, minimum 4 caractères.');
            }
            if ($request->moyen <= 0) {
                return back()->with('error', 'Veuillez indiquer un moyen de paiement valide.');
            }
            if ($request->mont <= 0 || $request->mont < 500) {
                return back()->with('error', 'Veuillez saisir un montant valide, montant minimum requis 500 XOF.');
            }
            $validator = Validator::make($request->all(), [
                'date' => [
                    'required',
                    'date_format:Y-m-d',
                    'before_or_equal:' . date("Y-m-d")
                ],
            ]);
            if ($validator->fails()) return back()->with('error', 'Veuillez renseigner une date valide.');

            if ($request->hasFile('preuves')) {

                $data = ClientRedevances::find($request->id);

                if (isset($data->ID_LIAIS)) {

                    $paiement = Paiements::checkReferencePaiement($request->id, $request->refID);

                    if (isset($paiement->ID_PAIEMENTS)) {
                        return back()->with('error', 'Un paiement pour cette facturation porte déjà la reférence que vous avez saisi.');
                    } else {
                        (int) $MontantPaiement = $request->mont;
                        (int) $MontantTotalPayer = $data->TOTAL_PAYER;
                        (int) $MontantTotalAPayer = $data->TOTAL_A_PAYER;
                        if ($data->ID_TYPE_PERIODE == 1) {
                            // Il s'agit d'un paiement 'Immediat'
                            if ($MontantPaiement < $MontantTotalAPayer) {
                                return back()->with('error', "Le montant à payer ne doit pas être inférieur au montant de la facturation");
                            }
                        }
                        if ($MontantTotalPayer == $MontantTotalAPayer) {
                            return back()->with('error', 'Vous êtes à jour de paiement de cette facturation');
                        } else {
                            if ($MontantTotalAPayer < ($MontantTotalPayer + $MontantPaiement)) {
                                (int) $RestApayer = ($MontantTotalAPayer - $MontantTotalPayer);
                                return back()->with('error', 'Le reste a payer pour cette facturation est de ' . Help::formatNombre($RestApayer ?? '0', true));
                            }
                        }
                        $paiement = new Paiements();
                        $paiement->ID_CLIENT = $data->ID_CLIENT;
                        $paiement->ID_LIAIS = $request->id;
                        $paiement->REFERENCE_P = $request->refID;
                        $paiement->SERVICE_ID = $request->moyen;
                        $paiement->LIB_SERVICE_ID = Help::LibelleMoyenSurID($request->moyen);
                        $paiement->NO_TRANSACTION = 'X';
                        $paiement->MONTANT = $request->mont;
                        $paiement->DATE_PAIEMENT = $request->date;
                        $paiement->HEURE_PAIEMENT = $request->heure;
                        $paiement->CHAINEJSON = json_encode($request->input());
                        $paiement->ID_REFPAIEMENT = 0;
                        $paiement->STATUT = Help::$ENATTENTE;
                        $paiement->DATECREA = Help::dhSys();
                        $paiement->ID_ENTREPRISE = $data->ID_ENTREPRISE;
                        if ($paiement->save()) {
                            foreach ($request->preuves as $key => $file) {
                                $preuve = new PreuvePaiement();
                                $fileName = trim(time() . 'FPAY-' . $file->getClientOriginalName());
                                $file->move(public_path() . '/FichiersPaiement/' . $paiement->ID_ENTREPRISE . '/', $fileName);
                                $preuve->PATH_PREUVE_PAY = '/FichiersPaiement/' . $paiement->ID_ENTREPRISE . '/' . $fileName;
                                $preuve->STATUT = Help::$ACTIF;
                                $preuve->DATECREA = date("Ymdhis");
                                $preuve->ID_PAIEMENTS = $paiement->ID_PAIEMENTS;
                                $preuve->ID_ENTREPRISE = $paiement->ID_ENTREPRISE;
                                $preuve->save();
                            }
                            return back()->with('success', 'Enregistrée avec succès.');
                        } else {
                            return back()->with('error', 'Echec de validation.');
                        }
                    }
                } else {
                    return back()->with('error', 'Une erreur s\'est produite.');
                }
            } else {
                return back()->with('error', 'Veuillez indiquer la preuve de paiement.');
            }
        } else {
            return back()->with('error', 'Oops, un soucis avec les informations du formulaire, veuillez renseigner correctement tous les champs');
        }
    }
    public function detailPaiement($idPaiement, $back)
    {
        $us = Help::getAuthUser();
        $titre = "Detail Paiement | Immobilier-Store";
        $paiement = Paiements::cliLirePaiementSurID($idPaiement);
        $affaire = Affaires::cliLireAffaireClient($paiement->ID_AFFAIRES);
        $liaison = ClientRedevances::cliLireFacturationSurID($paiement->ID_LIAIS);
        return view('pages.client.detailpaiement', compact('titre', 'us', 'paiement', 'affaire', 'liaison', 'back'));
    }


    public function updatePaiement(Request $request)
    {

        $res = new ajaxResponse;
        $us = Help::getAuthUser();

        if ((isset($request->id) && $request->id > 0) && isset($request->refID) && isset($request->moyen) && isset($request->mont)) {

            if ($request->refID == '' || strlen($request->refID) < 4) {
                $res->code = 422;
                $res->mess = "Veuillez renseigner une reférence valide, minimum 4 caractères.";
                return $res;
            }
            if ($request->moyen <= 0) {
                $res->code = 422;
                $res->mess = "Veuillez indiquer un moyen de paiement valide.";
                return $res;
            }
            if ($request->mont <= 0 || $request->mont < 500) {
                $res->code = 422;
                $res->mess = "Veuillez saisir un montant valide, montant minimum requis 500 XOF.";
                return $res;
            }
            $validator = Validator::make($request->all(), [
                'date' => [
                    'required',
                    'date_format:Y-m-d',
                    'before_or_equal:' . date("Y-m-d")
                ],
            ]);
            if ($validator->fails()) {
                $res->code = 422;
                $res->mess = "Veuillez renseigner une date valide.";
                return $res;
            }

            $paiement = Paiements::find($request->id);

            if (isset($paiement->ID_PAIEMENTS)) {
                $data = ClientRedevances::find($paiement->ID_LIAIS);
                if (isset($data->ID_LIAIS)) {
                    $paiementCheck = Paiements::checkReferencePaiement($data->ID_PAIEMENTS, $request->refID);
                    if (isset($paiementCheck->ID_PAIEMENTS)) {
                        $res->code = 422;
                        $res->mess = "Un paiement pour cette facturation porte déjà la reférence que vous avez saisi.";
                        return $res;
                    } else {
                        (int) $MontantPaiement = $request->mont;
                        (int) $MontantTotalPayer = $data->TOTAL_PAYER;
                        (int) $MontantTotalAPayer = $data->TOTAL_A_PAYER;
                        if ($data->ID_TYPE_PERIODE == 1) {
                            // Il s'agit d'un paiement 'Immediat'
                            if ($MontantPaiement < $MontantTotalAPayer) {
                                $res->code = 422;
                                $res->mess = "Le montant à payer ne doit pas être inférieur au montant de la facturation";
                                return $res;
                            }
                        }
                        if ($MontantTotalPayer == $MontantTotalAPayer) {
                            $res->code = 422;
                            $res->mess = "Vous êtes à jour de paiement de cette facturation";
                            return $res;
                        } else {
                            if ($MontantTotalAPayer < ($MontantTotalPayer + $MontantPaiement)) {
                                (int) $RestApayer = ($MontantTotalAPayer - $MontantTotalPayer);
                                $res->code = 422;
                                $res->mess = "Le reste a payer pour cette facturation est de " . Help::formatNombre($RestApayer ?? '0', true);
                                return $res;
                            }
                        }
                        $paiement->REFERENCE_P = $request->refID;
                        $paiement->SERVICE_ID = $request->moyen;
                        $paiement->LIB_SERVICE_ID = Help::LibelleMoyenSurID($request->moyen);
                        $paiement->NO_TRANSACTION = 'X';
                        $paiement->MONTANT = $request->mont;
                        $paiement->DATE_PAIEMENT = $request->date;
                        $paiement->HEURE_PAIEMENT = $request->heure;
                        $paiement->CHAINEJSON = json_encode($request->input());
                        $paiement->DATEMAJ = Help::dhSys();
                        if ($paiement->save()) {
                            $res->code = 200;
                            $res->mess = "Enregistrée avec succès.";
                            return $res;
                        } else {
                            $res->code = 500;
                            $res->mess = "Echec de validation.";
                            return $res;
                        }
                    }
                } else {
                    $res->code = 422;
                    $res->mess = "Une erreur s'est produite. data_not_found niveau 2.";
                    return $res;
                }
            } else {
                $res->code = 422;
                $res->mess = "Une erreur s'est produite. data_not_found niveau 1.";
                return $res;
            }
        } else {
            $res->code = 500;
            $res->mess = "Oops, un soucis avec les informations du formulaire, veuillez renseigner correctement tous les champs";
            return $res;
        }
    }
    public function desactPaiement($idPaiement)
    {
        Paiements::dataDesact($idPaiement);
        return redirect()->route('paiemClientList');
    }


    public function listPAYDocument($idPaiement, $back)
    {
        $us = Help::getAuthUser();
        $titre = "Document(s) Paiement | Immobilier-Store";
        $paiement = Paiements::cliLirePaiementSurID($idPaiement);
        $fichiers = PreuvePaiement::dataListe($idPaiement);
        return view('pages.client.filespaiement', compact('titre', 'us', 'paiement', 'fichiers', 'back'));
    }
    public function formPAYDocument($idPaiement, $back)
    {
        $us = Help::getAuthUser();
        $titre = "Ajout document paiement | Immobilier-Store";
        return view('pages.client.formfilespaiement', compact('titre', 'us', 'idPaiement', 'back'));
    }
    public function desactiveDocument($id)
    {
        $file = PreuvePaiement::find($id);
        if (isset($file->ID_PREUVESPAIEMENT)) {
            $file->DATEMAJ = date("Ymdhis");
            $file->STATUT = Help::$INACTIF;
            $file->save();
            if (file_exists(public_path() . $file->PATH_PREUVE_PAY)) {
                unlink(public_path() . $file->PATH_PREUVE_PAY);
            }
            return back()->with('success', "Effectué avec succès");
        } else {
            return back()->with('error', "Une erreur s'est produite");
        }
    }
    public function validGaleriePropriete(Request $request)
    {
        if (isset($request->param) && $request->param > 0) {
            $paiement = Paiements::find($request->param);
            if (isset($paiement->ID_PAIEMENTS)) {
                if ($request->hasFile('preuves')) {
                    foreach ($request->preuves as $key => $file) {
                        $preuve = new PreuvePaiement();
                        $fileName = trim(time() . 'FPAY-' . $file->getClientOriginalName());
                        $file->move(public_path() . '/FichiersPaiement/' . $paiement->ID_ENTREPRISE . '/', $fileName);
                        $preuve->PATH_PREUVE_PAY = '/FichiersPaiement/' . $paiement->ID_ENTREPRISE . '/' . $fileName;
                        $preuve->STATUT = Help::$ACTIF;
                        $preuve->DATECREA = date("Ymdhis");
                        $preuve->ID_PAIEMENTS = $paiement->ID_PAIEMENTS;
                        $preuve->ID_ENTREPRISE = $paiement->ID_ENTREPRISE;
                        $preuve->save();
                    }
                    return back()->with('success', "Enregistré avec succès");
                } else {
                    return back()->with('error', "Aucun document sélectionné.");
                }
            } else {
                return back()->with('error', "Erreur data_not_found.");
            }
        }
        return back()->with('error', "Une erreur s'est produite.");
    }


    public function infosProfil()
    {
        $us = Help::getAuthUser();
        $titre = "Profil | Immobilier-Store";
        $pays = Pays::dataListe(Help::$ACTIF);
        $client = Client::LireSurID($us->ID_CLIENT);
        $ville = Ville::dataListe($client->ID_PAYS, Help::$ACTIF);
        return view('pages.client.profilcli', compact('titre', 'us', 'pays', 'ville', 'client'));
    }
    public function validProfil(Request $request)
    {

        $us = Help::getAuthUser();

        if (
            isset($request->nom) && isset($request->prenoms) && isset($request->contact) && isset($request->nationalite)
            && isset($request->pays) && isset($request->ville) && isset($request->adresse) && isset($request->email)
        ) {

            if ($request->nom == '' || strlen($request->nom) < 4) {
                return back()->with('error', 'Veuillez saisi un nom valide, 4 caractères minimum');
            }
            if ($request->prenoms == '' || strlen($request->prenoms) < 3) {
                return back()->with('error', 'Veuillez saisi un prenoms valide, 3 caractères minimum');
            }
            if ($request->contact == '' || strlen($request->contact) < 10) {
                return back()->with('error', 'Veuillez saisir un contact valide, 10 caractères');
            }
            if ($request->nationalite == '' || strlen($request->nationalite) < 2) {
                return back()->with('error', 'Veuillez renseigner une nationalité valide');
            }
            if ($request->pays <= 0) {
                return back()->with('error', 'Veuillez indiquer le pays de residence');
            }
            if ($request->ville <= 0) {
                return back()->with('error', 'Veuillez indiquer la ville de residence');
            }
            if ($request->adresse == '' || strlen($request->adresse) < 20) {
                return back()->with('error', 'Veuillez renseigner une adresse valide, 20 caractères minimum. (ville, commune, quartier, rue...)');
            }
            $validator = Validator::make($request->all(), [
                'email' => [
                    'required',
                    'email'
                ],
            ]);
            if ($validator->fails()) return back()->with('error', 'Veuillez renseigner une adresse email valide.');

            $user = User::LireLogin($request->email);
            $client = Client::LireSurID($us->ID_CLIENT);

            if (isset($client->ID_CLIENT) && isset($user->ID_UTILISATEUR)) {

                if ((isset($request->currentpass) && $request->currentpass != '') && (isset($request->newpass) && $request->newpass != '')
                    && isset($request->newpass) && $request->newpass != ''
                ) {
                    if (Help::HashVerifier($request->currentpass, $user->SEL, $user->MOT_DE_PASSE)) {
                        if (strlen($request->newpass) < 8) {
                            return back()->with('error', 'Veuillez renseigner un mot de passe valide, 8 caractères minimum');
                        } else {
                            if ($request->newpass != $request->confirmpass) {
                                return back()->with('error', 'Nouveau et Confirmation mot de passe non conforme');
                            } else {
                                $sel = Help::ChaineAleatoire(15);
                                $user->SEL = $sel;
                                $mdp = $request->newpass;
                                $user->MOT_DE_PASSE = Help::HashPassword($mdp, $sel);
                            }
                        }
                    } else {
                        back()->with('error', 'Mot de passe actuel saisi est incorrecte');
                    }
                }
                $client->NOM = $request->nom;
                $client->PRENOMS = $request->prenoms;
                $client->CONTACT = $request->contact;
                $client->NATIONALITE = $request->nationalite;
                $client->ADRESSE = $request->adresse;
                $client->BOITE_POSTALE = $request->boiteP;
                $client->DATEMAJ = Help::dhSys();
                $client->ID_PAYS = $request->pays;
                $client->ID_VILLE = $request->ville;
                $client->LIB_VILLE = Ville::libelleSurID($request->ville);
                if ($client->save()) {
                    $user->NOM = $client->NOM;
                    $user->PRENOMS = $client->PRENOMS;
                    $user->CONTACT = $client->CONTACT;
                    $user->MDP_A_LA_CNX = false;
                    $user->DATEMAJ = Help::dhSys();
                    if ($request->hasFile('avatar')) {
                        $fileName = trim(time() . $request->avatar->getClientOriginalName());
                        $request->avatar->move(public_path() . '/AvatarClient/' . $client->ID_CLIENT . '/', $fileName);
                        $user->AVATAR = '/AvatarClient/' . $client->ID_CLIENT . '/' . $fileName;
                    }
                    $user->USER_ONLINE = true;
                    $user->save();
                    $user->SEL = "";
                    $user->MOT_DE_PASSE = "";
                    $user = Help::to_session($user);
                    return back()->with('success', 'Enregistrée avec succès.');
                } else {
                    back()->with('error', 'Une erreur s\'est produite, vos informations n\'ont été prises en compte');
                }
            } else {
                return redirect()->route('cnxPage_A');
            }
        } else {
            return back()->with('error', 'Veuillez renseigner tous les champs obligatoires');
        }
    }


    public function formPaiement_N($id)
    {
        $us = Help::getAuthUser();
        $titre = "Nouveau Paiement | Immobilier-Store";

        // $affaires = Affaires::cliListaffaireClient($us->ID_CLIENT);
        // $liaison = ClientRedevances::find($id);
        // // dd($liaison);
        // $AffID = $liaison->ID_AFFAIRES ?? 0;
        // $redevances = ClientRedevances::cliListeRedevanceSurAffaire(   $AffID);

        return view('pages.client.formpaiementN', compact('titre', 'us', 'id',));
    }
    public function infoFacturation($id)
    {
        $us = Help::getAuthUser();
        return ClientRedevances::cliLireFacturationSurID($id);
    }
    public function hubPayment(Request $request, RefPaiement $obj)
    {
        try {

            DB::beginTransaction();
            $res = new ajaxResponse;
            $us = Help::getAuthUser();

            if ((isset($request->param) && $request->param > 0) && isset($request->montant)) {
                if ($request->montant <= 0 || $request->montant < 200) {
                    $res->code = 422;
                    $res->mess = "Veuillez saisir un montant valide, montant minimum requis 200 XOF.";
                } else {
                    (int) $MontantPaiement = $request->montant;
                    $LIAS = ClientRedevances::find($request->param);
                    if (isset($LIAS->ID_LIAIS)) {
                        (int) $MontantTotalPayer = $LIAS->TOTAL_PAYER;
                        (int) $MontantTotalAPayer = $LIAS->TOTAL_A_PAYER;
                        if ($LIAS->ID_TYPE_PERIODE == 1) {
                            // Il s'agit d'un paiement 'Immediat'
                            if ($MontantPaiement < $MontantTotalAPayer) {
                                $res->code = 422;
                                $res->mess = "Le montant à payer ne doit pas être inférieur au montant de la facturation";
                                return $res;
                            }
                        }
                        if ($MontantTotalPayer == $MontantTotalAPayer) {
                            $res->code = 422;
                            $res->mess = "Vous êtes à jour de paiement de cette facturation";
                            return $res;
                        } else {
                            if ($MontantTotalAPayer < ($MontantTotalPayer + $MontantPaiement)) {
                                (int) $RestApayer = ($MontantTotalAPayer - $MontantTotalPayer);
                                $res->code = 422;
                                $res->mess = "Le reste a payer pour cette facturation est de " . Help::formatNombre($RestApayer ?? '0', true);
                                return $res;
                            }
                        }
                        $client = Client::find($LIAS->ID_CLIENT);
                        if (isset($client->ID_CLIENT)) {
                            // Génère code de paiement aléatoire
                            (string) $CodeP = RefPaiement::GenereCodePaiement($LIAS->ID_ENTREPRISE, $LIAS->ID_LIAIS, $MontantPaiement, Help::$PAY_ENLIGNE, $obj);
                            if ($CodeP == '') {
                                $res->code = 422;
                                $res->mess = "echec d'initialisation du paiement (::paycode:: :: interne ::)";
                                return $res;
                            }
                            $data['code_paiement'] = $CodeP;
                            // Informations sur le client
                            $data['nom_usager'] = $client->NOM;
                            $data['prenom_usager'] = $client->PRENOMS;
                            $data['telephone'] = $client->CONTACT;
                            $data['email'] = $client->ADR_EMAIL;
                            // Informations sur le produit à payer
                            $data['quantite'] = 1;
                            $data['montant'] = $MontantPaiement;
                            $data['libelle_article'] = Redevances::libelleSurID($LIAS->ID_REDEVANCES);
                            $data['lib_order'] = "REDEVANCE IMMOBILIERE";
                            // Données & coordonnées de retour pour notification
                            $data['Url_Logo'] = Help::_domaine() . "assets/img/logos/logo01.png";
                            $data['pay_fees'] = 1;
                            $data['Service_prive'] = 1;
                            // URL de retour sur votre site depuis notre hub de paiement
                            $data['Url_Retour'] = Help::_domaine() . 'state-payment/' . $CodeP;
                            // URL callback qui sera utilisé pour vous notifier sur la transaction de paiement
                            // $data['Url_Callback'] = route('callbackPAY');
                            $data['Url_Callback'] = Help::appelHbu()  . 'api/callbackPAYMENT';

                            $reponse = Http::withHeaders(['MerchantId' => Help::$CREDENSHEL, 'ApiKey' => 'shk_4uPVrT1mkwxwXROOUSw3oFFcTqaVMX6KdD1o'])
                                ->post(Help::lienHub(), $data);
                            // $reponse = Http::withHeaders(['MerchantId' => Help::$CREDENSHEL, 'ApiKey'=>'shk_BOSo3tcuicp1paLAHxNUeM9dNg0uEIdJEsj0'])
                            // ->post(Help::lienHub(), $data);

                            $ResJSON = $reponse->json();
                            // dump($ResJSON);
                            if ($reponse->status() === 200) {
                                if ($ResJSON['code'] === 200) {
                                    // Redirection sur le hub de paiement
                                    if (!empty($ResJSON['url'])) {
                                        $res->code = 200;
                                        $res->mess = "succes";
                                        DB::commit();
                                        $res->data = $ResJSON['url'];
                                    } else {
                                        $res->code = 200;
                                        $res->mess = "Echec d'authentification pour acceder à la page demandée !";
                                    }
                                } else {
                                    $res->code = $ResJSON['code'];
                                    $res->mess = $ResJSON['message'];
                                    return $res;
                                }
                            } else {
                                $mess = 'Une erreur inattendue s\'est produite, verifier que vous ' .
                                    'avez accès à internet, puis reéssayer. erreur ' . $reponse->status() . ', impossible de joindre l\'hôte !';
                                // $res->code = $reponse->status();
                                $res->code = 122;
                                $res->mess = $mess;
                                return $res;
                            }
                        } else {
                            $res->code = 422;
                            $res->mess = "Une erreur s'est produite. data_not_found niveau 2.";
                        }
                    } else {
                        $res->code = 422;
                        $res->mess = "Une erreur s'est produite. data_not_found niveau 1.";
                    }
                }
            } else {
                $res->code = 500;
                $res->mess = "Veuillez indiquer une redevance et saisir un montant de paiement valide.";
            }
            return $res;
        } catch (\Throwable $th) {
            //throw $th;
            $res->code = 500;
            $res->mess = "Une erreur s'est produit systemes " . $th;
            return $res;
        }
    }

    public function payCallBack($codeP)
    {
        $mess = "";
        $titre = 'Etat Paiement';
        $us = Help::getAuthUser();
        $data = RefPaiement::LireSurCode($codeP);
        if (isset($data->ID_REFPAIEMENT) && $data->ID_REFPAIEMENT > 0 && isset($data->STATUT_CODE) && $data->STATUT_CODE > 0) {
            switch ($data->STATUT_CODE) {
                case 200:
                    $mess = "Paiement effectué avec succès.";
                    break;
                default:
                    $mess = "Votre paiement a echoué.";
                    break;
            }
        } else {
            $mess = "Paiement en cours...";
        }
        return view('pages.etatpaiement', compact('titre', 'us', 'mess', 'data'));
    }
}
