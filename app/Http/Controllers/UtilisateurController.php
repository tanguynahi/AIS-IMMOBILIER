<?php

namespace App\Http\Controllers;

use Help;
use App\Models\Pays;
use App\Models\User;
use App\Models\Ville;
use App\Models\Client;
use App\Models\Droits;
use App\Models\APropos;
use App\Models\Service;
use App\Models\Affaires;
use App\Models\Prospect;
use App\Models\Bannieres;
use App\Models\Paiements;
use App\Models\UserAutos;
use App\Models\Categories;
use App\Models\Entreprise;
use App\Models\Personnels;
use App\Models\Proprietes;
use App\Models\Redevances;
use App\Models\TypeOffres;
use App\Models\TypePeriode;
use App\Models\ajaxResponse;
use Illuminate\Http\Request;
use App\Models\DemandeVisite;
use App\Models\TypePropriete;
use App\Models\ProprietesPlan;
use App\Models\ReponseMessage;
use App\Models\ProprieteImages;
use App\Models\ClientEntreprise;
use App\Models\ClientRedevances;
use App\Models\AnneeConstruction;
use App\Models\FonctionPersonnel;
use App\Models\MessageInternaute;
use App\Models\ProprietesAffaire;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Notifications\CompteClientNotification;
use App\Notifications\DemandeRejetNotification;
use App\Notifications\DemandeApprouveNotification;

class UtilisateurController extends Controller
{

    public function demLoGOut()
    {
        Help::logOut();
        return back();
    }
    public function LoGOut()
    {
        Help::logOut();
        return redirect()->route('cnxPage_A');
    }
    public function index_A()
    {
        $obj = User::LireLogin('MENDOSS');
        if (empty($obj->ID_UTILISATEUR)) {
            $obj->NOM = "DOSSO";
            $obj->PRENOMS = "MENOUGBA";
            $obj->CONTACT = "0757411021";
            $obj->ADR_EMAIL = "dossmeno41@gmail.com";
            $obj->ID_PROFIL = Help::$SA;
            $obj->LOGIN = "MENDOSS";
            $obj->MDP_A_LA_CNX = false;
            $obj->SEL = Help::ChaineAleatoire(10);
            // $obj->MOT_DE_PASSE = Help::HashPassword(substr($obj->SEL, 0, 6), $obj->SEL);
            $obj->MOT_DE_PASSE = Help::HashPassword('012024', $obj->SEL);
            $obj->AVATAR = Help::$DEFAULT_AVATAR;
            $obj->STATUT = 1;
            $obj->DATECREA = Help::dhSys();
            $obj->DATEMAJ = Help::dhSys();
            $obj->ID_CLIENT = 0;
            $obj->ID_ENTREPRISE = Help::$ENTREPRISE;
            $obj->save();
            // Initialise la table Droits
            if (empty(Droits::NbOcc())) {
                foreach (Help::codesListe() as $key => $value) {
                    $droit = new Droits();
                    $droit->CODE_ACCES = $value['code'];
                    $droit->LIB_ACCES = $value['libelle'];
                    $droit->STATUT = Help::$ACTIF;
                    $droit->DATECREA = Help::dhSys();
                    $droit->save();
                }
            }
            if (empty(UserAutos::accesSA($obj->ID_UTILISATEUR))) {
                $droit = Droits::LireCode('ZZZ');
                if (!empty($droit->ID_DROITS_ACCES)) {
                    $acces = new UserAutos();
                    $acces->ID_DROITS_ACCES = $droit->ID_DROITS_ACCES;
                    $acces->ID_UTILISATEUR = $obj->ID_UTILISATEUR;
                    $acces->STATUT = Help::$ACTIF;
                    $acces->DATECREA = Help::dhSys();
                    $acces->save();
                }
            }
        }
        // $obj = User::LireLogin('WELLNADMIN');
        // if (empty($obj->ID_UTILISATEUR)) {
        //     $obj->NOM = "ADMIN";
        //     $obj->PRENOMS = "WELL'N-IMMO";
        //     $obj->CONTACT = "0747210908";
        //     $obj->ADR_EMAIL = "contact@wellnimmobilier.com";
        //     $obj->ID_PROFIL = Help::$SA;
        //     $obj->LOGIN = "WELLNADMIN";
        //     $obj->MDP_A_LA_CNX = false;
        //     $obj->SEL = Help::ChaineAleatoire(10);
        //     $obj->MOT_DE_PASSE = Help::HashPassword(substr($obj->SEL, 0, 6), $obj->SEL);
        //     $obj->AVATAR = Help::$DEFAULT_AVATAR;
        //     $obj->STATUT = 1;
        //     $obj->DATECREA = Help::dhSys();
        //     $obj->DATEMAJ = Help::dhSys();
        //     $obj->ID_CLIENT = 0;
        //     $obj->ID_ENTREPRISE = Help::$ENTREPRISE;
        //     $obj->save();
        //     if (empty(UserAutos::accesSA($obj->ID_UTILISATEUR))){
        //         $droit = Droits::LireCode('ZZZ');
        //         if (!empty($droit->ID_DROITS_ACCES)){
        //             $acces = new UserAutos();
        //             $acces->ID_DROITS_ACCES = $droit->ID_DROITS_ACCES;
        //             $acces->ID_UTILISATEUR = $obj->ID_UTILISATEUR;
        //             $acces->STATUT = Help::$ACTIF;
        //             $acces->DATECREA = Help::dhSys();
        //             $acces->save();
        //         }
        //     }
        // }
        $act = 'auth';
        $titre = 'Connexion';
        $us = Help::getAuthUser();
        $libform = 'Connectez-vous à votre compte';
        return view("pages.auth-login", compact('act', 'titre', 'us', 'libform'));
    }

    public function ajaxCnx_A(Request $request)
    {
        $res = new ajaxResponse;
        if (isset($request->Login) && isset($request->MotDePasse)) {
            $user = User::connexion($request->Login, $request->MotDePasse);
            if ($user->ID_UTILISATEUR > 0) {
                if (isset($user->USER_ONLINE) && isset($user->ID_PROFIL) && $user->USER_ONLINE == true) {
                   if ($user->ID_PROFIL > 0) {
                        $res->code = 200;
                        $dto = Help::getdto('dto');
                        if ($user->ID_PROFIL == Help::$SA) {
                            $res->mess = "/backoffice/tableau-de-bord";
                        } else {
                            switch ($dto->var) {
                                case 'demvisit':
                                    $res->mess = "/demande-visite/$dto->id";
                                    break;
                                default:
                                    switch ($user->ID_PROFIL) {
                                        case Help::$USER:
                                        case Help::$ADMIN:
                                            $res->mess = "/backoffice/tableau-de-bord";
                                            break;

                                        case Help::$CLIENT:
                                            $res->mess = "/espace-client/tableau-de-bord";
                                            break;

                                        default:
                                            $res->code = 500;
                                            session()->forget(Help::AuthKEY());
                                            $res->mess = "Profil non autorisé !!!";
                                            break;
                                    }
                                    break;
                            }
                        }
                        session()->forget('dto');
                    } else {
                        $res->code = 500;
                        $res->mess = "Une s'est produite, coordonnées non autorisé sur la plateforme !";
                    }
                } else {
                    $res->code = 404;
                    $res->mess = "Login ou mot de passe incorrecte";
                }
            } else {
                $res->code = 422;
                $res->mess = "l'Accès à la plateforme vous a été refusé.";
            }
        } else {
            $res->code = 500;
            $res->mess = "Veuillez renseigner votre login et mot de passe !";
        }
        return $res;
    }
    public function adminTDB()
    {
        $us = Help::getAuthUser();
        $titre = "Dashboard | " . Help::$CIBLE_X;
        $nbCli = Client::NbClient();
        $chiff = Paiements::tdbStats($us->ID_ENTREPRISE);
        $nbAff = Affaires::NbAffaire($us->ID_ENTREPRISE);
        $nbPro = Proprietes::NbPropriete($us->ID_ENTREPRISE);
        $demandes = DemandeVisite::demListe($us->ID_ENTREPRISE, 'tdb');
        return view('pages.manager.dashboard', compact('titre', 'us', 'nbCli', 'chiff', 'nbAff', 'nbPro', 'demandes'));
    }


    public function listBanniere()
    {
        $us = Help::getAuthUser();
        $titre = "Bannières | " . Help::$CIBLE_X;
        $banniers = Bannieres::Liste($us->ID_ENTREPRISE);
        return view('pages.manager.bannieres', compact('titre', 'us', 'banniers'));
    }
    public function formBanniere($id)
    {
        $us = Help::getAuthUser();
        $titre = "Formulaire Bannière | " . Help::$CIBLE_X;
        $banniere = Bannieres::LireSurID($id);
        return view('pages.manager.formbanniere', compact('titre', 'us', 'id','banniere'));
    }

    //traitement du store banniere


    public function storeBaniere(Request $request,$id)
    {
        // dd($request->all(),$id);
        $us = Help::getAuthUser();
        try {
            DB::beginTransaction();
            // dd($request->all(),$id);

            $validator = Validator::make($request->all(), [
                'libelle' => 'required|string|max:255',
                'description' => 'nullable|string|max:255',
                'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',  // Max size limit of 2MB (2048 KB)
                // 'termsconditions' => 'nullable|image|mimes:jpeg,png,jpg,gif,pdf,docx',
            ], [
                'libelle.required' => 'Le champ libelle est obligatoire.',
                'libelle.string' => 'Le champ libelle doit être une chaîne de caractères.',
                'libelle.max' => 'Le champ libelle ne doit pas dépasser 255 caractères.',

                'description.string' => 'Le champ description doit être une chaîne de caractères.',
                'description.max' => 'Le champ description ne doit pas dépasser 255 caractères.',

                // 'avatar.required' => 'L images est obligatoire.',
                'avatar.image' => 'Le avatar doit être une image.',
                'avatar.mimes' => 'Le avatar doit être un fichier de type: jpeg, png, jpg, gif.',
                'avatar.max' => 'Le avatar ne doit pas dépasser 2MB.',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            $banniere = Bannieres::LireSurID($id);
            $avatar = null;
            if (!empty($request->avatar) && ($request->hasFile('avatar'))) {
                $fileName = trim(time() . 'LOG_' . $request->file('avatar')->getClientOriginalName());
                $request->file('avatar')->move(public_path('filesBANN'), $fileName);
                $avatar = '/filesBANN/' . $fileName;
            } else {
                $avatar = $banniere->PATH_BAN;
            }

            $banniere->TITRE_INFO = $request->libelle;
            $banniere->CONTENU_INFO = $request->description;
            $banniere->ID_ENTREPRISE = $us->ID_ENTREPRISE;
            $banniere->PATH_BAN = $avatar ?? $banniere->PATH_BAN;
            $banniere->DATEMAJ = Help::dhSys();
            $banniere->STATUT = Help::$ACTIF;
            $banniere->DATECREA = Help::dhSys();
            if ($banniere->save()) {
                DB::commit();
                return redirect()->route('banniereList')->with('success', 'Les informations ont été mises à jour avec succès.');
            }
        } catch (\Throwable $e) {
            return redirect()->route('banniereList')->with('error', 'Une erreur est survenue : ' . $e->getMessage());
        }



    }


    public function desactiveBanniere($idFile)
    {
        $obj = Bannieres::LireSurID($idFile);
        if (!empty($obj->ID_BANNIERES)) {
            if (file_exists(public_path() . '/' . $obj->PATH_BAN)) {
                unlink(public_path() . '/' . $obj->PATH_BAN);
            }
            $obj->STATUT = Help::$INACTIF;
            $obj->DATEMAJ = Help::dhSys();
            $obj->save();
            return back()->with('success', "Supprimée avec succès");
        } else {
            return back()->with('error', "Une erreur s'est produite");
        }
    }


    public function listPropriete()
    {
        $us = Help::getAuthUser();
        $titre = "Liste Proprietes | " . Help::$CIBLE_X;
        $proprietes = Proprietes::proprietesTous($us->ID_ENTREPRISE);
        return view('pages.manager.proprietes', compact('titre', 'us', 'proprietes'));
    }
    public function formPropriete($id)
    {
        $us = Help::getAuthUser();
        $types = TypePropriete::dataListe(Help::$ACTIF);
        $categories = Categories::dataListe(Help::$ACTIF);
        $pays = Pays::dataListe(Help::$ACTIF);
        $annee = AnneeConstruction::dataListe(Help::$ACTIF);
        if ($id > 0) $propriete = Proprietes::where('ID_PROPRIETES', $id)->get()->first();
        else $propriete = new Proprietes();
        $titre = "Formulaire Propriete | " . Help::$CIBLE_X;
        return view('pages.manager.formpropriete', compact('titre', 'us', 'id', 'types', 'categories', 'pays', 'annee', 'propriete'));
    }
    public function getVilleList($IDPays)
    {
        return Ville::dataListe($IDPays, Help::$ACTIF);
    }
    public function getInfosCategorie($idcateG)
    {
        return Categories::LireSurID($idcateG);
    }
    public function lirePropriete($id)
    {
        return Proprietes::LireSurID($id);
    }
    public function validPropriete(Request $request, Proprietes $obj)
    {
        $res = new ajaxResponse;
        $us = Help::getAuthUser();
        if (isset($us->ID_UTILISATEUR) && $us->ID_UTILISATEUR > 0) {
            $obj->ID_ENTREPRISE = $us->ID_ENTREPRISE;
            $obj = Proprietes::dataSave($request, $obj);
            if (isset($obj->ID_PROPRIETES)) {
                $res->data = [];
                $res->code = 200;
                $res->mess = "Propriete enregistrée avec succès";
            } else {
                $res->code = 404;
                $res->mess = "Une erreur s'est produite !";
            }
        } else {
            $res->code = 500;
            $res->mess = "Erreur interne du serveur !";
        }
        return $res;
    }
    public function desactivePropriete($id)
    {
        if (Proprietes::dataDesact($id)) return back()->with('success', "Supprimée avec succès");
        else return back()->with('error', "Une erreur s'est produite");
    }


    public function listGalerie($idPropriete)
    {
        $us = Help::getAuthUser();
        $titre = "Galerie Propriete | " . Help::$CIBLE_X;
        $propriete = Proprietes::LireSurID($idPropriete);
        $plan = ProprietesPlan::dataListe($idPropriete, Help::$ACTIF);
        $othersFile = ProprieteImages::dataListe($idPropriete, Help::$ACTIF);
        return view('pages.manager.galeriepropriete', compact('titre', 'us', 'propriete', 'plan', 'othersFile'));
    }
    public function formGalerie($idPropriete)
    {
        $us = Help::getAuthUser();
        $titre = "Formulaire Galerie | " . Help::$CIBLE_X;
        return view('pages.manager.formgalerie', compact('titre', 'us', 'idPropriete'));
    }
    public function validGaleriePropriete(Request $request)
    {
        if (isset($request->IDProprietes) && $request->IDProprietes > 0) {
            // Image Principale
            if ($request->hasFile('DefaultFile')) {
                $property = Proprietes::LireSurID($request->IDProprietes);
                if (isset($property->ID_PROPRIETES) && $property->ID_PROPRIETES > 0) {
                    $fileName = trim(time() . 'DFLT' . $request->DefaultFile->getClientOriginalName());
                    $request->DefaultFile->move(public_path() . '/PhotoPropriete/', $fileName);
                    $property->IMG_DEFAULT = '/PhotoPropriete/' . $fileName;
                    $property->DATEMAJ = Help::dhSys();
                    $property->save();
                }
            }
            // Image(s) associée(s)
            if ($request->hasFile('OthersFiles')) {
                foreach ($request->OthersFiles as $key => $file) {
                    $others = new ProprieteImages();
                    $others->ID_PROPRIETES = $request->IDProprietes;
                    $fileName = trim(time() . $file->getClientOriginalName());
                    $file->move(public_path() . '/PhotoPropriete/', $fileName);
                    $others->PATH_IMAGES = '/PhotoPropriete/' . $fileName;
                    $others->STATUT = Help::$ACTIF;
                    $others->DATECREA = Help::dhSys();
                    $others->save();
                }
            }
            // Plan(s) de la Propriéte
            if ($request->hasFile('Plan')) {
                foreach ($request->Plan as $key => $file) {
                    $PlanProp = new ProprietesPlan();
                    $PlanProp->ID_PROPRIETES = $request->IDProprietes;
                    $fileName = trim(time() . $file->getClientOriginalName());
                    $file->move(public_path() . '/PlanPropriete/', $fileName);
                    $PlanProp->PATH_PLAN = '/PlanPropriete/' . $fileName;
                    $PlanProp->STATUT = Help::$ACTIF;
                    $PlanProp->DATECREA = Help::dhSys();
                    $PlanProp->save();
                }
            }
            return redirect()->route('galerieList', ['idPropriete' => $request->IDProprietes]);
        }
    }
    public function desactiveGalerie($idFile, $type)
    {
        switch ($type) {
                // Image default
            case 1:
                $property = Proprietes::LireSurID($idFile);
                if (isset($property->ID_PROPRIETES) && $property->ID_PROPRIETES > 0) {
                    if (file_exists(public_path() . $property->IMG_DEFAULT)) {
                        unlink(public_path() . $property->IMG_DEFAULT);
                    }
                    $property->IMG_DEFAULT = '';
                    $property->DATEMAJ = Help::dhSys();
                    $property->save();
                    return back()->with('success', "Supprimée avec succès");
                } else {
                    return back()->with('error', "Une erreur s'est produite");
                }
                break;

                // Image associété
            case 2:
                $others = ProprieteImages::find($idFile);
                if (isset($others->ID_PROP_IMAGES)) {
                    $others->DATEMAJ = Help::dhSys();
                    ($others->STATUT == 1) ? $others->STATUT = Help::$INACTIF : $others->STATUT = Help::$ACTIF;
                    $others->save();
                    if (file_exists(public_path() . $others->PATH_IMAGES)) {
                        unlink(public_path() . $others->PATH_IMAGES);
                    }
                    return back()->with('success', "Supprimée avec succès");
                } else {
                    return back()->with('error', "Une erreur s'est produite");
                }
                break;

                // Plan
            case 3:
                $PlanProp = ProprietesPlan::find($idFile);
                if (isset($PlanProp->ID_PLAN_PROP)) {
                    $PlanProp->DATEMAJ = Help::dhSys();
                    ($PlanProp->STATUT == 1) ? $PlanProp->STATUT = Help::$INACTIF : $PlanProp->STATUT = Help::$ACTIF;
                    $PlanProp->save();
                    if (file_exists(public_path() . $PlanProp->PATH_PLAN)) {
                        unlink(public_path() . $PlanProp->PATH_PLAN);
                    }
                    return back()->with('success', "Supprimée avec succès");
                } else {
                    return back()->with('error', "Une erreur s'est produite");
                }
                break;

            default:
                return back()->with('error', "Une erreur s'est produite");
                break;
        }
    }


    public function messagesClient()
    {
        $us = Help::getAuthUser();
        $titre = "Liste Messages Internautes | " . Help::$CIBLE_X;
        $messages = MessageInternaute::dataListe($us->ID_ENTREPRISE);
        $entreprise = Entreprise::find($us->ID_ENTREPRISE);
        return view('pages.manager.messages', compact('titre', 'us', 'messages','entreprise'));
    }
    public function discutionMessage($id)
    {
        $us = Help::getAuthUser();
        $titre = "Discution | " . Help::$CIBLE_X;
        $infosmessage = MessageInternaute::LireMessage($id);
        if (!empty($infosmessage->ID_CONTACT) && ($infosmessage->EST_LU === 0) && ($infosmessage->CONTACT != '')) {
            $infosmessage->EST_LU = 1;
            $infosmessage->save();
        }
        $entreprise = Entreprise::find($us->ID_ENTREPRISE);
        return view('pages.manager.discutions', compact('titre', 'us', 'infosmessage', 'id','entreprise'));
    }
    public function nouveauMessage()
    {
        $us = Help::getAuthUser();
        $titre = "Formulaire message | " . Help::$CIBLE_X;
        return view('pages.manager.form-message', compact('titre', 'us'));
    }


    public function demandVisit()
    {
        $us = Help::getAuthUser();
        $titre = "Liste Demandes Visite | " . Help::$CIBLE_X;
        $demandes = DemandeVisite::demListe($us->ID_ENTREPRISE, 'list');
        return view('pages.manager.demandes', compact('titre', 'us', 'demandes'));
    }
    public function detailDemVisit($idDemand)
    {
        $us = Help::getAuthUser();
        $titre = "Detail Demande Visite | " . Help::$CIBLE_X;
        $proprietes = Proprietes::dataListe($us->ID_ENTREPRISE);
        $demande = DemandeVisite::demLireSurID($us->ID_ENTREPRISE, $idDemand);
        if (isset($demande[0])) $demande = $demande[0];
        return view('pages.manager.dem-detail', compact('titre', 'us', 'demande', 'proprietes'));
    }
    public function updateVisit(Request $request)
    {
        $res = new ajaxResponse;
        $us = Help::getAuthUser();
        if ((isset($request->param) && $request->param > 0) && (isset($request->property) && $request->property > 0))
        {
            if (isset($request->demtype) && $request->demtype <= 0)
            {
                $res->code = 422;
                $res->mess = "Veuillez indiquer le type de la demande.";
                return $res;
            } else
            {
                $data = DemandeVisite::find($request->param);
                if (isset($data->ID_DEMANDE_VISIT))
                {
                    if ($data->STATUT == Help::$REFUSE) {
                        if ((isset($request->motif) && ($request->motif != '' && strlen($request->motif) < 10))) {
                            $res->code = 422;
                            $res->mess = "Veuillez renseigner un motif de refus valide, minimum 10 caractères.";
                            return $res;
                        }
                    }
                    if ($request->demtype == 1) {
                        if ($data->DATE_VISIT != $request->date) {
                            $validator = Validator::make($request->all(), [
                                'date' => [
                                    'required',
                                    'date_format:Y-m-d',
                                    'after_or_equal:' . date("Y-m-d")
                                ],
                            ]);
                            if ($validator->fails()) {
                                $res->code = 422;
                                $res->mess = "Veuillez renseigner une date de demande de visite valide.";
                                return $res;
                            }
                        }
                    }
                    $data->DATEMAJ = Help::dhSys();
                    $data->MOTIFS = $request->motif;
                    $data->DATE_VISIT = $request->date;
                    $data->HEUR_VISIT = $request->heure;
                    $data->TYPE_DEMAND = $request->demtype;
                    $data->ID_PROPRIETES = $request->property;
                    $data->ID_UTILISATEUR = $us->ID_UTILISATEUR;
                    if ($data->save()) {
                        $res->code = 200;
                        $res->mess = 'success';
                    } else {
                        $res->code = 500;
                        $res->mess = "Echec de validation !";
                    }
                } else {
                    $res->code = 500;
                    $res->mess = "Une erreur s'est prouite 1904";
                }
            }
        } else
        {
            $res->code = 500;
            $res->mess = "Une erreur s'est prouite";
        }
        return $res;
    }
    public function approuveVisit($id)
    {
        $res = new ajaxResponse;
        $us = Help::getAuthUser();
        $data = DemandeVisite::find($id);
        if (isset($data->ID_DEMANDE_VISIT)) {
            $propriete = Proprietes::LireSurID($data->ID_PROPRIETES);
            if (isset($propriete->ID_PROPRIETES) && $propriete->ID_PROPRIETES > 0) {
                $data->STATUT = Help::$ACTIF;
                $data->DATEMAJ = Help::dhSys();
                $data->ID_UTILISATEUR = $us->ID_UTILISATEUR;
                if ($data->save()) {
                    $prospect = Prospect::find($data->ID_CLIENT);
                    if ($prospect->STATUT == Help::$INACTIF) {
                        $prospect->STATUT = Help::$ACTIF;
                        $prospect->DATEMAJ = Help::dhSys();
                        $prospect->save();
                    }
                    $res->code = 200;
                    $res->mess = 'success';
                    // Notifi client : [mail, database]

                    $libelleEntreprise = Entreprise::LibelleEntreprise(1);
                    $sujet = "Demande approuvee chez $libelleEntreprise";

                    $NomPrenoms = $prospect->NOM.' '.$prospect->PRENOMS;
                    $dateh = Help::dateheureFormate(Help::dhSys(),'/');
                    $libdemand = empty($data->TYPE_DEMAND)? '': Help::LibelleTypeDemande($data->TYPE_DEMAND);
                    $date = empty($data->DATE_VISIT)? 'JJ/MM/AAAA': $data->DATE_VISIT;
                    $heure = empty($data->HEUR_VISIT)? 'HH:MM': $data->HEUR_VISIT;
                    $annee = empty($propriete->ANNEE)? 'x': $propriete->ANNEE;
                    $adresse = empty($propriete->ADRESSE)? 'x': $propriete->ADRESSE;
                    $libpropriete = empty($propriete->LIB_PROPRIETE)? 'x': $propriete->LIB_PROPRIETE;
                    $libcategorie = empty($propriete->LIB_CATEGORIE)? 'x': $propriete->LIB_CATEGORIE;
                    $libtype = empty($propriete->LIB_TYPE)? 'x': $propriete->LIB_TYPE;
                    $prix = empty($propriete->PRIX_HT)? '0 XOF': Help::formatNombre($propriete->PRIX_HT, true);
                    $domaine = Help::_domaine();

                    $message = "
                    <p>
                        Abidjan le: $dateh <br>
                        Objet : Demande de <b>$libdemand</b>.
                    </p>
                    <p>
                        Bonjour $NomPrenoms,
                    </p>
                    <p>
                        Votre  demande de <b>$libdemand</b>
                        a été approuvee avec succès, <br>
                        <br>";

                        if ($data->TYPE_DEMAND==1) {
                            $message .= "Date visite : $date <br>
                            Heure : $heure <br>
                            <br>";
                        }

                        $message .= "
                        Propriete : $libpropriete <br>
                        Categorie : $libcategorie <br>
                        Type : $libtype <br>
                        Année : $annee <br>
                        Adresse : $adresse <br>
                        Prix : <b>$prix</b> <br>
                        <br>
                        NB: Vous serez contacté dans les 24H via nos differents canaux (email & appel). <br>
                        <br>
                        Plus d'infos sur nos services : $domaine"."nous-contacter <br>
                        <br>
                        Nous vous remercions de la confiance que vous nous accordez. <br>
                        Cordialement, <br>
                        L'équipe Ligne, disponible 7j/7 via votre espace client <br>
                        - Pour une assistance technique <br>
                        - Pour une assistance commerciale
                        <br><br>
                        Ceci est un mail automatique, vous ne pouvez pas y répondre. <br>
                        Contactez-nous directement via votre espace client via la rubrique MESSAGE. <br>
                    </p>
                    ";

                    // $url = "https://mailtremo.paysecurehub.com/api/sendemail";
                    $url = Help::appelApiEmail();

                    $template = View::make('emails.mail', ['contenumess' => $message])->render();

                    $data = [
                        'provider' => $libelleEntreprise.'<info@mail-taseti.com>',
                        "key_rsa" => 're_2i7H3Ynf_KRVm9VwTsrwrfF8isCBYvyyE',
                        "destination" => $prospect->ADR_EMAIL,
                        "sujet" => $sujet,
                        "message" => $template
                    ];
                    $retourAPI = Http::post($url, $data);



                    //---- envoyer de mail ----///
                    // $prospect->notify(new DemandeApprouveNotification($prospect, $propriete, $data));
                } else {
                    $res->code = 500;
                    $res->mess = "Echec de validation !";
                }
            } else {
                $res->code = 500;
                $res->mess = "Une erreur s'est produite, propriété de la demande invalide ou introuvable !";
            }
        } else {
            $res->code = 500;
            $res->mess = "Une erreur s'est prouite";
        }
        return $res;
    }
    public function rejetVisit(Request $request)
    {
        $res = new ajaxResponse;
        $us = Help::getAuthUser();
        if ((isset($request->param) && $request->param > 0) && (isset($request->motif) && ($request->motif != '' && strlen($request->motif) > 10))) {
            $data = DemandeVisite::find($request->param);
            if (isset($data->ID_DEMANDE_VISIT)) {
                $propriete = Proprietes::LireSurID($data->ID_PROPRIETES);
                if (isset($propriete->ID_PROPRIETES) && $propriete->ID_PROPRIETES > 0) {
                    $data->STATUT = Help::$REFUSE;
                    $data->DATEMAJ = Help::dhSys();
                    $data->MOTIFS = $request->motif;
                    $data->ID_UTILISATEUR = $us->ID_UTILISATEUR;
                    if ($data->save()) {
                        $prospect = Prospect::find($data->ID_CLIENT);
                        $prospect->STATUT = Help::$INACTIF;
                        $prospect->DATEMAJ = Help::dhSys();
                        $prospect->save();
                        $res->code = 200;
                        $res->mess = 'success';
                        // Notifi client : [mail, database]
                        $prospect->notify(new DemandeRejetNotification($prospect, $propriete, $data));
                    } else {
                        $res->code = 500;
                        $res->mess = "Echec de validation !";
                    }
                } else {
                    $res->code = 500;
                    $res->mess = "Une erreur s'est produite, propriété de la demande invalide ou introuvable !";
                }
            } else {
                $res->code = 500;
                $res->mess = "Une erreur s'est prouite";
            }
        } else {
            $res->code = 500;
            $res->mess = "Une erreur s'est prouite";
        }
        return $res;
    }


    public function listProspect()
    {
        $us = Help::getAuthUser();
        $titre = "Liste Prospect | " . Help::$CIBLE_X;
        $prospects = Prospect::dataListe($us->ID_ENTREPRISE);
        return view('pages.manager.prospects', compact('titre', 'us', 'prospects'));
    }
    public function validProspect($id)
    {
        try {
            DB::beginTransaction();
            if ($id != null && $id > 0) {

                $us = Help::getAuthUser();
                $entreprise = Entreprise::LireSurID($us->ID_ENTREPRISE);

                $prospect = Prospect::where('ID_PROSPECT', $id)->first();

                if (isset($prospect->ID_PROSPECT) && $prospect->ID_PROSPECT > 0) {

                    $client = Client::LireSurEmail($prospect->ADR_EMAIL);

                    if (isset($client->ID_CLIENT) && $client->ID_CLIENT > 0) {
                        // Check si déjà client pour l'entreprise en cours.
                        $cliEntreprise = ClientEntreprise::CheckClientEntreprise($prospect->ADR_EMAIL, $prospect->ID_ENTREPRISE);
                        if (isset($cliEntreprise->ID_CLIENTREPRISE) && $cliEntreprise->ID_CLIENTREPRISE > 0) {
                            $prospect->ID_CLIENT = $client->ID_CLIENT;
                            $prospect->save();
                            $mess = "Validé avec succès! Pour info: cet prospect fait déjà partir de vos client depuis le " .
                                Help::dateheureFormate($client->DATECREA, '/');
                            return back()->with('success', $mess);
                        } else {
                            // Save client entreprise
                            $data = new ClientEntreprise();
                            $data->STATUT = Help::$ACTIF;
                            $data->DATECREA = Help::dhSys();
                            $data->ADR_EMAIL = $client->ADR_EMAIL;
                            $data->ID_CLIENT = $client->ID_CLIENT;
                            $data->ID_ENTREPRISE = $prospect->ID_ENTREPRISE;
                            if ($data->save()) {
                                $prospect->ID_CLIENT = $data->ID_CLIENT;
                                $prospect->save();
                                return back()->with('success', "Validé avec succès");
                            } else {
                                return back()->with('error', "Une erreur s'est produite, echec de validation");
                            }
                        }
                    } else {
                        $obj = new Client();
                        $obj->CIVILITE = $prospect->CIVILITE;
                        $obj->NOM = $prospect->NOM;
                        $obj->PRENOMS = $prospect->PRENOMS;
                        $obj->CONTACT = $prospect->CONTACT;
                        $obj->NATIONALITE = $prospect->NATIONALITE;
                        $obj->ADR_EMAIL = $prospect->ADR_EMAIL;
                        $obj->ADRESSE = $prospect->ADRESSE;
                        $obj->BOITE_POSTALE = 'xxxx - xxxxx - xxxxxx';
                        $obj->STATUT = Help::$ACTIF;
                        $obj->DATECREA = Help::dhSys();
                        $obj->ID_PAYS = $prospect->ID_PAYS;
                        $obj->ID_VILLE = $prospect->ID_VILLE;
                        $obj->LIB_VILLE = $prospect->LIB_VILLE;
                        if ($obj->save()) {
                            $sel = Help::ChaineAleatoire(15);
                            $mdp = substr($sel, 0, 6);
                            $user = new User;
                            $user->NOM = $obj->NOM;
                            $user->PRENOMS = $obj->PRENOMS;
                            $user->CONTACT = $obj->CONTACT;
                            $user->ADR_EMAIL = $obj->ADR_EMAIL;
                            $user->LOGIN = $user->ADR_EMAIL;
                            $user->SEL = $sel;
                            $user->MDP_A_LA_CNX = false;
                            $user->MOT_DE_PASSE = Help::HashPassword($mdp, $sel);
                            $user->AVATAR = '/avatar-bg.png';
                            $user->STATUT = Help::$ACTIF;
                            $user->DATECREA = Help::dhSys();
                            $user->ID_PROFIL = Help::$CLIENT;
                            $user->ID_CLIENT = $obj->ID_CLIENT;
                            // $user->ID_ENTREPRISE = $us->ID_ENTREPRISE;
                            if ($user->save()) {
                                // Notifi client : [mail, database]
                                $subjet = "Identifants de votre compte $entreprise->RAISON_SOCIALE";
                                $NomPrenoms = $user->NOM . ' ' . $user->PRENOMS;
                                $dateh = Help::dateheureFormate(Help::dhSys(), '/');
                                $domaine = Help::_domaine();
                                $id = $user->ID_UTILISATEUR;
                                $login = $user->LOGIN;
                                $message = "
                                    <p>
                                        Abidjan le: $dateh <br>
                                       Objet : Mot de passe et / ou Identifiant client.</b>
                                    </p>
                                    <p>
                                        Bonjour $NomPrenoms,<br />
                                        Compte client : IMS-00$id
                                    </p>
                                    <p>
                                        <br>
                                        Votre nouvel identifiant client vient d'être créer, ci-après vos paramètres : <br>
                                        <br>
                                        Login : $login<br>
                                        Mot de passe : $mdp <br />
                                        <br>
                                        NB: Pensez à modifier votre mot de passe. <br>
                                        <br>
                                        Connectez vous à votre espace client à partir ce lien : <br>
                                        <br> $domaine" . "connexion <br>
                                        <br>
                                        Plus d'infos sur nos services : $domaine" . "nous-contacter <br>
                                        <br>
                                        Nous vous remercions de la confiance que vous nous accordez. <br>
                                        Cordialement, <br>
                                        L'équipe Ligne, disponible 7j/7 via votre espace client <br>
                                        - Pour une assistance technique <br>
                                        - Pour une assistance commerciale
                                        <br><br>
                                        Ceci est un mail automatique, vous ne pouvez pas y répondre. <br>
                                        Contactez-nous directement via votre espace client via la rubrique MESSAGE. <br>
                                    </p>
                                    ";

                                $url = Help::appelApiEmail();
                                $template = View::make('emails.mail', ['contenumess' => $message,'entreprise'=> $entreprise])->render();

                                $data = [
                                    "provider" => $entreprise->RAISON_SOCIALE . ' <info@mail-taseti.com>',
                                    "key_rsa" => 're_2i7H3Ynf_KRVm9VwTsrwrfF8isCBYvyyE',
                                    "destination" => $user->ADR_EMAIL ?? $obj->ADR_EMAIL,
                                    "sujet" => $subjet,
                                    "message" => $template
                                ];
                                $retourAPI = Http::post($url, $data);


                                if ($retourAPI->status() === 200) {
                                    if ($retourAPI['status'] === 200) {
                                                 // Save client entreprise
                                            $data = new ClientEntreprise();
                                            $data->STATUT = Help::$ACTIF;
                                            $data->DATECREA = Help::dhSys();
                                            $data->ADR_EMAIL = $obj->ADR_EMAIL;
                                            $data->ID_CLIENT = $obj->ID_CLIENT;
                                            $data->ID_ENTREPRISE = $prospect->ID_ENTREPRISE;
                                            if ($data->save()) {
                                                $prospect->ID_CLIENT = $data->ID_CLIENT;
                                                $prospect->save();
                                                DB::commit();
                                                return back()->with('success', "Validé avec succès");
                                            } else {
                                                return back()->with('error', "Une erreur s'est produite, echec de validation");
                                            }
                                    } else {
                                        if ($retourAPI['status'] == 422) {
                                            $mess = Help::messageBrut($retourAPI['message']);
                                        } else {
                                            $mess = $retourAPI['message'];
                                        }
                                    }
                                } else {
                                    $mess = 'Une erreur inattendue s\'est produite, verifier que vous avez accès à internet, ' .
                                        'puis reéssayer. erreur ' . $retourAPI->status();
                                }
                                return back()->with('error', $mess);
                                // $user->notify(new CompteClientNotification($user));
                            } else {
                                return back()->with('error', "Une erreur s'est produite, echec de validation");
                            }
                        } else {
                            return back()->with('error', "Une erreur s'est produite, erreur save CLI");
                        }
                    }
                } else {
                    return back()->with('error', "Une erreur s'est produite, echec de recuperation des informations.");
                }
            } else {
                return back()->with('error', "Une erreur s'est produite, donnée invalide");
            }
        } catch (\Throwable $e) {
            //throw $th;
            DB::rollBack();
            return back()->with('error', "Une erreur s'est produite, donnée invalide");
        }
    }
    public function desactiveProspect($id)
    {
        if (Prospect::dataDesact($id)) return back()->with('success', "Supprimée avec succès");
        else return back()->with('error', "Une erreur s'est produite");
    }


    public function listClient()
    {
        $us = Help::getAuthUser();
        $titre = "Liste Client | " . Help::$CIBLE_X;
        $clients = Client::dataListe($us->ID_ENTREPRISE);
        return view('pages.manager.clients', compact('titre', 'us', 'clients'));
    }
    public function detailClient($idClient)
    {
        $us = Help::getAuthUser();
        $titre = "Detail Demande Visite | " . Help::$CIBLE_X;
        $client = Client::LireSurID($idClient);
        $proprietes = ProprietesAffaire::ProprietesAcquisClient($idClient, $us->ID_ENTREPRISE);
        return view('pages.manager.cli-detail', compact('titre', 'us', 'client', 'proprietes'));
    }
    public function affaireFormCli($idCli, $id)
    {
        $us = Help::getAuthUser();
        $titre = "Formulaire Affaire | " . Help::$CIBLE_X;
        $clients = Client::dataListe($us->ID_ENTREPRISE);
        $proprietes = Proprietes::dataListe($us->ID_ENTREPRISE);
        return view('pages.manager.affairecliform', compact('titre', 'us', 'idCli', 'id', 'clients', 'proprietes'));
    }
    public function affaireDetail($idAffaire, $idPropriete)
    {
        $us = Help::getAuthUser();
        $titre = "Detail Affaire | " . Help::$CIBLE_X;
        $liaisons = ClientRedevances::listeRedevanceSurAffaire($us->ID_ENTREPRISE, $idAffaire);
        $affaire = Affaires::ProprietesAcquisClient($idAffaire, $idPropriete, $us->ID_ENTREPRISE);
        return view('pages.manager.affaire-detail', compact('titre', 'us', 'affaire', 'liaisons'));
    }


    public function listCategorie()
    {
        $us = Help::getAuthUser();
        $titre = "Liste Categorie | " . Help::$CIBLE_X;
        $categories = Categories::dataListe($us->ID_ENTREPRISE);
        return view('pages.manager.categories', compact('titre', 'us', 'categories'));
    }
    public function formCategorie($id)
    {
        $us = Help::getAuthUser();
        $titre = "Formulaire Redevance | " . Help::$CIBLE_X;
        $types = TypeOffres::dataListe();
        $categorie = Categories::LireSurID($id);
        return view('pages.manager.formcategorie', compact('titre', 'us', 'id','types','categorie'));
    }
    public function desactiveCategorie($id)
    {
        if (Categories::dataDesact($id)) return back()->with('success', "Supprimée avec succès");
        else return back()->with('error', "Une erreur s'est produite");
    }

    public function UpdateStoreCategorie(Request $request,$id)
    {
        // dd($request->all(),$id);

        $us = Help::getAuthUser();
        try {
            DB::beginTransaction();
            // dd($request->all(),$id);

            $validator = Validator::make($request->all(), [
                'libcategorie' => 'required|string|max:255',
                'typebien' => 'nullable|integer',
                'description' => 'nullable|string|max:255',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',  // Max size limit of 2MB (2048 KB)
                // 'termsconditions' => 'nullable|image|mimes:jpeg,png,jpg,gif,pdf,docx',
            ], [
                'libcategorie.required' => 'Le champ libcategorie est obligatoire.',
                'libcategorie.string' => 'Le champ libcategorie doit être une chaîne de caractères.',
                'libcategorie.max' => 'Le champ libcategorie ne doit pas dépasser 255 caractères.',

                'typebien.integer' => 'Le champ typebien doit être une chaîne de caractères.',
                'typebien.max' => 'Le champ typebien ne doit pas dépasser 255 caractères.',

                'description.string' => 'Le champ description doit être une chaîne de caractères.',
                'description.max' => 'Le champ description ne doit pas dépasser 255 caractères.',

                // 'avatar.required' => 'L images est obligatoire.',
                'image.image' => 'Le image doit être une image.',
                'image.mimes' => 'Le image doit être un fichier de type: jpeg, png, jpg, gif.',
                'image.max' => 'Le image ne doit pas dépasser 2MB.',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            // $banniere = Bannieres::LireSurID($id);
            $categorie = Categories::LireSurID($id);
            $image = null;
            if (!empty($request->image) && ($request->hasFile('image'))) {
                $fileName = trim(time() . 'LOG_' . $request->file('image')->getClientOriginalName());
                $request->file('image')->move(public_path('ImageCategories'), $fileName);
                $image = '/ImageCategories/' . $fileName;
            } else {
                $image = $categorie->PATH_CATEGORIE;
            }

            $categorie->LIB_CATEGORIE = $request->libcategorie;
            $categorie->ID_TYPE = $request->typebien;
            $categorie->DESCRIPTION_CATEGORIE = $request->description;
            $categorie->ID_ENTREPRISE = $us->ID_ENTREPRISE;
            $categorie->PATH_CATEGORIE = $image ?? $categorie->PATH_CATEGORIE;
            $categorie->DATEMAJ = Help::dhSys();
            $categorie->STATUT = Help::$ACTIF;
            $categorie->DATECREA = Help::dhSys();
            if ($categorie->save()) {
                DB::commit();
                return redirect()->route('categorieList')->with('success', 'Les informations ont été mises à jour avec succès.');
            }
        } catch (\Throwable $e) {
            return redirect()->route('categorieList')->with('error', 'Une erreur est survenue : ' . $e->getMessage());
        }
    }

    public function listService()
    {
        $us = Help::getAuthUser();
        $titre = "Liste Service | " . Help::$CIBLE_X;
        $services = Service::dataListe($us->ID_ENTREPRISE);
        return view('pages.manager.services', compact('titre', 'us', 'services'));
    }
    public function formService($id)
    {
        $us = Help::getAuthUser();
        $titre = "Formulaire Service | " . Help::$CIBLE_X;
        $service = Service::LireSurID($id);
        return view('pages.manager.formservice', compact('titre', 'us', 'id','service'));
    }

    // traitement store et update de service
    public function storeUpdateService(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            // dd($request->all(),$id);
            $us = Help::getAuthUser();

            $validator = Validator::make($request->all(), [
                'libservice' => 'required|string|max:255',
                'description' => 'nullable|string|max:255',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',  // Max size limit of 2MB (2048 KB)
                // 'termsconditions' => 'nullable|image|mimes:jpeg,png,jpg,gif,pdf,docx',
            ], [
                'libservice.required' => 'Le champ Designation est obligatoire.',
                'libservice.string' => 'Le champ Designation doit être une chaîne de caractères.',
                'libservice.max' => 'Le champ Designation ne doit pas dépasser 255 caractères.',

                'description.string' => 'Le champ description doit être une chaîne de caractères.',
                'description.max' => 'Le champ description ne doit pas dépasser 255 caractères.',
                'image.image' => 'Le image service  doit être une image.',
                'image.mimes' => 'Le image   service doit être un fichier de type: jpeg, png, jpg, gif.',
                'image.max' => 'Le image service ne doit pas dépasser 2MB.',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            // dd($request->termsconditions);
            $service = Service::LireSurID($id);
           // images service
            $image = null;
            if (!empty($request->image) && ($request->hasFile('image'))) {
                $fileName = trim(time() . 'LOG_' . $request->file('image')->getClientOriginalName());
                $request->file('image')->move(public_path('ImageService'), $fileName);
                $image = '/ImageService/' . $fileName;
            } else {
                $image = $service->PATH_SERVICE;
            }

            $service->LIB_SERVICE = $request->libservice;
            $service->DESCRIPTION_SERVICE = $request->description;
            $service->PATH_SERVICE = $image;
            $service->STATUT = Help::$ACTIF;
            $service->DATECREA = Help::dhSys();
            $service->ID_ENTREPRISE = $us->ID_ENTREPRISE;
            $service->DATEMAJ = Help::dhSys();
            if ($service->save()) {
                DB::commit();
                return redirect()->route('serviceList')->with('success', 'Les informations du service ont été mises à jour avec succès.');
            }
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Une erreur est survenue : ' . $e->getMessage());
        }

    }


    public function desactiveService($id)
    {
        if (Service::dataDesact($id)) return back()->with('success', "Supprimée avec succès");
        else return back()->with('error', "Une erreur s'est produite");
    }


    public function listAPropos()
    {
        $us = Help::getAuthUser();
        $titre = "Infos APropos | " . Help::$CIBLE_X;
        $apropos = APropos::dataListe($us->ID_ENTREPRISE);
        return view('pages.manager.aboutus', compact('titre', 'us', 'apropos'));
    }
    public function formAPropos($id)
    {
        $us = Help::getAuthUser();
        $apropos = APropos::LireSurID($id);
        $titre = "Formulaire APropos | " . Help::$CIBLE_X;
        return view('pages.manager.formapropos', compact('titre', 'us', 'id','apropos'));
    }
    public function desactiveAPropos($id)
    {
        if (APropos::dataDesact($id)) return back()->with('success', "Supprimée avec succès");
        else return back()->with('error', "Une erreur s'est produite");
    }

   // update de store de apropos
   public function StoreUpdateApropos(Request $request ,$id)
   {
    try {
        DB::beginTransaction();
        // dd($request->all(),$id);
        $us = Help::getAuthUser();

        $validator = Validator::make($request->all(), [
            'libapropos' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',  // Max size limit of 2MB (2048 KB)
            // 'termsconditions' => 'nullable|image|mimes:jpeg,png,jpg,gif,pdf,docx',
        ], [
            'libapropos.required' => 'Le champ Titre est obligatoire.',
            'libapropos.string' => 'Le champ Titre doit être une chaîne de caractères.',
            'libapropos.max' => 'Le champ Titre ne doit pas dépasser 255 caractères.',

            'description.string' => 'Le champ description doit être une chaîne de caractères.',
            'description.max' => 'Le champ description ne doit pas dépasser 255 caractères.',
            'image.image' => 'Le image service  doit être une image.',
            'image.mimes' => 'Le image   service doit être un fichier de type: jpeg, png, jpg, gif.',
            'image.max' => 'Le image service ne doit pas dépasser 2MB.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        // dd($request->termsconditions);
        $apropos = APropos::LireSurID($id);
       // images service
        $image = null;
        if (!empty($request->image) && ($request->hasFile('image'))) {
            $fileName = trim(time() . 'LOG_' . $request->file('image')->getClientOriginalName());
            $request->file('image')->move(public_path('ImageApropos'), $fileName);
            $image = '/ImageApropos/' . $fileName;
        } else {
            $image = $apropos->PATH_APROPOS;
        }

        $apropos->TITRE_INFO = $request->libapropos;
        $apropos->CONTENU_INFO = $request->description;
        $apropos->PATH_APROPOS = $image;
        $apropos->STATUT = Help::$ACTIF;
        $apropos->DATECREA = Help::dhSys();
        $apropos->ID_ENTREPRISE = $us->ID_ENTREPRISE;
        $apropos->DATEMAJ = Help::dhSys();
        if ($apropos->save()) {
            DB::commit();
            return redirect()->route('aproposList')->with('success', 'Les informations du apropos ont été mises à jour avec succès.');
        }
    } catch (\Throwable $e) {
        return redirect()->back()->with('error', 'Une erreur est survenue : ' . $e->getMessage());
    }
   }
    public function listFonction()
    {
        $us = Help::getAuthUser();
        $titre = "Fonction Agent | " . Help::$CIBLE_X;
        $fonctions = FonctionPersonnel::dataListe($us->ID_ENTREPRISE);
        return view('pages.manager.fonctions', compact('titre', 'us', 'fonctions'));
    }
    public function formFonction($id)
    {
        $us = Help::getAuthUser();
        $titre = "Formulaire Fonction | " . Help::$CIBLE_X;
        return view('pages.manager.formfonction', compact('titre', 'us', 'id'));
    }
    public function desactiveFonction($id)
    {
        if (FonctionPersonnel::dataDesact($id)) return back()->with('success', "Supprimée avec succès");
        else return back()->with('error', "Une erreur s'est produite");
    }


    public function listAgent()
    {
        $us = Help::getAuthUser();
        $titre = "Agent/Personnel | " . Help::$CIBLE_X;
        $agents = Personnels::dataListe(Help::$ACTIF);
        return view('pages.manager.agents', compact('titre', 'us', 'agents'));
    }
    public function formAgent($id)
    {
        $us = Help::getAuthUser();
        $titre = "Formulaire Fonction | " . Help::$CIBLE_X;
        $agent = Personnels::LireSurID($id);
        $fonctions = FonctionPersonnel::dataListe($us->ID_ENTREPRISE);
        return view('pages.manager.formagent', compact('titre', 'us', 'id','agent','fonctions'));
    }
    public function desactiveAgent($id)
    {
        if (Personnels::dataDesact($id)) return back()->with('success', "Supprimée avec succès");
        else return back()->with('error', "Une erreur s'est produite");
    }

    // traitement personnel Update et store
    public function UpStorPersonnel(Request $request ,$id)
    {
        try {
            DB::beginTransaction();
            // dd($request->all(),$id);
            $us = Help::getAuthUser();

            $validator = Validator::make($request->all(), [
                'nom' => 'required|string|max:255',
                'prenoms' => 'required|string|max:255',
                'contact' => 'nullable|string|max:255',
                'adremail' => 'required|string|email|max:255',  // Added email format validation
                'fonctID' => 'required|integer',
                'urlfbk' => 'nullable|string',
                'urltwt' => 'nullable|string',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',  // Max size limit of 2MB (2048 KB)
                // 'termsconditions' => 'nullable|image|mimes:jpeg,png,jpg,gif,pdf,docx',
            ], [
                'nom.required' => 'Le champ nom est obligatoire.',
                'nom.string' => 'Le champ nom doit être une chaîne de caractères.',
                'nom.max' => 'Le champ nom ne doit pas dépasser 255 caractères.',

                'prenoms.required' => 'Le champ prenoms est obligatoire.',
                'prenoms.string' => 'Le champ prenoms doit être une chaîne de caractères.',
                'prenoms.max' => 'Le champ prenoms ne doit pas dépasser 255 caractères.',

                'contact.string' => 'Le champ contact doit être une chaîne de caractères.',
                'contact.max' => 'Le champ contact ne doit pas dépasser 255 caractères.',

                'adremail.required' => 'Le champ Email est obligatoire.',
                'adremail.string' => 'Le champ Email doit être une chaîne de caractères.',
                'adremail.email' => 'Le champ Email doit être une adresse email valide.',
                'adremail.max' => 'Le champ Email ne doit pas dépasser 255 caractères.',

                'fonctID.required' => 'Le champ fonction est obligatoire.',
                'fonctID.integer' => 'Le champ fonction  doit être un entier.',

                'image.image' => 'Le image doit être une image.',
                'image.mimes' => 'Le image doit être un fichier de type: jpeg, png, jpg, gif.',
                'image.max' => 'Le image ne doit pas dépasser 2MB.',

                'urlfbk.string' => 'Le champ URL Facebook doit être une URL valide.',
                'urltwt.string' => 'Le champ URL Twitter doit être une URL valide.',

            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            // dd($request->termsconditions);
            $agent = Personnels::LireSurID($id);
           // images service
            $image = null;
            if (!empty($request->image) && ($request->hasFile('image'))) {
                $fileName = trim(time() . 'LOG_' . $request->file('image')->getClientOriginalName());
                $request->file('image')->move(public_path('PhotoPersonnel'), $fileName);
                $image = '/PhotoPersonnel/' . $fileName;
            } else {
                $image = $agent->PATH_PERS;
            }
            $agent->NOM_PERS = $request->nom;
            $agent->PRENOMS_PERS = $request->prenoms;
            $agent->CONTACT = $request->contact;
            $agent->ADR_EMAIL = $request->adremail;
            $agent->URL_FBK = $request->urlfbk;
            $agent->URL_TWT = $request->urltwt;
            $agent->ID_FONCTION_PERS = $request->fonctID;
            $agent->PATH_PERS = $image;
            $agent->STATUT = Help::$ACTIF;
            $agent->DATECREA = Help::dhSys();
            $agent->ID_ENTREPRISE = $us->ID_ENTREPRISE;
            $agent->DATEMAJ = Help::dhSys();
            if ($agent->save()) {
                DB::commit();
                return redirect()->route('agentList')->with('success', 'Les informations du personnel ont été mises à jour avec succès.');
            }
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Une erreur est survenue : ' . $e->getMessage());
        }

    }

    public function listRedevance()
    {
        $us = Help::getAuthUser();
        $titre = "Liste Redevances | " . Help::$CIBLE_X;
        $redevances = Redevances::dataListe($us->ID_ENTREPRISE);
        return view('pages.manager.redevances', compact('titre', 'us', 'redevances'));
    }
    public function formRedevance($id)
    {
        $us = Help::getAuthUser();
        $types = TypePropriete::dataListe(Help::$ACTIF);
        $periodes = TypePeriode::dataListe(Help::$ACTIF);
        $titre = "Formulaire Redevance | " . Help::$CIBLE_X;
        return view('pages.manager.formredevance', compact('titre', 'us', 'id', 'types', 'periodes'));
    }

    public function lireRedevance($id)
    {
        return Redevances::LireSurID($id);
    }
    public function validRedevance(Request $request, Redevances $obj)
    {
        $res = new ajaxResponse;
        $us = Help::getAuthUser();
        if (isset($us->ID_UTILISATEUR) && $us->ID_UTILISATEUR > 0) {
            if ($request->lib == '' || strlen($request->lib) < 10) {
                $res->code = 422;
                $res->mess = "Veuillez saisi une designation valide pour la redevance, 10 caractères minimum.";
                return $res;
            }
            if ($request->typ <= 0) {
                $res->code = 422;
                $res->mess = "Veuillez indiquer le type de la redevance.";
                return $res;
            }
            if ($request->period <= 0) {
                $res->code = 422;
                $res->mess = "Veuillez indiquer le type de periode pour la redevance.";
                return $res;
            }
            if ($request->desc == '' || strlen($request->desc) < 10) {
                $res->code = 422;
                $res->mess = "Veuillez renseigner une description, minimum 10 caractères.";
                return $res;
            }
            $obj->ID_ENTREPRISE = $us->ID_ENTREPRISE;
            $obj->ID_UTILISATEUR = $us->ID_UTILISATEUR;
            $obj = Redevances::dataSave($request, $obj);
            if (isset($obj->ID_REDEVANCES)) {
                $res->code = 200;
                $res->mess = "Redevance enregistrée avec succès";
            } else {
                $res->code = 404;
                $res->mess = "Une erreur s'est produite !";
            }
        } else {
            $res->code = 500;
            $res->mess = "Erreur interne du serveur !";
        }
        return $res;
    }
    public function desactiveRedevance($id)
    {
        if (Redevances::dataDesact($id)) return back()->with('success', "Supprimée avec succès");
        else return back()->with('error', "Une erreur s'est produite");
    }


    public function listAffaire()
    {
        $us = Help::getAuthUser();
        $titre = "Liste Affaires | " . Help::$CIBLE_X;
        $affaires = Affaires::dataListe($us->ID_ENTREPRISE);
        return view('pages.manager.affaires', compact('titre', 'us', 'affaires'));
    }
    public function formAffaire($id)
    {
        $us = Help::getAuthUser();
        $titre = "Formulaire Affaire | " . Help::$CIBLE_X;
        $clients = Client::dataListe($us->ID_ENTREPRISE);
        $proprietes = Proprietes::dataListe($us->ID_ENTREPRISE);
        return view('pages.manager.formaffaire', compact('titre', 'us', 'id', 'clients', 'proprietes'));
    }
    public function lireAffaire($id)
    {
        return Affaires::LireSurID($id);
    }
    public function validAffaire(Request $request, Affaires $obj)
    {
        $res = new ajaxResponse;
        $us = Help::getAuthUser();
        if (isset($us->ID_UTILISATEUR) && $us->ID_UTILISATEUR > 0) {
            if (!isset($request->Client)) {
                $res->code = 422;
                $res->mess = "Veuillez indiquer le client.";
                return $res;
            }
            if (!isset($request->Propriete)) {
                $res->code = 422;
                $res->mess = "Veuillez selectionner la propriété concernée.";
                return $res;
            }
            if ($request->Montant == '' || $request->Montant < 500) {
                $res->code = 422;
                $res->mess = "Le montant de la propriété sélectionnée est invalide, montant minimum requis 500.";
                return $res;
            }
            if ($request->Total == '' || $request->Total < 500) {
                $res->code = 422;
                $res->mess = "Le montant total a payer pour cette affaire est invalide, montant minimum requis 500.";
                return $res;
            }
            $validator = Validator::make($request->all(), [
                'Date' => [
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
            $data = Proprietes::find($request->Propriete);
            if (isset($data->ID_PROPRIETES) && $data->ID_PROPRIETES > 0) {
                $obj->ID_ENTREPRISE = $us->ID_ENTREPRISE;
                $obj->ID_UTILISATEUR = $us->ID_UTILISATEUR;
                $obj = Affaires::dataSave($request, $obj, $data);
                if (isset($obj->ID_AFFAIRES)) {
                    $res->code = 200;
                    $res->mess = "Affaire enregistrée avec succès";
                } else {
                    $res->code = 404;
                    $res->mess = "Une erreur s'est produite !";
                }
            } else {
                $res->code = 500;
                $res->mess = "Une erreur s'est produite, données propriété !";
            }
        } else {
            $res->code = 500;
            $res->mess = "Erreur interne du serveur !";
        }
        return $res;
    }
    public function desactiveAffaire($id)
    {
        $redevances = ClientRedevances::where('ID_AFFAIRES', $id)
            ->where('STATUT', Help::$ACTIF)->first();
        if (isset($redevances->ID_LIAIS) && $redevances->ID_LIAIS > 0) {
            return back()->with('error', "Action non autorisé pour une affaire déjà facturée");
        } else {
            if (Affaires::dataDesact($id)) return back()->with('success', "Supprimée avec succès");
            else return back()->with('error', "Une erreur s'est produite");
        }
    }


    public function listLiaison()
    {
        $us = Help::getAuthUser();
        $titre = "Liste Facturation | " . Help::$CIBLE_X;
        $liaisons = ClientRedevances::dataListe($us->ID_ENTREPRISE);
        return view('pages.manager.liaisons', compact('titre', 'us', 'liaisons'));
    }
    public function formLiaison($id)
    {
        $us = Help::getAuthUser();
        $titre = "Formulaire Facturation | " . Help::$CIBLE_X;
        $clients = Client::cliListe($us->ID_ENTREPRISE);
        $redevances = Redevances::dataListe($us->ID_ENTREPRISE);
        return view('pages.manager.formliaison', compact('titre', 'us', 'id', 'clients', 'redevances'));
    }
    public function getAffaireClient($id)
    {
        $us = Help::getAuthUser();
        return Affaires::affaireSurClientID($us->ID_ENTREPRISE, $id);
    }
    public function getAffaire($id)
    {
        $us = Help::getAuthUser();
        return Affaires::affaireSurID($us->ID_ENTREPRISE, $id);
    }
    public function getRedevance($id)
    {
        $us = Help::getAuthUser();
        return Redevances::redevanceSurID($us->ID_ENTREPRISE, $id);
    }
    public function lireLiaison($id)
    {
        return ClientRedevances::LireSurID($id);
    }
    public function calcDate(Request $request)
    {
        $res = new ajaxResponse;
        if (
            isset($request->TotalAPay) && $request->TotalAPay > 0 && isset($request->MontPeriod) && $request->MontPeriod > 0
            && isset($request->Freq) && $request->Freq > 0 && isset($request->Period) && $request->Period > 0
        ) {
            $validator = Validator::make($request->all(), [
                'datemin' => [
                    'required',
                    'date_format:Y-m-d'
                ],
            ]);
            // 'after_or_equal:'.date("Y-m-d")
            if ($validator->fails()) {
                $res->code = 422;
                $res->mess = "Veuillez renseigner une date valide.";
            } else {
                if ($request->MontPeriod <= $request->TotalAPay) {

                    (int) $Nb = 0;
                    (int) $IntPart = 0;
                    (int) $DecPart = 0;
                    (int) $Frequence = $request->Freq;

                    $MONT_PERIODE = $request->MontPeriod;
                    $TOTAL_A_PAYER = $request->TotalAPay;
                    $rRes = ($TOTAL_A_PAYER / $MONT_PERIODE);

                    if (is_float($rRes)) {
                        $Nb = explode('.', $rRes); //on explose la chaine au niveau du point
                        (int) $IntPart = $Nb[0]; //on recupere la premiere chaine, situee avant le point
                        (int) $DecPart = $Nb[1]; //on recupere la deuxieme chaine, situee après le point
                        if (strlen($DecPart) > 2) $DecPart = substr($DecPart, 0, 2); //on recupere la deuxieme chaine sur deux caractères
                        $IntPart = $IntPart + 1;
                    } else {
                        $IntPart = $rRes;
                    }

                    $rRes = ($IntPart / $Frequence); //on divise par la frequence jour/hebdo./mens./annu.

                    if (is_float($rRes)) {
                        $Nb = explode('.', $rRes); //on explose la chaine au niveau du point
                        (int) $IntPart = $Nb[0]; //on recupere la premiere chaine, situee avant le point
                        $IntPart = $IntPart + 1;
                    } else {
                        $IntPart = $rRes;
                    }

                    $res->code = 200;
                    switch ($request->Period) {
                        case 2:
                        case 3:
                            if ($request->Period == 3) $IntPart = $IntPart * 7;
                            $dateNew = date('Y-m-d', strtotime("$request->datemin +$IntPart day"));
                            break;
                        case 4:
                            $dateNew = date('Y-m-d', strtotime("$request->datemin +$IntPart month"));
                            break;
                        case 5:
                            $dateNew = date('Y-m-d', strtotime("$request->datemin +$IntPart Year"));
                            break;
                        default:
                            $res->code = 500;
                            $dateNew = 'Type periode non pris en charge !';
                            break;
                    }
                    $res->mess = $dateNew;
                } else {
                    $res->code = 500;
                    $res->mess = "Montant periodique erroné, veuillez renseigner un montant correct.";
                }
            }
        } else {
            $res->code = 500;
            $res->mess = "Veuillez renseigner tous les champs requis pour cette action.";
        }
        return $res;
    }


    public function validLiaison(Request $request, ClientRedevances $obj)
    {

        $res = new ajaxResponse;
        $us = Help::getAuthUser();

        if (!empty($us->ID_UTILISATEUR)) {

            if (
                !empty($request->CliID) && !empty($request->AffID) && !empty($request->RedID)
                && $request->RedID > 0 && !empty($request->TtlAP) && $request->TtlAP > 0
                && !empty($request->TypID) && $request->TypID > 0
            ) {

                $validator = Validator::make($request->all(), [
                    'DateFac' => [
                        'required',
                        'date_format:Y-m-d',
                        'before_or_equal:' . date("Y-m-d")
                    ],
                ]);
                if ($validator->fails()) {
                    $res->code = 422;
                    $res->mess = "Veuillez renseigner une date de facturation valide.";
                    return $res;
                }

                if (!empty($request->id)) {
                    $obj = ClientRedevances::LireSurID($request->id);
                    if (empty($obj->ID_LIAIS)) {
                        $res->code = 422;
                        $res->mess = "Une erreur de données s'est produite lors de recuperation" .
                            " des informations de facturation pour mise à jour.";
                        return $res;
                    } else {
                        if ($obj->TOTAL_PAYER > $request->TtlAP) {
                            $res->code = 422;
                            $res->mess = "Le montant déjà payé de '" . Help::formatNombre($obj->TOTAL_PAYER, true) .
                                "' ne peut être superieure au total à payer de '" . Help::formatNombre($request->TtlAP, true) .
                                "' pour cette facturation.";
                            return $res;
                        } else {
                            $obj->DATEMAJ = Help::dhSys();
                            $obj->REST_A_PAYER = $request->TtlAP - $obj->TOTAL_PAYER;
                        }
                    }
                } else {
                    $obj->STATUT = Help::$ACTIF;
                    $obj->DATECREA = Help::dhSys();
                    $obj->REST_A_PAYER = $request->TtlAP;
                    $obj->ID_ENTREPRISE = $us->ID_ENTREPRISE;
                    $data = ClientRedevances::checkLiaisonSurRedevanceAffaire($us->ID_ENTREPRISE, $request->RedID, $request->AffID);
                    if (!empty($data->ID_LIAIS)) {
                        $res->code = 422;
                        $res->mess = "Une données de facturation existe déjà pour les paramètres definir. !! duplicate_data !!";
                        return $res;
                    }
                }
                $obj->ID_UTILISATEUR = $us->ID_UTILISATEUR;

                $obj->ID_CLIENT = $request->CliID;
                $obj->ID_AFFAIRES = $request->AffID;
                $affaires = Affaires::LireSurID($obj->ID_AFFAIRES);

                if (isset($affaires->ID_AFFAIRES) && $affaires->ID_AFFAIRES > 0) {

                    $obj->ID_PROPRIETES = $affaires->ID_PROPRIETES;
                    $obj->ID_REDEVANCES = $request->RedID;
                    $obj->ID_TYPE_PERIODE = $request->TypID;
                    $obj->DATE_LIAIS = $request->DateFac;

                    if ($request->TypID != 1 && $request->TypID != 6) {
                        $validator = Validator::make($request->all(), [
                            'DateMin' => [
                                'required',
                                'date_format:Y-m-d'
                            ],
                        ]);
                        if ($validator->fails()) {
                            $res->code = 422;
                            $res->mess = "Veuillez renseigner une date de debut de paiement valide.";
                            return $res;
                        }
                        if (isset($request->MtPer) && $request->MtPer > 0) {
                            $obj->MONTANT_PERIOD = $request->MtPer;
                        } else {
                            $res->code = 500;
                            $res->mess = "Le montant periodique defini pour pour redevance indiqué est invalide.";
                            return $res;
                        }
                    } else {
                        $obj->MONTANT_PERIOD = $request->TtlAP;
                    }

                    if ($obj->MONTANT_PERIOD <= $request->TtlAP && $obj->MONTANT_PERIOD > 0) {

                        (int) $Nb = 0;
                        (int) $IntPart = 0;
                        (int) $DecPart = 0;
                        (int) $Frequence = 0;
                        (isset($request->Freq) && $request->Freq > 0) ? $Frequence = $request->Freq : $Frequence = 1;

                        (int) $TOTAL_A_PAYER = $request->TtlAP;
                        (int) $MONT_PERIODE = $obj->MONTANT_PERIOD;
                        $rRes = ($TOTAL_A_PAYER / $MONT_PERIODE);

                        if (is_float($rRes)) {
                            $Nb = explode('.', $rRes); //on explose la chaine au niveau du point
                            (int) $IntPart = $Nb[0]; //on recupere la premiere chaine, situee avant le point
                            (int) $DecPart = $Nb[1]; //on recupere la deuxieme chaine, situee après le point
                            if (strlen($DecPart) > 2) $DecPart = substr($DecPart, 0, 2); //deuxieme chaine sur deux caractères
                            $IntPart = $IntPart + 1;
                        } else {
                            $IntPart = $rRes;
                        }

                        $rRes = ($IntPart / $Frequence); //on divise par la frequence jour/hebdo./mens./annu.

                        if (is_float($rRes)) {
                            $Nb = explode('.', $rRes); //on explose la chaine au niveau du point
                            (int) $IntPart = $Nb[0]; //on recupere la premiere chaine, situee avant le point
                            $IntPart = $IntPart + 1;
                        } else {
                            $IntPart = $rRes;
                        }

                        $obj->MONTANT_REDEV = $TOTAL_A_PAYER;
                        $obj->TOTAL_A_PAYER = $TOTAL_A_PAYER;

                        $DateJour = date("Y-m-d");
                        $obj->NB_FREQUENCE = $Frequence;

                        switch ($request->TypID) {
                                // Aperiodique & Immediat
                            case 1:
                            case 6:
                                $obj->DATE_DBT_PAY = date('Y-m-d', strtotime("$DateJour +1 day"));
                                $obj->DATE_NXT_PAY = date('Y-m-d', strtotime("$DateJour +1 day"));
                                $obj->DATE_FIN_PAY = date('Y-m-d', strtotime("$DateJour +1 day"));
                                break;
                                // Journalier et Hebdomadaire
                            case 2:
                            case 3:
                                if ($request->TypID == 3) {
                                    $IntPart = $IntPart * 7;
                                    $obj->DATE_NXT_PAY = date('Y-m-d', strtotime("$request->DateMin +7*$Frequence day"));
                                } else {
                                    $obj->DATE_NXT_PAY = date('Y-m-d', strtotime("$request->DateMin +1*$Frequence day"));
                                }
                                $obj->DATE_FIN_PAY = date('Y-m-d', strtotime("$request->DateMin +$IntPart day"));
                                break;
                                // Mensuelle
                            case 4:
                                $obj->DATE_NXT_PAY = date('Y-m-d', strtotime("$request->DateMin +$Frequence month"));
                                $obj->DATE_FIN_PAY = date('Y-m-d', strtotime("$request->DateMin +$IntPart month"));
                                break;
                                // Annuelle
                            case 5:
                                $obj->DATE_NXT_PAY = date('Y-m-d', strtotime("$request->DateMin +$Frequence Year"));
                                $obj->DATE_FIN_PAY = date('Y-m-d', strtotime("$request->DateMin +$IntPart Year"));
                                break;
                            default:
                                $res->code = 500;
                                $datefin = 'Type periode non pris en charge !';
                                break;
                        }

                        if ($request->TypID != 1 && $request->TypID != 6) {
                            $obj->DATE_DBT_PAY = $request->DateMin;
                        }

                        if ($obj->save()) {
                            $res->code = 200;
                            $res->mess = "Facturation effectuée avec succès";
                        } else {
                            $res->code = 404;
                            $res->mess = "Une erreur s'est produite !";
                        };
                    } else {
                        $res->code = 500;
                        $res->mess = "Montant periodique erroné, veuillez renseigner un montant correct.";
                    }
                } else {
                    $res->code = 422;
                    $res->mess = "Une erreur de données s'est produite, code 444.";
                }
            } else {
                $res->code = 500;
                $res->mess = "Veuillez renseigner tous les champs requis pour cette action.";
            }
        } else {
            $res->code = 500;
            $res->mess = "Erreur interne du serveur !";
        }

        return $res;
    }
    public function desactiveLiaison($id)
    {
        if (ClientRedevances::dataDesact($id)) return back()->with('success', "Supprimée avec succès");
        else return back()->with('error', "Une erreur s'est produite");
    }


    public function listPaiement()
    {
        $us = Help::getAuthUser();
        $identreprise = $us->ID_ENTREPRISE;
        $titre = "Liste Paiements | " . Help::$CIBLE_X;
        return view('pages.manager.paiements', compact('titre', 'us', 'identreprise'));
    }
    public function paiementFiltre($p1, $p2, $p3, $d1, $d2)
    {
        $res = new ajaxResponse;
        $us = Help::getAuthUser();
        $request['date1'] = $d1;
        $request['date2'] = $d2;
        $validator = Validator::make($request, [
            'date1' => [
                'required',
                'date_format:Y-m-d'
            ],
            'date2' => [
                'required',
                'date_format:Y-m-d'
            ],
        ]);
        if ($validator->fails()) {
            $res->code = 422;
            $res->mess = "Veuillez renseigner une date valide.";
        } else {
            $res->code = 200;
            $res->mess = "Succes";
            $res->data = Paiements::paiementListe($p1, $us->ID_ENTREPRISE, $p2, $p3, $d1, $d2);
        }
        return $res;
    }
    public function detailPaiement($idPaiement)
    {
        $us = Help::getAuthUser();
        $titre = "Detail Paiement Client | " . Help::$CIBLE_X;
        $paiement = Paiements::lirePaiementSurID($idPaiement, $us->ID_ENTREPRISE);
        $affaire = Affaires::lireAffaireClientSurID($us->ID_ENTREPRISE, $paiement->ID_AFFAIRES);
        $liaison = ClientRedevances::lireFacturationSurID($us->ID_ENTREPRISE, $paiement->ID_LIAIS);
        return view('pages.manager.formpaiement', compact('titre', 'us', 'paiement', 'affaire', 'liaison'));
    }
    public function paiementApprove($id)
    {
        $res = new ajaxResponse;
        $us = Help::getAuthUser();
        $paiement = Paiements::find($id);
        if (isset($paiement->ID_PAIEMENTS)) {
            $liaison = ClientRedevances::find($paiement->ID_LIAIS);
            if (isset($liaison->ID_LIAIS)) {
                (int) $MontantPaiement = $paiement->MONTANT;
                (int) $MontantTotalPayer = $liaison->TOTAL_PAYER;
                (int) $MontantTotalAPayer = $liaison->TOTAL_A_PAYER;
                if ($liaison->ID_TYPE_PERIODE == 1) {
                    // Il s'agit d'un paiement 'Immediat'
                    if ($MontantPaiement < $MontantTotalAPayer) {
                        $res->code = 422;
                        $res->mess = "Le montant à payer ne doit pas être inférieur au montant de la facturation";
                        return $res;
                    }
                }
                if ($MontantTotalPayer == $MontantTotalAPayer) {
                    $res->code = 422;
                    $res->mess = "Le client est à jour de paiement de cette facturation";
                    return $res;
                } else {
                    if ($MontantTotalAPayer < ($MontantTotalPayer + $MontantPaiement)) {
                        (int) $RestApayer = ($MontantTotalAPayer - $MontantTotalPayer);
                        $res->code = 422;
                        $res->mess = 'Le reste a payer pour cette facturation est de ' . Help::formatNombre($RestApayer ?? '0', true);
                        return $res;
                    }
                }
                $liaison->TOTAL_PAYER = $liaison->TOTAL_PAYER + $MontantPaiement;
                $liaison->REST_A_PAYER = $MontantTotalAPayer - $liaison->TOTAL_PAYER;
                $liaison->DATEMAJ = Help::dhSys();
                $liaison->save();
                $paiement->STATUT = Help::$ACTIF;
                $paiement->DATEMAJ = Help::dhSys();
                $paiement->ID_UTILISATEUR = $us->ID_UTILISATEUR;
                if ($paiement->save()) {
                    $res->code = 200;
                    $res->mess = 'success';
                } else {
                    $res->code = 500;
                    $res->mess = "Echec de validation !";
                }
            } else {
                $res->code = 500;
                $res->mess = "Une erreur s'est produite, niveau 2";
            }
        } else {
            $res->code = 500;
            $res->mess = "Une erreur s'est prouite, niveau 1";
        }
        return $res;
    }
    public function paiementRejet(Request $request)
    {
        $res = new ajaxResponse;
        $us = Help::getAuthUser();
        if ((isset($request->param) && $request->param > 0) && (isset($request->motif) && ($request->motif != '' && strlen($request->motif) > 10))) {
            $data = Paiements::find($request->param);
            if (isset($data->ID_PAIEMENTS)) {
                $data->STATUT = Help::$REFUSE;
                $data->DATEMAJ = Help::dhSys();
                $data->MOTIFS = $request->motif;
                $data->ID_UTILISATEUR = $us->ID_UTILISATEUR;
                if ($data->save()) {
                    $res->code = 200;
                    $res->mess = 'success';
                } else {
                    $res->code = 500;
                    $res->mess = "Echec de validation !";
                }
            } else {
                $res->code = 500;
                $res->mess = "Une erreur s'est prouite";
            }
        } else {
            $res->code = 500;
            $res->mess = "Une erreur s'est prouite";
        }
        return $res;
    }

    public function infosEntreprise()
    {
        $us = Help::getAuthUser();
        $titre = "Entreprise | " . Help::$CIBLE_X;
        $entreprise = Entreprise::where('ID_ENTREPRISE', $us->ID_ENTREPRISE)->first();
        $iduscnx = $us->ID_UTILISATEUR;
        $compteopt = 1;
        $formcompte = 0;
        $comptes = User::listeCompUser($us->ID_ENTREPRISE);
        return view('pages.manager.entreprise', compact('titre', 'us', 'entreprise', 'iduscnx', 'compteopt','formcompte', 'comptes'));
    }

    // traitement des informations de l'entreprise
    public function traitementEntreprise(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            // dd($request->all(),$id);

            $validator = Validator::make($request->all(), [
                'raisonsociale' => 'required|string|max:255',
                'adresse' => 'required|string|max:255',
                'contact1' => 'nullable|string|max:255',
                'contact2' => 'nullable|string|max:255',
                'adremail' => 'required|string|email|max:255',  // Added email format validation
                'slogan' => 'nullable|string|max:255',
                'descriptif' => 'nullable|string',
                'urlfbk' => 'nullable|string',
                'urltwt' => 'nullable|string',
                'urllink' => 'nullable|string',
                'urldemo' => 'nullable|string',
                'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',  // Max size limit of 2MB (2048 KB)
                // 'termsconditions' => 'nullable|image|mimes:jpeg,png,jpg,gif,pdf,docx',
            ], [
                'raisonsociale.required' => 'Le champ Raison Sociale est obligatoire.',
                'raisonsociale.string' => 'Le champ Raison Sociale doit être une chaîne de caractères.',
                'raisonsociale.max' => 'Le champ Raison Sociale ne doit pas dépasser 255 caractères.',

                'adresse.required' => 'Le champ Adresse est obligatoire.',
                'adresse.string' => 'Le champ Adresse doit être une chaîne de caractères.',
                'adresse.max' => 'Le champ Adresse ne doit pas dépasser 255 caractères.',

                'adremail.required' => 'Le champ Email est obligatoire.',
                'adremail.string' => 'Le champ Email doit être une chaîne de caractères.',
                'adremail.email' => 'Le champ Email doit être une adresse email valide.',
                'adremail.max' => 'Le champ Email ne doit pas dépasser 255 caractères.',

                'logo.image' => 'Le logo doit être une image.',
                'logo.mimes' => 'Le logo doit être un fichier de type: jpeg, png, jpg, gif.',
                'logo.max' => 'Le logo ne doit pas dépasser 2MB.',

                // 'termsconditions.image' => 'Les conditions générales doivent être une image.',
                // 'termsconditions.mimes' => 'Les conditions générales doivent être un fichier de type: jpeg, png, jpg, gif, pdf, docx.',
                // 'termsconditions.max' => 'Les conditions générales ne doivent pas dépasser 2MB.',

                'urlfbk.string' => 'Le champ URL Facebook doit être une URL valide.',
                'urltwt.string' => 'Le champ URL Twitter doit être une URL valide.',
                'urllink.string' => 'Le champ URL LinkedIn doit être une URL valide.',
                'urldemo.string' => 'Le champ URL Démo doit être une URL valide.',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            // dd($request->termsconditions);
            $entreprise = Entreprise::LireSurID($id);
            if (empty($entreprise) && $entreprise->ID_ENTREPRISE <= 0) {
                return redirect()->back()->with('error', 'Cette Entreprise n\'existe pas ou a étè desactive veuillez contacter l\'administrateur BMI ');
            }
            // logo
            $logo = null;
            if (!empty($request->logo) && ($request->hasFile('logo'))) {
                $fileName = trim(time() . 'LOG_' . $request->file('logo')->getClientOriginalName());
                $request->file('logo')->move(public_path('docEntreprise'), $fileName);
                $logo = '/docEntreprise/' . $fileName;
            } else {
                $logo = $entreprise->LOGO;
            }
            // document confidentialite
            $terms = null;
            if (!empty($request->termsconditions) && ($request->hasFile('termsconditions'))) {
                $fileName = trim(time() . 'TERM_' . $request->file('termsconditions')->getClientOriginalName());
                $request->file('termsconditions')->move(public_path('docEntreprise'), $fileName);
                $terms = '/docEntreprise/' . $fileName;
            } else {
                $terms = $entreprise->TERMS_CONDITIONS;
            }
            $entreprise->RAISON_SOCIALE = $request->raisonsociale;
            $entreprise->ADRESSE = $request->adresse;
            $entreprise->CONTACT1 = $request->contact1;
            $entreprise->CONTACT2 = $request->contact2;
            $entreprise->ADR_EMAIL = $request->adremail;
            $entreprise->SLOGAN = $request->slogan;
            $entreprise->DESCRIPTIF = $request->descriptif;
            $entreprise->URLFBK = $request->urlfbk;
            $entreprise->URLLINK = $request->urllink;
            $entreprise->URLTWT = $request->urltwt;
            $entreprise->URLDEMO = $request->urldemo;
            $entreprise->LOGO = $logo ?? $entreprise->LOGO;
            $entreprise->TERMS_CONDITIONS = $terms ?? $entreprise->TERMS_CONDITIONS;
            $entreprise->DATEMAJ = Help::dhSys();
            if ($entreprise->save()) {
                DB::commit();
                return redirect()->route('entrepriseInfos')->with('success', 'Les informations ont été mises à jour avec succès.');
            }
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Une erreur est survenue : ' . $e->getMessage());
        }
    }

    // public function AjouterPersonne($id)
    // {

    //     $us = Help::getAuthUser();
    //     $titre = "Entreprise | " . Help::$CIBLE_X;
    //     $entreprise = Entreprise::where('ID_ENTREPRISE', $us->ID_ENTREPRISE)->first();
    //     $iduscnx = $us->ID_UTILISATEUR;
    //     $compteopt = 1;
    //     $formcompte = 1;
    //     $comptes = User::listeCompUser($us->ID_ENTREPRISE);
    //     return view('pages.manager.accountusPersonnel', compact('titre', 'us', 'entreprise', 'iduscnx', 'compteopt','formcompte', 'comptes'));
    // }
}
