<?php

namespace App\Livewire;

use Help;
use App\Models\Client;
use Livewire\Component;
use App\Models\Entreprise;
use App\Mail\MailDiscution;
use Livewire\Attributes\On;
use Livewire\WithFileUploads;
use App\Models\ReponseMessage;
use App\Models\FichiersMessage;
use App\Models\MessageInternaute;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Http;
// use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\View;

class FormulaireMessage extends Component
{
    use WithFileUploads;
    public $option1;
    public $option2;
    public $client;
    public $nomprenoms;
    public $email;
    public $idClient;
    public $sujet;
    public $texte;
    public $fichID;
    public $fichier = [];
    public $clients;
    public $entreprise;

    protected function rules()
    {
        return [
            'nomprenoms' => "required",
            'email' => 'required|email',
            'sujet' => "required|min:5",
            'texte' => "required|min:5",
        ];
    }

    protected $messages = [
        'nomprenoms.required' => 'Veuillez renseigner un Nom & Prenoms.',
        'email' => 'Veuillez renseigner une adresse email valide.',
        'sujet.required' => 'Veuillez renseigner un sujet pour le message à envoyer.',
        'sujet.min' => 'Veuillez renseigner un sujet pour le message à envoyer, minimum 5 caractères',
        'texte.required' => 'Veuillez renseigner votre message.',
        'texte.min' => 'Veuillez renseigner un message valide, minimum 5 caractères',
    ];

    public function mount()
    {
        $us = Help::getAuthUser();
        $this->entreprise = Entreprise::where('ID_ENTREPRISE', $us->ID_ENTREPRISE)->first();
        $this->fichID = 0;
        $this->option1 = false;
        $this->option2 = false;
        $us = Help::getAuthUser();
        $this->clients = Client::dataListe($us->ID_ENTREPRISE);
    }

    #[On('updateWireChps')]
    public function updateWireChps($ch1, $ch2)
    {
        $this->option1 = $ch1;
        $this->option2 = $ch2;
    }

    public function sendMessage()
    {

        (bool) $berreur = false;

        if ($this->option2 === true) {
            if ($this->client === null || $this->client === 0) {
                $berreur = true;
                $this->addError('ajaxmess', 'Veuillez indiquez le client recepteur du message à envoyer');
            } else {
                $data = Client::where('ID_CLIENT', $this->client)->first();
                if (empty($data->ID_CLIENT)) {
                    $berreur = true;
                    $this->addError('ajaxmess', 'Echec de recupération des informations du client indiqué');
                } else {
                    $this->email = $data->ADR_EMAIL;
                    $this->nomprenoms = $data->PRENOMS . ' ' . $data->NOM;
                    $this->idClient = $data->ID_CLIENT;
                }
            }
        }

        if ($berreur === false) {

            $this->validate();

            $obj = new MessageInternaute();
            $obj->NOM_PRENOMS = $this->nomprenoms;
            $obj->CONTACT = '';
            $obj->ADRESSE = '';
            $obj->ID_CLIENT = $this->idClient ?? 0 ; //images du clients
            $obj->ADR_EMAIL = $this->email;
            $obj->SUJET = $this->sujet;
            $obj->EST_LU = 0;
            $obj->STATUT = Help::$ACTIF;
            $obj->DATECREA = Help::dhSys();
            $obj->ID_ENTREPRISE = Help::$ENTREPRISE;
            $obj->ADR_IP_INTERNAUT = Help::getIp();

            if ($obj->save()) {

                $mess = new ReponseMessage();
                $mess->ID_CONTACT = $obj->ID_CONTACT;
                $mess->MESSAGE = $this->texte;
                $mess->EST_LU = 0;
                $mess->EST_RECEPTEUR = Help::$C;
                $mess->STATUT = Help::$ACTIF;
                $mess->DATECREA = Help::dhSys();

                if ($mess->save()) {

                    foreach ($this->fichier as $key => $file) {
                        $PJ = new FichiersMessage();
                        $folder = "PiecesJointMessage/" . $obj->ID_CONTACT;
                        Help::fRepCree('/' . $folder);
                        $fileName = trim(time() . $file->getClientOriginalName());
                        $file->StoreAs($folder . '/', $fileName, "public_cemazone");
                        $PJ->STATUT = Help::$ACTIF;
                        $PJ->DATECREA = Help::dhSys();
                        $PJ->ID_MESSAGES = $obj->ID_CONTACT;
                        $PJ->ID_REPONSES = $mess->ID_REPONSES;
                        $PJ->PATH_FILES = $folder . '/' . $fileName;
                        $PJ->save();
                    }
                    $this->texte = "";
                    $this->fichID = 0;

                    $fichiers = FichiersMessage::fichiersListe($mess->ID_REPONSES);

                    $to = $this->email;
                    $subjet = $this->sujet;
                    // $contenu = view('emails.mail-discution', ['sujet'=>$subjet, 'data'=>$mess]);

                    $dateh = Help::dateheureFormate(Help::dhSys(), '/');
                    $domaine = Help::_domaine();

                    if (count($fichiers) > 0) {
                        foreach ($fichiers as $key => $value) {
                            $attachmenPath[] = public_path() . '/' . $value->PATH_FILES;
                        }
                        // $mailable = new MailDiscution($subjet, $obj, $attachmenPath);
                        // Mail::to($to)->send($mailable);
                    } else {
                        $attachmenPath = [];
                        // $mailable = new MailDiscution($subjet, $obj, $attachmenPath);
                        // Mail::to($to)->send($mailable);
                    }


                    $message = "
                <p>
                    Abidjan le: $dateh <br>
                   Objet : $subjet.</b>
                </p>
                <p>
                    Bonjour cher client
                </p>
                <p>
                    <br>
                    Vous avez reçu un nouveau message : <br>
                    <br>
                    $mess->MESSAGE
                    <br />

                    <br>
                    Nous vous remercions de la confiance que vous nous accordez. <br>
                    Cordialement, <br>
                    L'équipe Ligne, disponible 7j/7 via votre espace client <br>
                    - Pour une assistance technique <br>
                    - Pour une assistance commerciale
                    <br><br>
                     Cet message est egalement disponible sur votre espace client, ici <br> $domaine" . "sconnexion <br> <br />
                    Cordialement, <br />
                    Ceci est un mail automatique, vous ne pouvez pas y répondre. <br>
                    Contactez-nous directement via votre espace client via la rubrique MESSAGE. <br>
                </p>
                ";
                    $url = Help::appelApiEmail();
                    $template = View::make('emails.mail', ['contenumess' =>  $message, 'entreprise' => $this->entreprise])->render();

                    $data = [
                        'provider' => $this->entreprise->RAISON_SOCIALE . ' <info@mail-taseti.com>',
                        "key_rsa" => 're_2i7H3Ynf_KRVm9VwTsrwrfF8isCBYvyyE',
                        "destination" => $to ?? $this->email,
                        "sujet" => $subjet,
                        "message" => $template
                    ];
                    $retourAPI = Http::post($url, $data);


                    // if(count($fichiers)>0){
                    //     foreach ($fichiers as $key => $value) {
                    //         $attachmenPath[] = public_path().'/'.$value->PATH_FILES;
                    //     }
                    //     $mailable = new MailDiscution($subjet, $mess, $attachmenPath);
                    //     Mail::to($to)->send($mailable);
                    // }else{
                    //     $attachmenPath = [];
                    //     $mailable = new MailDiscution($subjet, $mess, $attachmenPath);
                    //     Mail::to($to)->send($mailable);
                    // }

                    $this->fichID = 0;
                    $this->option1 = false;
                    $this->option2 = false;
                }

                redirect()->route('messageDetail', ['id' => $obj->ID_CONTACT]);
            }
        }
    }

    public function render()
    {
        return view('livewire.formulaire-message');
    }
}
