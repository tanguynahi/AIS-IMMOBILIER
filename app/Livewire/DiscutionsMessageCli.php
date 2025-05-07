<?php

namespace App\Livewire;

use Help;
use Livewire\Component;
use App\Models\Entreprise;
use App\Mail\MailDiscution;
use Livewire\WithFileUploads;
use App\Models\ReponseMessage;
use App\Models\FichiersMessage;
use App\Models\MessageInternaute;
use Illuminate\Support\Facades\Mail;

class DiscutionsMessageCli extends Component
{
    use WithFileUploads;
    public $ID;
    public $us;
    public $texte;
    public $fichID;
    public $fichier = [];
    public $discutions;
    public $nomprenoms;
    public $contacts;
    public $entreprise;

    protected function rules(){
        return [
            'texte' => "required",
        ];
    }

    protected $messages = [
        'texte.required' => 'Veuillez renseigner un message.',
    ];

    public function mount($id) {
        $this->ID = $id;
        $this->entreprise = Entreprise::find(1);
        $this->fichID = 0;
        $this->contacts = MessageInternaute::LireMessage($this->ID);
        if(!empty($this->contacts->ID_CONTACT)){
            $discutions = ReponseMessage::ListResponses($this->ID);
            foreach ($discutions as $key=>$m) {
                if ($m->EST_LU===0 && $m->EST_RECEPTEUR===Help::$C) {
                    $m->EST_LU = 1;
                    $m->save();
                }
            }
        }
        $this->us = Help::getAuthUser();
    }

    public function sendMessage() {

        if (!empty($this->contacts->ID_CONTACT)){

            $this->validate();

            $obj = new ReponseMessage();
            $obj->ID_CONTACT = $this->ID;
            $obj->MESSAGE = $this->texte;
            $obj->EST_LU = 0;
            $obj->EST_RECEPTEUR = Help::$E;
            $obj->STATUT = Help::$ACTIF;
            $obj->DATECREA = Help::dhSys();

            if ($obj->save()){

                foreach ($this->fichier as $key=>$file) {
                    $PJ = new FichiersMessage();
                    $folder = "PiecesJointMessage/" . $this->ID;
                    Help::fRepCree('/' . $folder);
                    $fileName = trim(time().$file->getClientOriginalName());
                    $file->StoreAs($folder . '/', $fileName, "public_cemazone");
                    $PJ->STATUT = Help::$ACTIF;
                    $PJ->DATECREA = Help::dhSys();
                    $PJ->ID_MESSAGES = $this->ID;
                    $PJ->ID_REPONSES = $obj->ID_REPONSES;
                    $PJ->PATH_FILES = $folder . '/'.$fileName;
                    $PJ->save();
                }
                $this->texte = "";
                $this->fichID = 0;

                // $fichiers = FichiersMessage::fichiersListe($obj->ID_REPONSES);

                // $subjet = $this->contacts->SUJET;
                // $to = $this->contacts->ADR_EMAIL;
                // $contenu = view('emails.mail-discution', ['sujet'=>$subjet, 'data'=>$obj]);

                // if(count($fichiers)>0){
                //     foreach ($fichiers as $key => $value) {
                //         $attachmenPath[] = public_path().'/'.$value->PATH_FILES;
                //     }
                //     $mailable = new MailDiscution($subjet, $obj, $attachmenPath);
                //     Mail::to($to)->send($mailable);
                // }else{
                //     $attachmenPath = [];
                //     $mailable = new MailDiscution($subjet, $obj, $attachmenPath);
                //     Mail::to($to)->send($mailable);
                // }

            }

        }else{ $this->addError('ajaxmess', 'Une erreur s\'est produite 403'); }

    }

    public function render() {
        if ($this->ID>0) {
            $this->discutions = ReponseMessage::reponseListe($this->ID, Help::$C);
            if (!empty($this->discutions->ID_REPONSES)) {
                $this->addError('ajaxmess', 'Une erreur s\'est produite 1001');
            }
        }else{ $this->discutions = []; }
        return view('livewire.discutions-message-cli');
    }
}
