<?php

use App\Models\dto;
use App\Models\User;
use App\Models\UserAutos;
use App\Models\Entreprise;
use App\Models\ReponseMessage;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class Help {

    public static $ACTIF = 1;
    public static $INACTIF = 2;
    public static $ENATTENTE = 3;
    public static $REFUSE = 4;

    public static $ENTREPRISE = 1;
    public static $CIBLE_X = "FDMA TRAVAUX BATIMENT";

    // Pour la gestion des messages
    public static $E = 1; // Entreprise
    public static $C = 2; // Client

    // Types de règlements (utilisé dans la rubrique TypeReglement)
    public static $PAY_MANUEL= 1; // Règlement manuel
    public static $PAY_ENLIGNE = 2; // Règlement en ligne

    public static $SA = 1;
    public static $ADMIN = 2;
    public static $USER = 3;
    public static $CLIENT = 4;

    public static $LOGO = 'assets/img/logos/logo.png';
    public static $DEFAULT_AVATAR = '/boy_icon-icons.png';
    public static $VALID_IMG = 'assets/img/logos/0-4597.png';

    public static $CREDENSHEL = 'bv8d7g34d9';
    // public static $CREDENSHEL = 'wjgzxa9p5z';// pour brokers
    public static $API_KEY_HERE = 'AIzaSyDiw_DCMqoSQ5MoxmNqwbMKN_JEy-qQAS0';


    // public static function connexion_tiers() {
    //     return DB::connection('pgsqlr');
    // }
    // public static function getEntreprise() {
    //     $idEntreprise = Help::$ENTREPRISE;
    //     $entreprise = Help::connexion_tiers()
    //     ->table('ImmoREntreprise')
    //     ->where('ID_ENTREPRISE', $idEntreprise)->first();
    //     return $entreprise;
    // }

    public static function Infos() {
        return Entreprise::LireSurID(self::$ENTREPRISE);
    }

    public static function TypeExe(): string {
        $Type = 'REEL'; // PRODUCTION
        $Type = 'LOCAL'; // LOCAL
        $Type = 'TEST'; // TEST
        return $Type;
    }

    public static function _URL(): string {
        switch (self::TypeExe()) {
            case 'REEL':
                return self::_domaine();
            break;
            case 'TEST':
                return self::_domaine();
            break;
            default:
                return "http://127.0.0.1:8000";
            break;
        }
    }
    public static function _domaine(): string {
        switch (self::TypeExe()) {
            case 'REEL':
                return "https://fdma.ci/";
            break;
            case 'TEST':
            case 'LOCAL':
                return "https://fdma.ci/";
            break;
            default:
                return "http://127.0.0.1:8000/";
            break;
        }
    }

    public static function messageBrut(array $tableauDeChaines){
        $chainefinale = '';
        // Parcourir le tableau et afficher chaque élément
        foreach ($tableauDeChaines as $chaine) {
            $chainefinale .= $chaine . "\n";
        }
        return $chainefinale;
    }

    public static function NbNonLu($idEntreprise) {
        return ReponseMessage::selectRaw('"ImmoReponses".*')
        ->join('ImmoContact', 'ImmoContact.ID_CONTACT', '=', 'ImmoReponses.ID_CONTACT')
        ->where('ImmoReponses.EST_LU', '=', 0)
        ->where('ImmoReponses.EST_RECEPTEUR', self::$E)
        ->where('ImmoContact.STATUT', self::$ACTIF)
        ->where('ImmoContact.ID_ENTREPRISE', $idEntreprise)
        ->where('ImmoReponses.STATUT', self::$ACTIF)->count();
    }

    public static function cliNbNonLu($email) {
        return ReponseMessage::selectRaw('"ImmoReponses".*')
        ->join('ImmoContact', 'ImmoContact.ID_CONTACT', '=', 'ImmoReponses.ID_CONTACT')
        ->where('ImmoReponses.EST_LU', '=', 0)
        ->where('ImmoReponses.EST_RECEPTEUR', self::$C)
        ->where('ImmoContact.ADR_EMAIL', $email)
        ->where('ImmoContact.STATUT', self::$ACTIF)
        ->where('ImmoReponses.STATUT', self::$ACTIF)->count();
    }

    public static function duration($time){
        $Lastdate = Carbon::parse($time);
        $Nowdate = Carbon::now();
        $result = $Lastdate->diffForHumans($Nowdate);
        $result = str_replace(array("hour", "hours"), "heure", $result);
        $result = str_replace("day", "jour", $result);
        $result = str_replace("days", "jours", $result);
        $result = str_replace("week", "semaine", $result);
        $result = str_replace("weeks", "semaines", $result);
        $result = str_replace(array("month", "months"), "mois", $result);
        $result = str_replace("year", "an", $result);
        $result = str_replace("years", "ans", $result);
        $result = str_replace(array("avant", "before"), "", $result);
        return "Il y a " . $result;
    }

    public static function codesListe(){
        return [
            ['code'=>'MSG', 'libelle'=>'MESSAGE'],
            ['code'=>'DEM', 'libelle'=>'DEMANDES CLIENT'],
            ['code'=>'PSP', 'libelle'=>'PROSPECT'],
            ['code'=>'CLI', 'libelle'=>'CLIENT'],
            ['code'=>'AFF', 'libelle'=>'PROPRIETES ACQUISES'],
            ['code'=>'FAC', 'libelle'=>'FACTURATION'],
            ['code'=>'REG', 'libelle'=>'SUIVIS PAIEMENTS'],
            ['code'=>'PRO', 'libelle'=>'PROPRIETES'],
            ['code'=>'RED', 'libelle'=>'REDEVANCES'],
            ['code'=>'CAT', 'libelle'=>'CATEGORIES'],
            ['code'=>'SER', 'libelle'=>'SERVICES'],
            ['code'=>'APR', 'libelle'=>'A PROPOS'],
            ['code'=>'FAG', 'libelle'=>'FONCTION AGENT'],
            ['code'=>'AGT', 'libelle'=>'AGENTS/PERSONNELS'],
            ['code'=>'ACC', 'libelle'=>'COMPTE UTILISATEUR'],
            ['code'=>'PAR', 'libelle'=>'PARAMETRES'],
            ['code'=>'ZZZ', 'libelle'=>'TOUS LES DROITS'],
        ];
    }

    public static function optAutorise(array $codeList, $iduser): bool{
        return UserAutos::AccesOPT($codeList, $iduser);
    }

    public static function AuthKEY() : string {
        return 'authUSER';
    }
    public static function AuthIns() : string {
        return 'tmpIns';
    }

    public static function check(){
        $obj = self::getAuthUser();
        if (isset($obj->USER_ONLINE) && $obj->USER_ONLINE==true) return true;
        else return false;
    }

    public static function to_session($obj) {
        if(isset($obj->USER_ONLINE) && $obj->USER_ONLINE == true){
            if(session()->has(self::AuthKEY())) session()->forget(self::AuthKEY());
            session()->put(self::AuthKEY(), $obj);
            return self::getAuthUser();
        }else{ return new User(); }
    }

    public static function dtosession($obj, $cle) {
        if(isset($obj->var)){
            if(session()->has($cle)) session()->forget($cle);
            session()->put($cle, $obj);
            return self::getdto($cle);
        }else{ return new dto(); }
    }
    public static function getdto($cle){
        if(session()->has($cle)) return session()->get($cle);
        else return new dto();
    }

    public static function getAuthUser(){
        if(session()->has(self::AuthKEY())) return session()->get(self::AuthKEY());
        else return new User();
    }

    public static function refreshData($obj): bool {
        if (!session()->has(self::AuthKEY())) {
            session()->forget(self::AuthKEY());
        }
        session()->put(self::AuthKEY(), $obj);
        return true;
    }

    public static function logOut(){
        session()->forget(self::AuthKEY());
        return true;
    }

    public static function ChaineAleatoire(int $len) {
        $str = 'AaBbCcDdEeFfGgHhIiJjKkLlMmNnOoPpQqRrSsTtUuVvWwXxYyZz0123456789';
        $randomStr = '';
        for ($i = 0; $i < $len; $i++) {
            $index = rand(0, strlen($str) - 1);
            $randomStr .= $str[$index];
        }
        return $randomStr;
    }
    public static function strRefPaiement(int $len) {
        $randomStr = '';
        $str = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        for ($i = 0; $i < $len; $i++) {
            $index = rand(0, strlen($str) - 1);
            $randomStr .= $str[$index];
        }
        return $randomStr;
    }

    public static function dhSys(): String{
        return date("YmdHis");
    }
    public static function DateSys(): String{
        return date("Ymd");
    }

    public static function HashPassword(String $password, String $sel): String{
        $leurr = substr($sel, 7, 3);
        return Hash::make($sel."@".$password.$leurr);
    }
    public static function HashVerifier(String $password, String $sel, String $dbPass): bool{
        $leurr = substr($sel, 7, 3);
        return Hash::check($sel."@".$password.$leurr, $dbPass);
    }

    public static function strCut($string, $min=0, $max = 16, $end = '...') {
        if (strlen($string) > $max) {
            $string = substr($string, $min, $max - strlen($end)).$end;
        }
        return $string;
    }

    public static function formatNombre($valeur, $monetaire = false, $devise = "F"){
        if($monetaire == true) return number_format($valeur,0,",",".")." $devise";
        else return number_format($valeur,0,",",".");
    }

    public static function cDateJour() {
        setlocale(LC_ALL, 'fr_FR.UTF8', 'fr_FR','fr','fr','fra','fr_FR@euro');
        return "".utf8_encode(strftime("%A %d %B %Y"));
    }
    public static function ChaineVersDate($Jour, $Sep) {
        if (strlen($Jour)>=8) {
            $Jour = substr($Jour, 0, 8);
            $Jour = substr($Jour, -2). $Sep .substr($Jour, 4, -2). $Sep .substr($Jour, 0, 4);
        }
        return $Jour;
    }
    public static function firstdayOfmonth($date){
        return date("Y-m-01", strtotime($date));
    }
    public static function lastdayOfmonth($date){
        return date("Y-m-t", strtotime($date));
    }

    public static function cryptage($str) {
        return Crypt::encryptString($str);
    }

    public static function decryptage($str) {
        try {
            return Crypt::decryptString($str);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public static function getIp(){
        if(!empty($_SERVER['HTTP_CLIENT_IP'])){
          $ip = $_SERVER['HTTP_CLIENT_IP'];
        }elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
          $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }else{
          $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }

    public static function dateheureFormate($dh, $Sep){
        $dheure = $dh;
        if (strlen($dh)==8) {
            $date = substr($dh, 0, 8);
            $dheure = substr($date, -2). $Sep .substr($date, 4, -2). $Sep .substr($date, 0, 4). '00:00:00';
        }else{
            if (strlen($dh)>8) {
                $date = substr($dh, 0, 8);
                $dheure = substr($date, -2). $Sep .substr($date, 4, -2). $Sep .substr($date, 0, 4). ' '.substr($dh, 8, 2). ':' .substr($dh, 10, 2). ':' .substr($dh, 12, 4);
            }
        }
        return $dheure;
    }

    public static function NumericToStr(int $Numero, int $length = 0) {
        ($length > 0) ? $length = $length : $length = 3;
        $char = 0;
        $type = 'd';
        $format = "%{$char}{$length}{$type}"; // or "$010d";
        // Store to a variable
        $newFormat = sprintf($format, $Numero);
        return $newFormat;
    }

    public static function LibelleMoyenSurID($id): String{
        switch ($id) {
            case '2':
                return 'Cash';
                break;
            case '3':
                return 'Chèque';
                break;
            case '4':
                return 'Virement';
                break;

            default:
                return 'undefined';
                break;
        }
    }
    public static function LibelleTypeDemande($typdem): String{
        switch ($typdem) {
            case '1':
                return 'Visite de propriété';
                break;
            case '2':
                return 'Information par appel';
                break;
            case '3':
                return 'Information par email';
                break;
            case '4':
                return 'Autre';
                break;
            default:
                return 'undefined';
            break;
        }
    }

    public static function fRepCree($str){;
        $chemin = public_path().$str;
        if (!file_exists($chemin)) {
            mkdir($chemin, 0777, true);
        }
        return $chemin;
    }


    public static function appelApiEmail()
    {
        $exe = 'REEL';
        $exe = 'LOCAL';
        if ($exe == 'REEL') {
            return "https://mailtremo.paysecurehub.com/api/sendemail";
        } else {
            return "http://mailtremo.paysecurehub.com/api/sendemail";
        }
    }

    public static function lienHub()
    {
        $exe = 'REEL';
        $exe = 'LOCAL';
        if ($exe == 'REEL') {
            return "https://rest-airtime.paysecurehub.com/api/payhub-ws/build-away";
        } else {
            return "http://rest-airtime.paysecurehub.com/api/payhub-ws/build-away";
        }
    }
    public static function appelHbu()
    {
        $exe = 'REEL';
        $exe = 'LOCAL';
        if ($exe == 'REEL') {
            return "https://fdma.ci/";
            // return "https://" . self::getIp() . ":8000/";
        } else {
            return "https://" . self::getIp() . ":8000/";
        }
    }

}
