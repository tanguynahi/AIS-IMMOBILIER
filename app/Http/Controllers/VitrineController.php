<?php

namespace App\Http\Controllers;

use Help;
use Requests;
use Carbon\Carbon;
use App\Models\dto;
use App\Models\Pays;
use App\Models\User;
use App\Models\Ville;
use App\Models\Client;
use App\Models\APropos;
use App\Models\Service;
use App\Models\Prospect;
use App\Models\Bannieres;
use App\Models\Categories;
use App\Models\Entreprise;
use App\Models\Personnels;
use App\Models\Proprietes;
use App\Models\ajaxResponse;
use Illuminate\Http\Request;
use App\Models\DemandeVisite;
use App\Models\TypePropriete;
use App\Models\ProprietesPlan;
use App\Models\ReponseMessage;
use App\Models\ProprieteImages;
use App\Models\AnneeConstruction;
use App\Models\MessageInternaute;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Notification;
use App\Notifications\DemandeClientNotification;

class VitrineController extends Controller
{
    public function index_V() {
        // $dateString = '22/07/2024';
        // $carbonDate = Carbon::createFromFormat('d/m/Y', $dateString);
        // $formattedDate = $carbonDate->format('Ymd');
        // dd($formattedDate);
        session()->forget('dto');
        $us = Help::getAuthUser();
        $titre = 'Accueil | '. Help::$CIBLE_X;
        $types = TypePropriete::dataListe(Help::$ACTIF);
        $villes = Ville::dataListe(1, Help::$ACTIF);
        $annees = AnneeConstruction::dataListe(Help::$ACTIF);
        $bannieres = Bannieres::Liste(Help::$ENTREPRISE);
        $categories = Categories::dataListe(Help::$ENTREPRISE);
        $proprietes = Proprietes::proprietesIndex(Help::$ENTREPRISE);
        $categoriesFiltres = Categories::ListeIndex(Help::$ENTREPRISE);
        $envedettes = Proprietes::proprietesFeatured(Help::$ENTREPRISE);
        $agents = count(Personnels::dataListe(Help::$ENTREPRISE));
        $counters = Proprietes::nbPropretiesByType(Help::$ENTREPRISE);
        return view('pages.site.index', compact('titre', 'us', 'types', 'villes', 'annees', 'categories', 'proprietes', 'envedettes', 'agents', 'counters', 'categoriesFiltres', 'bannieres'));
    }

    public function proprieteDetail($idPropriete) {

        session()->forget('dtmp');

        $us = Help::getAuthUser();
        $titre = 'Detail Propriete | Immobilier-Store';

        $categories = Categories::dataListe(Help::$ENTREPRISE);
        $proprietes = Proprietes::proprietesDetail($idPropriete);
        $plan = ProprietesPlan::dataListe($idPropriete, Help::$ACTIF);
        $files = ProprieteImages::dataListe($idPropriete, Help::$ACTIF);

        if(isset($proprietes->ID_PROPRIETES) && $proprietes->ID_PROPRIETES>0){
            $similar = Proprietes::proprieteSimilar($proprietes->ID_CATEGORIES);
        }else{ $similar = []; }

        if(isset($proprietes->ID_PROPRIETES) && $proprietes->ID_PROPRIETES>0){
            $recent = Proprietes::proprieteRecent($proprietes->ID_PROPRIETES);
        }else{ $recent = []; }

        $types = TypePropriete::dataListe(Help::$ACTIF);
        $annee = AnneeConstruction::dataListe(Help::$ACTIF);

        $idPays = 0;
        $pays = Pays::dataListe(Help::$ACTIF);
        if (count($pays)>0) {
            $idPays = $pays[0]->ID_PAYS;
        }
        $villes = Ville::dataListe($idPays, Help::$ACTIF);

        return view('pages.site.detail-propriete',
        compact('us', 'titre', 'categories', 'proprietes', 'files', 'plan', 'similar', 'recent', 'types', 'pays', 'annee', 'idPays', 'villes'));
    }
    public function proprieteSearch(Request $request) {
        // dd($request->input());
        $us = Help::getAuthUser();
        $titre = 'Catalogue Propriete | Immobilier-Store';
        $categories = Categories::dataListe(Help::$ENTREPRISE);
        if(session()->has('dtmp')){
            $request = session()->get('dtmp');
            session()->forget('dtmp');
        }
        return view('pages.site.catalogue', compact('us', 'titre', 'categories', 'request'));
    }
    public function SearchSess(Request $request) {
        $requests = new Requests();
        $requests->act = $request->act;
        $requests->all_status = $request->all_status;
        $requests->all_categories = $request->all_categories;
        $requests->pays = $request->pays;
        $requests->city = $request->city;
        $requests->nb_pieces = $request->nb_pieces;
        $requests->annee_const = $request->annee_const;
        $requests->min_area = $request->min_area;
        $requests->max_area = $request->max_area;
        $requests->min_price = $request->min_price;
        $requests->max_price = $request->max_price;
        $requests->wifi = $request->wifi;
        $requests->piscine = $request->piscine;
        $requests->cuisine_equip = $request->cuisine_equip;
        $requests->clim = $request->clim;
        $requests->parking = $request->parking;
        $requests->securite = $request->securite;
        $requests->salle_sport = $request->salle_sport;
        if(session()->has('dtmp')) session()->forget('dtmp');
        session()->put('dtmp', $requests);
        $data = session()->get('dtmp');
        if(isset($data->all_status)){
            $res = new ajaxResponse; $res->code = 200; $res->mess = "succes"; return $res;
        }else{ $res = new ajaxResponse; $res->code = 500; $res->mess = "une erreur s'est produite"; return $res; }
    }
    public function libelFiltre($request){
        $str = 'Filtre:';
        if (isset($request->all_status) && $request->all_status>0){
            $str .= ' <b>'.TypePropriete::libelleSurID($request->all_status).'</b>';
        }
        if (isset($request->all_categories) && $request->all_categories>0){
            $str .= ' > <b>'.Categories::libelleSurID($request->all_categories).'</b>';
        }
        if (isset($request->city) && $request->city>0){
            $str .= ' > <b>'.Ville::libelleSurID($request->city).'</b>';
        }
        if (isset($request->nb_pieces) && $request->nb_pieces>0){
            $str .= ' > <b>'.$request->nb_pieces. 'PIECE(S)'.'</b>';
        }
        if (isset($request->annee_const) && $request->annee_const>0){
            $str .= ' > <b>ANNEE ('.$request->annee_const.')'.'</b>';
        }
        if ((isset($request->min_area) && isset($request->max_area)) && ($request->min_area>0 && $request->max_area>0)){
            $str .= ' > <b>SUPERFICIE ENTRE ('.$request->min_area.'m² & '.$request->max_area.'m²)'.'</b>';
        }
        if ((isset($request->min_price) && isset($request->max_price)) && ($request->min_price>0 && $request->max_price>0)){
            $str .= ' > <b>PRIX ENTRE ('.$request->min_price.' & '.$request->max_price.')'.'</b>';
        }
        if (isset($request->wifi) && $request->wifi=='on'){
            $str .= ' > <b>WIFI'.'</b>';
        }
        if (isset($request->piscine) && $request->piscine=='on'){
            $str .= ' > <b>PISCINE'.'</b>';
        }
        if (isset($request->cuisine_equip) && $request->cuisine_equip=='on'){
            $str .= ' > <b>CUSINE_EQUIPE'.'</b>';
        }
        if (isset($request->climatisation) && $request->climatisation=='on'){
            $str .= ' > <b>CLIMATISATION'.'</b>';
        }
        if (isset($request->parking) && $request->parking=='on'){
            $str .= ' > <b>PARKING'.'</b>';
        }
        if (isset($request->securite) && $request->securite=='on'){
            $str .= ' > <b>SECURITE'.'</b>';
        }
        if (isset($request->salle_sport) && $request->salle_sport=='on'){
            $str .= ' > <b>SALLE_DE_SPORT'.'</b>';
        }
        if ($str == 'Filtre:') $str = 'Filtre: Aucun.'.'</b>';
        return $str;
    }
    public function proprietesCategorie($type, $idCategories, $act) {
        $requests = new Requests();
        $requests->act = $act;
        $requests->all_status = $type;
        $requests->all_categories = $idCategories;
        if(session()->has('dtmp')) session()->forget('dtmp');
        session()->put('dtmp', $requests);
        return redirect()->route('searchP');
    }

    public function services() {
        $us = Help::getAuthUser();
        $titre = 'Services | Immobilier-Store';
        $categories = Categories::dataListe(Help::$ENTREPRISE);
        $services = Service::dataListe(Help::$ENTREPRISE);
        return view('pages.site.services', compact('us', 'titre', 'categories', 'services'));
    }
    public function serviceDetail($id) {
        $us = Help::getAuthUser();
        $titre = 'Detail Service | Immobilier-Store';
        $service = Service::where('ID_SERVICES', $id)->first();
        $categories = Categories::dataListe(Help::$ENTREPRISE);
        $services = Service::dataListe(Help::$ENTREPRISE);
        if(isset($proprietes->ID_PROPRIETES) && $proprietes->ID_PROPRIETES>0){
            $recent = Proprietes::proprieteRecent($proprietes->ID_PROPRIETES);
        }else{ $recent = []; }
        return view('pages.site.services-detail', compact('us', 'titre', 'categories', 'services', 'service', 'recent'));
    }
    public function apropos() {
        $us = Help::getAuthUser();
        $titre = 'A Propos de Nous | Immobilier-Store';
        $categories = Categories::dataListe(Help::$ENTREPRISE);
        $apropos = APropos::dataListe(Help::$ENTREPRISE);
        $personnes = Personnels::dataListe(Help::$ENTREPRISE);
        $agents = count($personnes);
        $counters = Proprietes::nbPropretiesByType(Help::$ENTREPRISE);
        return view('pages.site.apropos', compact('us', 'titre', 'categories', 'apropos', 'personnes', 'agents', 'counters'));
    }
    public function contact() {
        $us = Help::getAuthUser();
        $titre = 'Contactez-Nous | Immobilier-Store';
        $categories = Categories::dataListe(Help::$ENTREPRISE);
        return view('pages.site.contact', compact('us', 'titre', 'categories'));
    }

    public function creatAccount(){
        $act = 'account';
        $titre = 'Connexion | Immobilier-Store';
        $us = Help::getAuthUser();
        $libform = 'Creation de compte';
        $pays = Pays::dataListe(Help::$ACTIF);
        return view("pages.auth-login", compact('act', 'titre', 'us', 'libform', 'pays'));
    }
    public function ajaxInscription(Request $request, Client $obj) {
        $res = new ajaxResponse;
        if (isset($request->Civilite) && isset($request->Nom) && isset($request->Prenoms) && isset($request->Contact)
            && isset($request->Nationalite) && isset($request->IDPays) && isset($request->VilleID) && isset($request->Adresse)
            && isset($request->Email) && isset($request->Mdp)){

            $client = Client::LireSurEmail($request->Email);
            if (isset($client->ID_CLIENT) && $client->ID_CLIENT>0) {
                $res->code = 500; $res->mess = "Cette adresse email est déjà utilisé, veuillez renseigner une autre.";
            }else{
                $obj->CIVILITE = $request->Civilite;
                $obj->NOM = $request->Nom;
                $obj->PRENOMS = $request->Prenoms;
                $obj->CONTACT = $request->Contact;
                $obj->NATIONALITE = $request->Nationalite;
                $obj->ADR_EMAIL = $request->Email;
                $obj->ADRESSE = $request->Adresse;
                $obj->BOITE_POSTALE = '';
                $obj->STATUT = Help::$ACTIF;
                $obj->DATECREA = Help::dhSys();
                $obj->ID_PAYS = $request->IDPays;
                $obj->ID_VILLE = $request->VilleID;
                $obj->LIB_VILLE = Ville::libelleSurID($request->VilleID);
                if ($obj->save()){
                    $sel = Help::ChaineAleatoire(15);
                    $mdp = $request->Mdp;
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
                    $user->ID_ENTREPRISE = Help::$ENTREPRISE;
                    $user->ID_PROFIL = Help::$CLIENT;
                    $user->ID_CLIENT = $obj->ID_CLIENT;
                    $user->save();
                    $user = User::connexion($user->LOGIN, $mdp);
                    $res->code = 200;
                    $res->mess = 'success';
                }else{ $res->code = 500; $res->mess = "Une erreur s'est produite !"; }
            }
        }else{ $res->code = 500; $res->mess = "Une erreur s'est produite !"; }
        return $res;
    }

    public function succPage(){
        $act = 0;
        $titre = 'Statut compte | Immobilier-Store';
        $us = Help::getAuthUser();
        $dto = Help::getdto('dto');
        if (isset($dto->id) && $dto->id>0){
            $act = $dto->id;
        }
        return view("pages.succes", compact('titre', 'us', 'act'));
    }

    public function ajaxSaveMessage(Request $request, MessageInternaute $obj, ReponseMessage $resp) {
        $res = new ajaxResponse;
        if (isset($request->NomPren) && isset($request->Email) && isset($request->Sujet) && isset($request->Contact) && isset($request->Adresse) && isset($request->Mess)){
            $message = MessageInternaute::checkMessParJour(Help::$ENTREPRISE, $request->Email);
            if (count($message)==2) {
                $res->code = 500;
                $res->mess = "Message déjà transmis à l'un de nos agent. Il vous contactera dans les 24H.";
            }else{
                $obj->NOM_PRENOMS = $request->NomPren;
                $obj->CONTACT = $request->Contact;
                $obj->ADRESSE = $request->Adresse;
                $obj->ADR_EMAIL = $request->Email;
                $obj->SUJET = $request->Sujet;
                $obj->EST_LU = 0;
                $obj->STATUT = Help::$ACTIF;
                $obj->DATECREA = Help::dhSys();
                $obj->ID_ENTREPRISE = Help::$ENTREPRISE;
                $obj->ADR_IP_INTERNAUT = Help::getIp();
                if ($obj->save()){
                    $resp->ID_CONTACT = $obj->ID_CONTACT;
                    $resp->MESSAGE = $request->Mess;
                    $resp->EST_LU = 0;
                    $resp->EST_RECEPTEUR = Help::$E;
                    $resp->STATUT = Help::$ACTIF;
                    $resp->DATECREA = Help::dhSys();
                    $resp->save();
                    $res->code = 200;
                    $res->mess = "Votre message a été transmis à l'un de nos agent, vous serez contacté dans les 24H.";
                }else{ $res->code = 500; $res->mess = "Une erreur s'est produite !"; }
            }
        }else{ $res->code = 500; $res->mess = "Une erreur s'est produite !"; }
        return $res;
    }

    public function demandeVisite($idPropriete) {
        $act = $idPropriete;
        $us = Help::getAuthUser();
        session()->forget('dto');
        $titre = 'Demande de visite | Immobilier-Store';
        $idPays = 0;
        $pays = Pays::dataListe(Help::$ACTIF);
        if (count($pays)>0) {
            $idPays = $pays[0]->ID_PAYS;
        }
        $villes = Ville::dataListe($idPays, Help::$ACTIF);
        $client = Client::LireSurID($us->ID_CLIENT);
        $categories = Categories::dataListe(Help::$ENTREPRISE);
        $proprietes = Proprietes::proprietesDetail($idPropriete);
        $plan = ProprietesPlan::dataListe($idPropriete, Help::$ACTIF);
        $files = ProprieteImages::dataListe($idPropriete, Help::$ACTIF);
        return view('pages.site.dem-visite', compact('us', 'titre', 'client', 'categories', 'proprietes',
        'files', 'plan', 'act', 'pays', 'idPays', 'villes'));
    }
    public function cnxdemVisite($idPropriete) {
        $dto = new dto();
        $dto->key = "dto";
        $dto->var = "demvisit";
        $dto->id = $idPropriete;
        Help::dtosession($dto, 'dto');
        $res = new ajaxResponse;
        $res->code = 200;
        return $res;
        // return redirect()->route('cnxPage_A');
    }
    public function ajaxSaveDemandVisit(Request $request, DemandeVisite $obj){
        $mess = '';
        $res = new ajaxResponse;
        if ((!empty($request->param))) {
            $propriete = Proprietes::LireSurID($request->param);
            if (isset($propriete->ID_PROPRIETES) && $propriete->ID_PROPRIETES>0) {
                $us = Help::getAuthUser();
                if (empty($request->demtype)) {
                    $res->code = 422;
                    $res->mess = "Veuillez indiquer le type de votre demande.";
                    return $res;
                }
                if ($request->demtype==1) {
                    $validator = Validator::make($request->all(), [
                        'date' => [
                            'required',
                            'date_format:Y-m-d',
                            'after_or_equal:'.date("Y-m-d")
                        ],
                    ]);
                    if ($validator->fails()) {
                        $res->code = 422;
                        $res->mess = "Veuillez renseigner une date valide.";
                        return $res;
                    }
                }
                $bError = false;
                if (!empty($request->param) && !empty($us->ID_CLIENT)){
                    if ($us->ID_PROFIL!=Help::$CLIENT) {
                        $bError = true;
                        $res->code = 422;
                        $res->mess = "Profil de connexion non autorisé pour effectuer cette action.";
                    }
                }else{
                    if (!empty($request->param) &&
                        (   !empty($request->Civilite) && !empty($request->Nom) && !empty($request->Prenoms)
                            && !empty($request->Contact) && !empty($request->Nationalite) && !empty($request->IDPays)
                            && !empty($request->VilleID) && !empty($request->Adresse) && !empty($request->Email)
                        )
                    ){
                        $validator = Validator::make($request->all(), [
                            'Email' => [
                                'required',
                                'email'
                            ],
                        ]);
                        if ($validator->fails()) {
                            $bError = true;
                            $res->code = 422;
                            $res->mess = "Veuillez renseigner une adresse email valide.";
                        }
                    }else{ $bError = true; $res->code = 500; $res->mess = "Une erreur s'est produite 10900"; }
                }
                $email = (empty($us->ID_CLIENT)? $request->Email: $us->ADR_EMAIL);
                if ($bError == false && !empty($request->param)) {
                    $demande = DemandeVisite::checkDemParJour($propriete->ID_ENTREPRISE, $request->param, $email);
                    if (count($demande)==2) {
                        $res->code = 500;
                        $res->mess = "Vos demande pour la propriété $propriete->LIB_PROPRIETE sont en cours d'analyse, vous serez contacté dans les 24H.";
                    }else{
                        $idProspect = 0;
                        $prospect = new Prospect();
                        // Création nouveau prospect
                        if (empty($us->ID_CLIENT)) {
                            $client = Client::LireSurEmail($request->Email);
                            if (!empty($client->ID_CLIENT)) {
                                $bError = false;
                                $prospect->ID_CLIENT = $client->ID_CLIENT;
                                $mess = "Pour info.: Cette adresse email est déjà rattaché à un compte existant, ";
                                $mess .= "vous pouvez vous connectez a votre compte et suivre votre demande.";
                            }
                            $prospect->CIVILITE = $request->Civilite;
                            $prospect->NOM = $request->Nom;
                            $prospect->PRENOMS = $request->Prenoms;
                            $prospect->CONTACT = $request->Contact;
                            $prospect->NATIONALITE = $request->Nationalite;
                            $prospect->ADR_EMAIL = $request->Email;
                            $prospect->ADRESSE = $request->Adresse;
                            $prospect->BOITE_POSTALE = '';
                            $prospect->STATUT = Help::$ACTIF;
                            $prospect->DATECREA = Help::dhSys();
                            $prospect->ID_PAYS = $request->IDPays;
                            $prospect->ID_VILLE = $request->VilleID;
                            $prospect->LIB_VILLE = Ville::libelleSurID($request->VilleID);
                            $prospect->ID_ENTREPRISE = $propriete->ID_ENTREPRISE;
                            if ($prospect->save()==false){
                                $bError = true;
                                $res->code = 500;
                                $res->mess = "Une erreur s'est produite, echec de prise en compte de vos informations.";
                            }else{ $idProspect = $prospect->ID_PROSPECT; }
                        }else{
                            $prospect = Prospect::where('ID_CLIENT', $us->ID_CLIENT)->first();
                            if (!empty($prospect->ID_PROSPECT)) {
                                $idProspect = $prospect->ID_PROSPECT;
                            }else{
                                $bError = true;
                                $res->code = 500;
                                $res->mess = "Une erreur s'est produite, echec de recuperation de vos informations précédente.";
                            }
                        }
                        if ($bError==false && $idProspect>0)
                        {
                            $obj->ID_PROPRIETES = $request->param;
                            $obj->ID_CLIENT = $idProspect;
                            $obj->MESSAGE = $request->mess;
                            $obj->DATE_VISIT = $request->date;
                            $obj->HEUR_VISIT = $request->heur;
                            $obj->TYPE_DEMAND = $request->demtype;
                            $obj->ASSISTANCE = $request->valAssist;
                            $obj->STATUT = Help::$ENATTENTE;
                            $obj->DATECREA = Help::dhSys();
                            $obj->ID_ENTREPRISE = $propriete->ID_ENTREPRISE;
                            if ($obj->save())
                            {
                                $libelleEntreprise = Entreprise::LibelleEntreprise(1);
                                $res->code = 200;
                                $res->mess = "Votre demande a été soumise, vous serez contacté dans les 24H. ". $mess;
                                // Notifi client : [mail, database]



                                $sujet = "Nouvelle demande chez $libelleEntreprise";

                                $NomPrenoms = $prospect->NOM.' '.$prospect->PRENOMS;
                                $dateh = Help::dateheureFormate(Help::dhSys(),'/');
                                $libdemand = empty($obj->TYPE_DEMAND)? '': Help::LibelleTypeDemande($obj->TYPE_DEMAND);
                                $date = empty($obj->DATE_VISIT)? 'JJ/MM/AAAA': $obj->DATE_VISIT;
                                      $assistance = empty($obj->ASSISTANCE) ? 'Aucun Assistance' : $obj->ASSISTANCE;
                                $heure = empty($obj->HEUR_VISIT)? 'HH:MM': $obj->HEUR_VISIT;
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
                                    Votre nouvelle demande de <b>$libdemand</b>
                                    a été soumise avec succès, <br>
                                    <br>";

                                    if ($obj->TYPE_DEMAND==1) {
                                        $message .= "Date visite : $date <br>
                                        Heure : $heure <br>
                                        <br>";
                                    }

                                    $message .= "
                                    Propriete : $libpropriete <br>
                                    Assistance : <b> $assistance </b> <br>
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

                                // $prospect->notify(new DemandeClientNotification($prospect, $propriete, $obj));
                            }
                            else
                            {
                                $res->code = 500; $res->mess = "Une erreur 'save' s'est produite 5 !";
                            }
                        }
                    }
                }
            }else{ $res->code = 500; $res->mess = "Une erreur s'est produite, données propriété invalide."; }
        }else{ $res->code = 500; $res->mess = "Une erreur s'est produite, données invalide ou votre session a expirée !"; }
        return $res;
    }

    public function mailable() {
        // $prospect = Prospect::where('ID_PROSPECT', 1)->first();
        // $prospect->notify(new DemandeClientNotification($prospect, $propriete, $obj));
        return redirect()->route('cnxPage_A');
    }

}
