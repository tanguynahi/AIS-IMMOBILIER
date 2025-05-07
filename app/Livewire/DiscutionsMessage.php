<?php

namespace App\Livewire;

use Help;
use App\Models\User;
use Livewire\Component;
use App\Models\Entreprise;
use App\Mail\MailDiscution;
use Livewire\WithFileUploads;
use App\Models\ReponseMessage;
use App\Models\FichiersMessage;
use App\Models\MessageInternaute;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\View;

class DiscutionsMessage extends Component
{
    use WithFileUploads;
    public $ID;
    public $texte;
    public $fichID;
    public $fichier = [];
    public $discutions;
    public $nomprenoms;
    public $avatar;
    public $contacts;
    public $entreprise;

    protected function rules()
    {
        return [
            'texte' => "required",
        ];
    }

    protected $messages = [
        'texte.required' => 'Veuillez renseigner un message.',
    ];

    public function mount($id)
    {
        $us = Help::getAuthUser();
        $this->entreprise = Entreprise::where('ID_ENTREPRISE', $us->ID_ENTREPRISE)->first();
        $this->ID = $id;
        $this->fichID = 0;
        $this->contacts = MessageInternaute::LireMessage($this->ID);
        if(!empty($this->contacts->ID_CLIENT)){
            $this->avatar = User::where('ID_CLIENT',$this->contacts->ID_CLIENT)->value('AVATAR');
        }
        if (!empty($this->contacts->ID_CONTACT)) {
            $discutions = ReponseMessage::ListResponses($this->ID);
            foreach ($discutions as $key => $m) {
                if ($m->EST_LU === 0 && $m->EST_RECEPTEUR === Help::$E) {
                    $m->EST_LU = 1;
                    $m->save();
                }
            }
        }
    }

    public function sendMessage()
    {

        if (!empty($this->contacts->ID_CONTACT)) {

            $this->validate();

            $obj = new ReponseMessage();
            $obj->ID_CONTACT = $this->ID;
            $obj->MESSAGE = $this->texte;
            $obj->EST_LU = 0;
            $obj->EST_RECEPTEUR = Help::$C;
            $obj->STATUT = Help::$ACTIF;
            $obj->DATECREA = Help::dhSys();

            if ($obj->save()) {

                foreach ($this->fichier as $key => $file) {
                    $PJ = new FichiersMessage();
                    $folder = "PiecesJointMessage/" . $this->ID;
                    Help::fRepCree('/' . $folder);
                    $fileName = trim(time() . $file->getClientOriginalName());
                    $file->StoreAs($folder . '/', $fileName, "public_cemazone");
                    $PJ->STATUT = Help::$ACTIF;
                    $PJ->DATECREA = Help::dhSys();
                    $PJ->ID_MESSAGES = $this->ID;
                    $PJ->ID_REPONSES = $obj->ID_REPONSES;
                    $PJ->PATH_FILES = $folder . '/' . $fileName;
                    $PJ->save();
                }
                $this->texte = "";
                $this->fichID = 0;

                $fichiers = FichiersMessage::fichiersListe($obj->ID_REPONSES);


                $subjet = $this->contacts->SUJET.' n°'.$obj->ID_REPONSES;
                $to = $this->contacts->ADR_EMAIL;
                // $contenu = view('emails.mail-discution', ['sujet' => $subjet, 'data' => $obj]);
                // $entreprise = Entreprise::find(1);
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
                      Vous avez reçu un nouveau message  : <br>
                    <br>
                    $obj->MESSAGE
                    <br />

                    <br>
                    Nous vous remercions de la confiance que vous nous accordez. <br>
                    Cordialement, <br>
                    L'équipe Ligne, disponible 7j/7 via votre espace client <br>
                    - Pour une assistance technique <br>
                    - Pour une assistance commerciale
                    <br><br>
                     Cet message est egalement disponible sur votre espace client, ici <br> $domaine" . "connexion <br> <br />
                    Cordialement, <br />
                    Ceci est un mail automatique, vous ne pouvez pas y répondre. <br>
                    Contactez-nous directement via votre espace client via la rubrique MESSAGE. <br>
                </p>
                ";

                $url = Help::appelApiEmail();
                $template = View::make('emails.mail', ['contenumess' => $message,'entreprise'=> $this->entreprise])->render();

                $data = [
                  'provider' => $this->entreprise->RAISON_SOCIALE . ' <info@mail-taseti.com>',
                    "key_rsa" => 're_2i7H3Ynf_KRVm9VwTsrwrfF8isCBYvyyE',
                    "destination" => $to ?? $this->contacts->ADR_EMAIL,
                    "sujet" => $subjet,
                    "message" => $template
                ];
                $retourAPI = Http::post($url, $data);
                // if ($retourAPI->status() === 200) {
                //     if ($retourAPI['status'] === 200) {


                //     } else {
                //         if ($retourAPI['status'] == 422) {
                //             $mess = Help::messageBrut($retourAPI['message']);
                //         } else {
                //             $mess = $retourAPI['message'];
                //         }
                //     }
                // } else {
                //     $mess = 'Une erreur inattendue s\'est produite, verifier que vous avez accès à internet, ' .
                //         'puis reéssayer. erreur ' . $retourAPI->status();
                // }



                // if (count($fichiers) > 0) {
                //     foreach ($fichiers as $key => $value) {
                //         $attachmenPath[] = public_path() . '/' . $value->PATH_FILES;
                //     }
                //     $mailable = new MailDiscution($subjet, $obj, $attachmenPath);
                //     Mail::to($to)->send($mailable);
                // } else {
                //     $attachmenPath = [];
                //     $mailable = new MailDiscution($subjet, $obj, $attachmenPath);
                //     Mail::to($to)->send($mailable);
                // }
            }
        } else {
            $this->addError('ajaxmess', 'Une erreur s\'est produite 403');
        }
    }

    public function render()
    {
        if ($this->ID > 0) {
            $this->discutions = ReponseMessage::reponseListe($this->ID, Help::$E);
            if (!empty($this->discutions->ID_REPONSES)) {
                $this->addError('ajaxmess', 'Une erreur s\'est produite 1001');
            }
        } else {
            $this->discutions = [];
        }
        return view('livewire.discutions-message');
    }
}
