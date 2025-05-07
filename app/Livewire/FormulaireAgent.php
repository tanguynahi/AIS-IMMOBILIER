<?php

namespace App\Livewire;

use Help;
use Livewire\Component;
use App\Models\Personnels;
use Livewire\WithFileUploads;
use Illuminate\Validation\Rule;
use App\Models\FonctionPersonnel;
use Livewire\Attributes\Validate;

class FormulaireAgent extends Component
{
    use WithFileUploads;
    public $us;
    public $ID;
    public $nom;
    public $prenoms;
    public $contact;
    public $adremail;
    public $urlfbk;
    public $urltwt;
    public $imgID;
    public $image;
    #[Validate('required', message: 'Veuillez indiquer une fonction pour l\'agent', onUpdate: false)]
    #[Validate('gt:0', message: 'Veuillez selectionner une fonction valide', onUpdate: false)]
    public $fonctID;
    public $agents;
    public $fonctions;

    protected function rules(){
        return [
            'nom' => "required|min:5",
            'prenoms' => "required|min:5",
            'contact' => "required|min:10",
        ];
    }

    protected $messages = [
        'nom.required' => 'Veuillez renseigner le nom de l\'agent.',
        'nom.min' => 'Veuillez renseigner un nom valide, minimum 5 caractères.',
        'prenoms.required' => 'Veuillez renseigner le prenoms de l\'agent.',
        'prenoms.min' => 'Veuillez renseigner un prenoms valide, minimum 5 caractères.',
        'contact.required' => 'Veuillez renseigner le contact de l\'agent.',
        'contact.min' => 'Veuillez renseigner un contact valide, minimum 10 caractères.',
    ];

    public function mount($id){
        $this->ID = $id;
        if ($this->ID>0) {
            $data = Personnels::find($id);
            if (isset($data->ID_PERSONNELS) && $data->ID_PERSONNELS>0) {
                $this->nom = $data->NOM_PERS;
                $this->prenoms = $data->PRENOMS_PERS;
                $this->contact = $data->CONTACT;
                $this->adremail = $data->ADR_EMAIL;
                $this->urlfbk = $data->URL_FBK;
                $this->urltwt = $data->URL_TWT;
                $this->fonctID = $data->ID_FONCTION_PERS;
            }else{ $this->addError('ajaxmess', 'Une erreur s\'est produite 1001'); }
        }else{ $this->agents = new Personnels(); }
        $this->us = Help::getAuthUser();
        $this->fonctions = FonctionPersonnel::dataListe($this->us->ID_ENTREPRISE);
    }

    public function saveAgent(){

        if ($this->ID!=null) {
            (bool) $bError = false;
            $obj = new Personnels();
            if ($this->ID>0) {
                $obj = Personnels::find($this->ID);
                if (!isset($obj->ID_PERSONNELS)) {
                    $bError = true;
                    $this->addError('ajaxmess', 'Une erreur s\'est produite 1002');
                }else{ $obj->DATEMAJ = Help::dhSys(); }
            }
            if ($bError==false) {
                $this->validate();
                $obj->NOM_PERS = $this->nom;
                $obj->PRENOMS_PERS = $this->prenoms;
                $obj->CONTACT = $this->contact;
                $obj->ADR_EMAIL = $this->adremail;
                $obj->URL_FBK = $this->urlfbk;
                $obj->URL_TWT = $this->urltwt;
                $obj->ID_FONCTION_PERS = $this->fonctID;
                if ($this->ID==0) {
                    // Cas creation
                    $obj->STATUT = Help::$ACTIF;
                    $obj->DATECREA = Help::dhSys();
                    $obj->ID_ENTREPRISE = $this->us->ID_ENTREPRISE;
                }
                if (isset($this->image) && $this->image!=null) {
                    $chemin = Help::fRepCree('/PhotoPersonnel/'.$obj->ID_ENTREPRISE);
                    $fileName = trim(time().$this->image->getClientOriginalName());
                    $this->image->StoreAs('PhotoPersonnel/'.$obj->ID_ENTREPRISE.'/', $fileName, "public_cemazone");
                    $obj->PATH_PERS = 'PhotoPersonnel/'.$obj->ID_ENTREPRISE.'/'.$fileName;
                }
                $obj->save();
                redirect()->route('agentList');
            }
        }

    }

    public function render() {
        return view('livewire.formulaire-agent');
    }
    
}
