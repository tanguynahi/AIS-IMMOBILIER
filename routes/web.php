<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\VitrineController;
use App\Http\Controllers\UtilisateurController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::redirect('/home', '/');
Route::get('/', [VitrineController::class, 'index_V'])->name('home');
Route::get('propriete-detail/{idPropriete}', [VitrineController::class, 'proprieteDetail'])->name('detailP');
Route::post('advance-search', [VitrineController::class, 'proprieteSearch'])->name('searchG');
Route::post('search-session', [VitrineController::class, 'SearchSess'])->name('searchS');
Route::get('advance-search', [VitrineController::class, 'proprieteSearch'])->name('searchP');
Route::get('proprietes-categorie/{type}/{idCategories}/{act}', [VitrineController::class, 'proprietesCategorie'])->name('listByCategories');
Route::get('service', [VitrineController::class, 'services'])->name('serviceOur');
Route::get('service-detail/{id}', [VitrineController::class, 'serviceDetail'])->name('detailServ');
Route::get('apropos-de-nous', [VitrineController::class, 'apropos'])->name('aproposUs');
Route::get('nous-contacter', [VitrineController::class, 'contact'])->name('contactUs');


Route::get('sendmail', [VitrineController::class, 'mailable'])->name('sendMail');


Route::get('connexion', [UtilisateurController::class, 'index_A'])->name('cnxPage_A');
Route::post('connexion', [UtilisateurController::class, 'ajaxCnx_A'])->name('ajaxCnx');
Route::get('deconnexion', [UtilisateurController::class, 'LoGOut'])->name('deconnexion');
Route::get('deconnect-dem', [UtilisateurController::class, 'demLoGOut'])->name('deconnectDem');


Route::get('nouveau-compte', [VitrineController::class, 'creatAccount'])->name('registerAccount');
Route::post('nouveau-compte', [VitrineController::class, 'ajaxInscription'])->name('ajaxAccount');
Route::post('send-message', [VitrineController::class, 'ajaxSaveMessage'])->name('ajaxSendMessage');
Route::get('statut-compte', [VitrineController::class, 'succPage'])->name('successPage');
Route::get('demande-visite/{idPropriete}', [VitrineController::class, 'demandeVisite'])->name('formdemande');
Route::get('demande-visite-cnx/{idPropriete}', [VitrineController::class, 'cnxdemVisite'])->name('cnxFordemande');
Route::post('demande-visite', [VitrineController::class, 'ajaxSaveDemandVisit'])->name('ajaxVisit');


Route::get('get-ville-list/{IDPays}', [UtilisateurController::class, 'getVilleList'])->name('donneVilleList');
Route::get('get-infoscategorie/{idcateG}', [UtilisateurController::class, 'getInfosCategorie'])->name('donneInfosCategorie');


Route::middleware('verifAuth')->prefix('backoffice')->group(function () {
    Route::get('tableau-de-bord', [UtilisateurController::class, 'adminTDB'])->name('tdb');

    Route::get('bannieres', [UtilisateurController::class, 'listBanniere'])->name('banniereList');
    Route::get('formulaire-banniere/{id}', [UtilisateurController::class, 'formBanniere'])->name('banniereForm');
    Route::get('banniere-desact/{idFile}', [UtilisateurController::class, 'desactiveBanniere'])->name('banniereDesact');

    Route::get('propriete', [UtilisateurController::class, 'listPropriete'])->name('proprieteList');
    Route::get('formulaire-propriete/{id}', [UtilisateurController::class, 'formPropriete'])->name('proprieteForm');
    Route::post('propriete', [UtilisateurController::class, 'validPropriete'])->name('proprieteValid');
    Route::get('lire-propriete/{id}', [UtilisateurController::class, 'lirePropriete'])->name('getPropriete');
    Route::get('propriete/{idPropriete}', [UtilisateurController::class, 'desactivePropriete'])->name('proprieteDesact');

    Route::get('galeries-propriete/{idPropriete}', [UtilisateurController::class, 'listGalerie'])->name('galerieList');
    Route::get('formulaire-galerie/{idPropriete}', [UtilisateurController::class, 'formGalerie'])->name('galerieForm');
    Route::post('galerie-propriete', [UtilisateurController::class, 'validGaleriePropriete'])->name('galerieValid');
    Route::get('galerie-propriete/{idFile}/{type}', [UtilisateurController::class, 'desactiveGalerie'])->name('galerieDesact');

    Route::get('messages', [UtilisateurController::class, 'messagesClient'])->name('messageList');
    Route::get('discutions/{id}', [UtilisateurController::class, 'discutionMessage'])->name('messageDetail');
    Route::get('nouveau-message', [UtilisateurController::class, 'nouveauMessage'])->name('messageNouveau');

    Route::get('demandes-visit-client', [UtilisateurController::class, 'demandVisit'])->name('demVisitList');
    Route::get('demandes-visit-detail/{idDemand}', [UtilisateurController::class, 'detailDemVisit'])->name('demandeForm');
    Route::get('approve-demande/{idDemand}', [UtilisateurController::class, 'approuveVisit'])->name('approuveDemande');
    Route::post('update-demande', [UtilisateurController::class, 'updateVisit'])->name('updateDemande');
    Route::post('reject-demande', [UtilisateurController::class, 'rejetVisit'])->name('rejectDemande');

    Route::get('clients', [UtilisateurController::class, 'listClient'])->name('clientList');
    Route::get('client-detail/{idClient}', [UtilisateurController::class, 'detailClient'])->name('clientForm');
    Route::get('affaire-form-cli/{idCli}/{id}', [UtilisateurController::class, 'affaireFormCli'])->name('affFormCli');
    Route::get('detail-affaire/{idAffaire}/{idPropriete}', [UtilisateurController::class, 'affaireDetail'])->name('affDetail');
    Route::get('prospects', [UtilisateurController::class, 'listProspect'])->name('prospectList');
    Route::get('prospects/{idProspect}', [UtilisateurController::class, 'validProspect'])->name('prospectValid');
    Route::get('prospect/{idProspect}', [UtilisateurController::class, 'desactiveProspect'])->name('prospectDesact');

    Route::get('redevance', [UtilisateurController::class, 'listRedevance'])->name('redevanceList');
    Route::get('formulaire-redevance/{id}', [UtilisateurController::class, 'formRedevance'])->name('redevanceForm');
    Route::post('redevance', [UtilisateurController::class, 'validRedevance'])->name('redevanceValid');
    Route::get('lire-redevance/{id}', [UtilisateurController::class, 'lireRedevance'])->name('getRedevance');
    Route::get('redevance/{idRedevance}', [UtilisateurController::class, 'desactiveRedevance'])->name('redevanceDesact');

    Route::get('categorie', [UtilisateurController::class, 'listCategorie'])->name('categorieList');
    Route::get('formulaire-categorie/{id}', [UtilisateurController::class, 'formCategorie'])->name('categorieForm');
    Route::get('categorie/{idCategories}', [UtilisateurController::class, 'desactiveCategorie'])->name('categorieDesact');

    Route::get('service', [UtilisateurController::class, 'listService'])->name('serviceList');
    Route::get('formulaire-service/{id}', [UtilisateurController::class, 'formService'])->name('serviceForm');
    Route::get('service/{idService}', [UtilisateurController::class, 'desactiveService'])->name('serviceDesact');

    Route::get('apropos', [UtilisateurController::class, 'listAPropos'])->name('aproposList');
    Route::get('formulaire-apropos/{id}', [UtilisateurController::class, 'formAPropos'])->name('aproposForm');
    Route::get('apropos/{idAPropos}', [UtilisateurController::class, 'desactiveAPropos'])->name('aproposDesact');

    Route::get('fonction', [UtilisateurController::class, 'listFonction'])->name('fonctionList');
    Route::get('formulaire-fonction/{id}', [UtilisateurController::class, 'formFonction'])->name('fonctionForm');
    Route::get('fonction/{idFonction}', [UtilisateurController::class, 'desactiveFonction'])->name('fonctionDesact');

    Route::get('agent', [UtilisateurController::class, 'listAgent'])->name('agentList');
    Route::get('formulaire-agent/{id}', [UtilisateurController::class, 'formAgent'])->name('agentForm');
    Route::get('agent/{idAgent}', [UtilisateurController::class, 'desactiveAgent'])->name('agentDesact');

    Route::get('affaire', [UtilisateurController::class, 'listAffaire'])->name('affaireList');
    Route::get('formulaire-affaire/{id}', [UtilisateurController::class, 'formAffaire'])->name('affaireForm');
    Route::post('affaire', [UtilisateurController::class, 'validAffaire'])->name('affaireValid');
    Route::get('lire-affaire/{id}', [UtilisateurController::class, 'lireAffaire'])->name('getAffaire');
    Route::get('affaire/{idAffaire}', [UtilisateurController::class, 'desactiveAffaire'])->name('affaireDesact');

    Route::get('facturation', [UtilisateurController::class, 'listLiaison'])->name('liaisonList');
    Route::get('formulaire-facturation/{id}', [UtilisateurController::class, 'formLiaison'])->name('liaisonForm');
    Route::post('facturation', [UtilisateurController::class, 'validLiaison'])->name('liaisonValid');
    Route::get('lire-facturation/{id}', [UtilisateurController::class, 'lireLiaison'])->name('getLiaison');
    Route::get('facturation/{idLiaison}', [UtilisateurController::class, 'desactiveLiaison'])->name('liaisonDesact');
    Route::get('affaire-client/{id}', [UtilisateurController::class, 'getAffaireClient'])->name('getAffaireClient');
    Route::get('affaire-infos/{id}', [UtilisateurController::class, 'getAffaire'])->name('getInfosAffaire');
    Route::get('redevance-infos/{id}', [UtilisateurController::class, 'getRedevance'])->name('getInfosRedevance');
    Route::post('calc-date', [UtilisateurController::class, 'calcDate'])->name('dateCalc');

    Route::get('paiement-list', [UtilisateurController::class, 'listPaiement'])->name('paiementList');
    Route::get('paiement-filtre/{p1}/{p2}/{p3}/{d1}/{d2}', [UtilisateurController::class, 'paiementFiltre'])->name('filtrePaiement');
    Route::get('paiement-detail/{idPaiement}', [UtilisateurController::class, 'detailPaiement'])->name('paiemForm');
    Route::post('paiement-update', [ClientController::class, 'updatePaiement'])->name('paiementUpdate');

    Route::get('approve-paiement/{idPaiement}', [UtilisateurController::class, 'paiementApprove'])->name('approuvePaiement');
    Route::post('reject-paiement', [UtilisateurController::class, 'paiementRejet'])->name('rejectPaiement');

    Route::get('entreprise', [UtilisateurController::class, 'infosEntreprise'])->name('entrepriseInfos');

    Route::controller(UtilisateurController::class)->group(function () {
        Route::post('traiteStoreEntreprise/{id}', 'traitementEntreprise')->name('store.entreprise');
        // Route::get('/pageAjout/{id}','AjouterPersonne')->name('ajouterL');
        Route::post('stroreBanniereUpdate/{id}','storeBaniere')->name('storeUpdateBanniere');
        Route::post('/storeUpdateCatego/{id}','UpdateStoreCategorie')->name('storCategorieUpd');
        Route::post('/traitementUpadateService/{id}','storeUpdateService')->name('updatStoreService');
        Route::post('/traiteAproposUdpStor/{id}','StoreUpdateApropos')->name('traiteSUApropos');
        Route::post('/updatStorePersonnel/{id}','UpStorPersonnel')->name('personnelStoreUpad');


    });
});


Route::get('state-payment/{codeP}', [ClientController::class, 'payCallBack'])->name('paymentCallback');

Route::middleware('verifAuthClient')->prefix('espace-client')->group(function () {
    Route::get('tableau-de-bord', [ClientController::class, 'clientTDB'])->name('tdbc');

    Route::get('boite-de-reception', [ClientController::class, 'messagesClient'])->name('messageListCli');
    Route::get('messages/{id}', [ClientController::class, 'discutionMessage'])->name('messageDetailCli');
    Route::get('nouvelle-discution', [ClientController::class, 'nouveauMessage'])->name('messageNouveauCli');

    Route::get('demandes-client', [ClientController::class, 'demandClient'])->name('demClientList');
    Route::get('demandes-detail/{idDemand}', [ClientController::class, 'detailDemande'])->name('demCliForm');
    Route::post('enregistre-demande', [ClientController::class, 'saveDemande'])->name('demSave');
    Route::get('demandes-desact/{idDemand}', [ClientController::class, 'desactDemande'])->name('demDesact');

    Route::get('propriete-acquis', [ClientController::class, 'listProprieteAcquis'])->name('proprieteGet');
    Route::get('affaire-detail/{idAffaire}', [ClientController::class, 'detailAffaire'])->name('affaireCliForm');

    Route::get('paiements-liste', [ClientController::class, 'paiementClient'])->name('paiemClientList');
    Route::get('paiements-listaffaire/{idAffaire}', [ClientController::class, 'paiementAffaire'])->name('paiementAffList');
    Route::get('form-paiements/{type}/{idAffaire}/{idLiais}', [ClientController::class, 'formPaiement'])->name('paiementForm');
    Route::post('save-paiement', [ClientController::class, 'savePaiement'])->name('paiementSave');
    Route::get('paiement-detail/{idPaiement}/{back}', [ClientController::class, 'detailPaiement'])->name('paiemCliForm');
    Route::post('paiement-update', [ClientController::class, 'updatePaiement'])->name('paiementUpdate');
    Route::get('paiement-desact/{idPaiement}', [ClientController::class, 'desactPaiement'])->name('paiementDesact');
    Route::get('documents-paiement/{idPaiement}/{back}', [ClientController::class, 'listPAYDocument'])->name('filePaiementList');
    Route::get('form-docpaiement/{idPaiement}/{back}', [ClientController::class, 'formPAYDocument'])->name('documentForm');
    Route::get('document-desact/{id}', [ClientController::class, 'desactiveDocument'])->name('documentDesact');
    Route::post('documents-paiement', [ClientController::class, 'validGaleriePropriete'])->name('documentValid');

    Route::get('facturation-list/{id}', [ClientController::class, 'getLiaisAffaireSurID'])->name('getListFacturation');
    Route::get('paiement-filtre/{param1}/{param2}', [ClientController::class, 'getPaiementFiltre'])->name('getPaiemFiltre');

    Route::get('profil', [ClientController::class, 'infosProfil'])->name('mesInfosCli');
    Route::post('profil', [ClientController::class, 'validProfil'])->name('profilValid');

    Route::get('nouveau-paiement/{id}', [ClientController::class, 'formPaiement_N'])->name('nouvPaiement');
    Route::post('nouveau-paiement', [ClientController::class, 'validPaiement_N'])->name('validNouvPaiement');
    Route::get('liais-info/{id}', [ClientController::class, 'infoFacturation'])->name('lireLIAIS');

    Route::post('paybox-hub', [ClientController::class, 'hubPayment'])->name('payboxHub');
});
