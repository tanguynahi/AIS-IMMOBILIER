<?php

namespace App\Livewire;

use Help;
use App\Models\User;
use App\Models\Droits;
use Livewire\Component;
use App\Models\UserAutos;
use App\Models\Entreprise;
use App\Models\Personnels;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;

class InfosEntreprise extends Component {

    use WithFileUploads;
    public $IDE;
    public $libel;
    public $iduscnx;
    public $entreprise;
    public $roles = [];
    public $comptes = [];
    public $personnels = [];

    public $raisonsociale;
    public $adresse;
    public $contact1;
    public $contact2;
    public $adremail;
    public $slogan;
    public $descriptif;
    public $termsconditions;
    public $urlfbk;
    public $urltwt;
    public $urllink;
    public $urldemo;
    public $logo;

    public $compteopt;
    public $formcompte;

    public $idus;
    public $idpersonnel;
    public $login;
    public $motdepasse;
    public $passcnx;
    public $MSG;
    public $DEM;
    public $PSP;
    public $CLI;
    public $AFF;
    public $FAC;
    public $REG;
    public $PRO;
    public $RED;
    public $CAT;
    public $SER;
    public $APR;
    public $FAG;
    public $AGT;
    public $ACC;
    public $PAR;
    public $ZZZ;

    public function mount($id, $idcnx){
        $this->IDE = $id;
        $this->idus = 0;
        $this->compteopt = 1;
        $this->idpersonnel = 0;
        $this->passcnx = false;
        $this->iduscnx = $idcnx;
        $this->formcompte = false;
        $this->motdepasse = '012024';
        $entreprise = Entreprise::LireSurID($this->IDE);
        if (empty($entreprise->ID_ENTREPRISE)) {
            redirect()->route('tdb');
        }else{
            $this->raisonsociale = $entreprise->RAISON_SOCIALE;
            $this->adresse = $entreprise->ADRESSE;
            $this->contact1 = $entreprise->CONTACT1;
            $this->contact2 = $entreprise->CONTACT2;
            $this->adremail = $entreprise->ADR_EMAIL;
            $this->slogan = $entreprise->SLOGAN;
            $this->descriptif = $entreprise->DESCRIPTIF;
            $this->termsconditions = $entreprise->TERMS_CONDITIONS;
            $this->logo = $entreprise->LOGO;
            $this->urlfbk = $entreprise->URLFBK;
            $this->urltwt = $entreprise->URLTWT;
            $this->urllink = $entreprise->URLLINK;
            $this->urldemo = $entreprise->URLDEMO;
            $this->libel = "Information sur " . $entreprise->RAISON_SOCIALE;
        }
    }

    public function passChange(){
        $this->passcnx = $this->passcnx;
    }

    public function optionSelect($option){
        $this->compteopt = $option;
        if ($this->compteopt==1) {
            $this->formcompte = false;
        }else{
            $this->comptes = DB::select('
            SELECT
                "ImmoUtilisateur"."ID_UTILISATEUR" AS "ID_UTILISATEUR",
                "ImmoUtilisateur"."NOM" AS "NOM",
                "ImmoUtilisateur"."PRENOMS" AS "PRENOMS",
                "ImmoUtilisateur"."CONTACT" AS "CONTACT",
                "ImmoUtilisateur"."LOGIN" AS "LOGIN",
                "ImmoUtilisateur"."STATUT" AS "STATUT",
                "FonctionPersonne"."LIB_FONCTION" AS "LIB_FONCTION"
            FROM
                "ImmoUtilisateur" INNER JOIN "ImmoPersonnels"
                ON "ImmoUtilisateur"."ID_PERSONNELS" = "ImmoPersonnels"."ID_PERSONNELS"
                INNER JOIN "FonctionPersonne" ON "FonctionPersonne"."ID_FONCTION_PERS" = "ImmoPersonnels"."ID_FONCTION_PERS"
            WHERE
                "ImmoUtilisateur"."ID_PROFIL" = 3
                AND "ImmoPersonnels"."ID_PERSONNELS" > 1
                AND "ImmoUtilisateur"."STATUT" = 1
                AND "ImmoUtilisateur"."ID_ENTREPRISE" = '.$this->IDE.'
            ORDER BY
                "ImmoUtilisateur"."ID_UTILISATEUR" DESC
            ');
        }
    }

    public function validInfos(){
        if (!empty($this->IDE)) {
            $entreprise = Entreprise::LireSurID($this->IDE);
            if (empty($entreprise->ID_ENTREPRISE)) {
                $this->addError('ajaxmess', 'Une erreur s\'est produite 404, votre action n\'a pas été prise en compte');
            }else{
                $entreprise->DATEMAJ = Help::dhSys();
                $entreprise->RAISON_SOCIALE = $this->raisonsociale;
                $entreprise->ADRESSE = $this->adresse;
                $entreprise->CONTACT1 = $this->contact1;
                $entreprise->CONTACT2 = $this->contact2;
                $entreprise->ADR_EMAIL = $this->adremail;
                $entreprise->DESCRIPTIF = $this->descriptif;
                $entreprise->SLOGAN = $this->slogan;
                $entreprise->TERMS_CONDITIONS = $this->termsconditions;
                $entreprise->URLFBK = $this->urlfbk;
                $entreprise->URLTWT = $this->urltwt;
                $entreprise->URLLINK = $this->urllink;
                $entreprise->URLDEMO = $this->urldemo;
                if (!empty($this->logo) && ($this->logo!=$entreprise->LOGO)) {
                    $chemin = Help::fRepCree('/docEntreprise/');
                    $file_ext = pathinfo($this->logo->getClientOriginalName(), PATHINFO_EXTENSION);
                    $fileName = 'LOG_'.Help::dhSys() .'_'. $entreprise->ID_ENTREPRISE .'.'. $file_ext;
                    $this->logo->StoreAs('docEntreprise/', $fileName, "public_cemazone");
                    $entreprise->LOGO = 'docEntreprise/'.$fileName;
                }
                $entreprise->save();
                $this->addError('ajaxmessR', 'Enregistré avec succès.');
            }
        }else{ $this->addError('ajaxmess', 'Une erreur s\'est produite 403.'); }
    }

    public function accountForm($act, $id){
        $this->idus = $id;
        $this->formcompte = ($act==1? true: false);
        $this->roles = Droits::liste();
        $this->optionSelect(2);// Compte utilisateur
        $this->personnels = Personnels::liste($this->IDE);
        // Cas de modification compte
        if (!empty($this->idus)) {
            $account = User::LireSurID($this->idus);
            if (empty($account->ID_UTILISATEUR)) {
                $this->addError('ajaxmess', 'Une erreur s\'est produite 404, compte utilisateur introuvable pour mise à jour');
            }else{
                // Infos compte
                $this->login = $account->LOGIN;
                $this->passcnx = $account->MDP_A_LA_CNX;
                $this->motdepasse = $account->MOT_DE_PASSE;
                $this->idpersonnel = $account->ID_PERSONNELS;
                // Roles
                $acces = UserAutos::Liste($account->ID_UTILISATEUR);
                foreach ($acces as $key => $value) {
                    switch ($value->CODE_ACCES) {
                        case 'MSG': $this->MSG=true; break;
                        case 'DEM': $this->DEM=true; break;
                        case 'PSP': $this->PSP=true; break;
                        case 'CLI': $this->CLI=true; break;
                        case 'AFF': $this->AFF=true; break;
                        case 'FAC': $this->FAC=true; break;
                        case 'REG': $this->REG=true; break;
                        case 'PRO': $this->PRO=true; break;
                        case 'RED': $this->RED=true; break;
                        case 'CAT': $this->CAT=true; break;
                        case 'SER': $this->SER=true; break;
                        case 'APR': $this->APR=true; break;
                        case 'FAG': $this->FAG=true; break;
                        case 'AGT': $this->AGT=true; break;
                        case 'ACC': $this->ACC=true; break;
                        case 'PAR': $this->PAR=true; break;
                        case 'ZZZ': $this->ZZZ=true; break;
                    }
                }
            }
        }else{
            $this->login = ''; $this->motdepasse = ''; $this->passcnx = false; $this->idpersonnel = 0;
            $this->MSG=false; $this->DEM=false; $this->PSP=false; $this->CLI=false; $this->AFF=false;
            $this->FAC=false; $this->REG=false; $this->PRO=false; $this->RED=false; $this->CAT=false;
            $this->SER=false; $this->APR=false; $this->FAG=false; $this->AGT=false; $this->ACC=false;
            $this->PAR=false; $this->ZZZ=false;
        }
    }

    public function validCompte(){

        if (!empty($this->IDE)) {

            (bool) $err = false;

            if (empty($this->idpersonnel)) {
                $err = true;
                $this->addError('ajaxmess', 'Veuillez indiquer un \'Agents/Personnels\' pour le compte');
            }else{
                if (empty($this->login) || strlen($this->login)<6) {
                    $err = true;
                    $this->addError('ajaxmess', 'Veuillez renseigner un \'Login\' valide, minimum 6 caractères');
                }else{
                    if ((empty($this->motdepasse) || strlen($this->motdepasse)<6) && empty($this->idus)) {
                        $err = true;
                        $this->addError('ajaxmess', 'Veuillez renseigner un \'Mot de passe\' valide, minimum 6 caractères');
                    }else{
                        $user = User::LireSurIDPERS($this->idpersonnel);
                        if (!empty($user->ID_UTILISATEUR) && empty($this->idus)) {
                            $err = true;
                            $this->addError('ajaxmess', 'Le \'Agent/Personnel\' indiqué a déjà un compte actif !');
                        }else{
                            $user = User::LireLogin($this->login);
                            if (!empty($user->ID_UTILISATEUR) && empty($this->idus)) {
                                $err = true;
                                $this->addError('ajaxmess', 'Le \'Login\' indiqué existe déjà !');
                            }else{
                                $personnel = Personnels::LireSurID($this->idpersonnel);
                                if (empty($personnel->ID_PERSONNELS)) {
                                    $err = true;
                                    $this->addError('ajaxmess', 'Une erreur s\'est produite 404, \'Agent/Personnel\' non trouvé');
                                }
                            }
                        }
                    }
                }
            }
            
            if ($err == false){
                $account = new User();
                // Infos utilisateur
                if (!empty($this->idus)) {
                    $account = User::LireSurID($this->idus);
                    if (empty($account->ID_UTILISATEUR)) {
                        $err = true;
                        $this->addError('ajaxmess', 'Une erreur s\'est produite 404, compte utilisateur introuvable !');
                    }else{ $account->DATEMAJ = Help::dhSys(); }
                }else{
                    $account->STATUT = Help::$ACTIF;
                    $account->DATECREA = Help::dhSys();
                    $account->LOGIN = $this->login;
                    $account->SEL = Help::ChaineAleatoire(15);
                    $account->MDP_A_LA_CNX = $this->passcnx;
                    $account->MOT_DE_PASSE = ($this->passcnx==false? Help::HashPassword($this->motdepasse, $account->SEL): '');
                    $account->ID_PROFIL = Help::$USER;
                    $account->ID_CLIENT = 0;
                    $account->ID_PERSONNELS = $this->idpersonnel;
                    $account->AVATAR = Help::$DEFAULT_AVATAR;
                    $account->ID_ENTREPRISE = $this->IDE;
                }
                $account->NOM = $personnel->NOM_PERS;
                $account->PRENOMS = $personnel->PRENOMS_PERS;
                $account->CONTACT = $personnel->CONTACT;
                $account->ADR_EMAIL = $personnel->ADR_EMAIL;
                if ($err==false) {

                    $account->save();
                    // Roles utilisateur
                    $this->roles = Droits::liste();
                    foreach ($this->roles as $key => $value) {

                        $acces = UserAutos::LireSurID($value->ID_DROITS_ACCES, $account->ID_UTILISATEUR);
                        if (empty($acces->ID_USER_AUTORISES)) {
                            $acces->STATUT = Help::$ACTIF;
                            $acces->DATECREA = Help::dhSys();
                            $acces->ID_UTILISATEUR = $account->ID_UTILISATEUR;
                        }else{ $acces->DATEMAJ = Help::dhSys(); }

                        switch ($value->CODE_ACCES) {
                            case 'MSG': $acces->ID_DROITS_ACCES = ($this->MSG==true? $value->ID_DROITS_ACCES: 0); break;
                            case 'DEM': $acces->ID_DROITS_ACCES = ($this->DEM==true? $value->ID_DROITS_ACCES: 0); break;
                            case 'PSP': $acces->ID_DROITS_ACCES = ($this->PSP==true? $value->ID_DROITS_ACCES: 0); break;
                            case 'CLI': $acces->ID_DROITS_ACCES = ($this->CLI==true? $value->ID_DROITS_ACCES: 0); break;
                            case 'AFF': $acces->ID_DROITS_ACCES = ($this->AFF==true? $value->ID_DROITS_ACCES: 0); break;
                            case 'FAC': $acces->ID_DROITS_ACCES = ($this->FAC==true? $value->ID_DROITS_ACCES: 0); break;
                            case 'REG': $acces->ID_DROITS_ACCES = ($this->REG==true? $value->ID_DROITS_ACCES: 0); break;
                            case 'PRO': $acces->ID_DROITS_ACCES = ($this->PRO==true? $value->ID_DROITS_ACCES: 0); break;
                            case 'RED': $acces->ID_DROITS_ACCES = ($this->RED==true? $value->ID_DROITS_ACCES: 0); break;
                            case 'CAT': $acces->ID_DROITS_ACCES = ($this->CAT==true? $value->ID_DROITS_ACCES: 0); break;
                            case 'SER': $acces->ID_DROITS_ACCES = ($this->SER==true? $value->ID_DROITS_ACCES: 0); break;
                            case 'APR': $acces->ID_DROITS_ACCES = ($this->APR==true? $value->ID_DROITS_ACCES: 0); break;
                            case 'FAG': $acces->ID_DROITS_ACCES = ($this->FAG==true? $value->ID_DROITS_ACCES: 0); break;
                            case 'AGT': $acces->ID_DROITS_ACCES = ($this->AGT==true? $value->ID_DROITS_ACCES: 0); break;
                            case 'ACC': $acces->ID_DROITS_ACCES = ($this->ACC==true? $value->ID_DROITS_ACCES: 0); break;
                            case 'PAR': $acces->ID_DROITS_ACCES = ($this->PAR==true? $value->ID_DROITS_ACCES: 0); break;
                            case 'ZZZ': $acces->ID_DROITS_ACCES = ($this->ZZZ==true? $value->ID_DROITS_ACCES: 0); break;
                        }

                        if (empty($acces->ID_USER_AUTORISES)) {
                            // Cas inexistant
                           if (!empty($acces->ID_DROITS_ACCES)) $acces->save();
                        }else{
                            // Cas Existant
                            if (empty($acces->ID_DROITS_ACCES)){
                                // retrait de l'acces
                                $acces->STATUT = Help::$INACTIF;
                                $acces->ID_DROITS_ACCES = $value->ID_DROITS_ACCES;
                            }else{ $acces->STATUT = Help::$ACTIF; }// Attribution acces
                            $acces->save();
                        }

                    }
                    $this->accountForm(0, 0);
                }
            }

        }else{ $this->addError('ajaxmess', 'Une erreur s\'est produite 422.'); }
    }

    public function render() {
        return view('livewire.infos-entreprise');
    }

}
