<?php

namespace App\Livewire;

use Help;
use App\Models\Client;
use Livewire\Component;
use App\Mail\MailDiscution;
use Livewire\WithFileUploads;
use App\Models\ReponseMessage;
use App\Models\FichiersMessage;
use App\Models\MessageInternaute;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Mail;

class FormMessageCli extends Component
{
    use WithFileUploads;
    public $us;
    public $sujet;
    public $texte;
    public $fichID;
    public $idClient;
    public $fichier = [];

    protected function rules(){
        return [
            'sujet' => "required|min:5",
            'texte' => "required|min:5",
        ];
    }

    protected $messages = [
        'sujet.required' => 'Veuillez renseigner un sujet pour le message à envoyer.',
        'sujet.min' => 'Veuillez renseigner un sujet pour le message à envoyer, minimum 5 caractères',
        'texte.required' => 'Veuillez renseigner votre message.',
        'texte.min' => 'Veuillez renseigner un message valide, minimum 5 caractères',
    ];

    public function mount() {
        $this->fichID = 0;
        $this->us = Help::getAuthUser();
    }

    public function sendMessage() {

        (bool) $berreur = false;

        $data = Client::where('ID_CLIENT', $this->us->ID_CLIENT)->first();
        if (empty($data->ID_CLIENT)) {
            $berreur = true;
            $this->addError('ajaxmess', 'Echec de recupération de vos informations');
        }else{
            if (empty($data->CONTACT) || empty($data->ADRESSE) || empty($data->ADR_EMAIL)) {
                $berreur = true;
                $this->addError('ajaxmess', 'Une erreur s\'est produite, données erronées.');
            }
            $this->idClient = $data->ID_CLIENT;
        }

        if ($berreur===false) {

            $this->validate();

            $obj = new MessageInternaute();
            $obj->NOM_PRENOMS = $data->PRENOMS .' '. $data->NOM;
            $obj->CONTACT = $data->CONTACT;
            $obj->ADRESSE = $data->ADRESSE;
            $obj->ID_CLIENT = $this->idClient ?? '';
            $obj->ADR_EMAIL = $data->ADR_EMAIL;
            $obj->SUJET = $this->sujet;
            $obj->EST_LU = 0;
            $obj->STATUT = Help::$ACTIF;
            $obj->DATECREA = Help::dhSys();
            $obj->ID_ENTREPRISE = Help::$ENTREPRISE;
            $obj->ADR_IP_INTERNAUT = Help::getIp();

            if ($obj->save()){

                $mess = new ReponseMessage();
                $mess->ID_CONTACT = $obj->ID_CONTACT;
                $mess->MESSAGE = $this->texte;
                $mess->EST_LU = 0;
                $mess->EST_RECEPTEUR = Help::$E;
                $mess->STATUT = Help::$ACTIF;
                $mess->DATECREA = Help::dhSys();

                if ($mess->save()){

                    foreach ($this->fichier as $key=>$file) {
                        $PJ = new FichiersMessage();
                        $folder = "PiecesJointMessage/" . $obj->ID_CONTACT;
                        Help::fRepCree('/' . $folder);
                        $fileName = trim(time().$file->getClientOriginalName());
                        $file->StoreAs($folder . '/', $fileName, "public_cemazone");
                        $PJ->STATUT = Help::$ACTIF;
                        $PJ->DATECREA = Help::dhSys();
                        $PJ->ID_MESSAGES = $obj->ID_CONTACT;
                        $PJ->ID_REPONSES = $mess->ID_REPONSES;
                        $PJ->PATH_FILES = $folder . '/'.$fileName;
                        $PJ->save();
                    }
                    $this->texte = "";
                    $this->fichID = 0;
                }

                redirect()->route('messageDetailCli',['id'=>$obj->ID_CONTACT]);

            }

        }

    }

    public function render() {
        return view('livewire.form-message-cli');
    }

}
