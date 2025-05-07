<?php

namespace App\Livewire;

use Help;
use Livewire\Component;
use App\Models\Bannieres;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;

class FormBanniere extends Component {

    use WithFileUploads;
    public $us;
    public $IdB;
    public $banniere;

    public $avatar;
    public $libelle;
    public $description;

    protected function rules(){
        return [
            'avatar' => "required",
            'avatar.*' => "image|mimes:jpg,jpeg,png|max:2048"
        ];
    }

    protected $messages = [
        'avatar.required' => 'Vous devez sélectionner une image pour la bannière',
        'avatar.*' => 'fichier requis au format jpg,jpeg,png, taille:2048 octets)'
    ];

    public function mount($id) {

        $this->banniere = new Bannieres();
        $this->us = Help::getAuthUser();

        if (!empty($this->us->ID_UTILISATEUR)) {
            $this->IdB = $id;
            if (!empty($this->IdB)) {
                $this->banniere = Bannieres::LireSurID($this->IdB);
            }
            $this->razChps($this->banniere);
        }else{ redirect()->route('cnxPage_A'); }

    }

    public function razChps(Bannieres $obj){
        $this->avatar = $obj->PATH_BAN;
        $this->libelle = $obj->TITRE_INFO;
        $this->description = $obj->CONTENU_INFO;
    }

    public function valideForm(){

        // dd($this->avatar);
        $this->validate();
        (bool) $err = false;
        $obj = new Bannieres();

        if (!empty($this->banniere->ID_BANNIERES)) {
            $obj = Bannieres::LireSurID($this->banniere->ID_BANNIERES);
            if (empty($obj->ID_BANNIERES)) {
                $err = true;
                $this->addError('ajaxmess', 'Une erreur s\'est produite, EDIT_DATA_NOT_FOUND');
            }else{ $obj->DATEMAJ = Help::dhSys(); }
        }else{
            $obj->STATUT = Help::$ACTIF;
            $obj->DATECREA = Help::dhSys();
            $obj->ID_ENTREPRISE = $this->us->ID_ENTREPRISE;
        }

        if ($err===false) {

            DB::beginTransaction();

            try {

                $obj->TITRE_INFO = $this->libelle;
                $obj->CONTENU_INFO = $this->description;
                $obj->save();

                $chemin = Help::fRepCree('/filesBANN/bann'. $obj->ID_BANNIERES);
                $chemin = 'filesBANN/bann'. $obj->ID_BANNIERES. '/';

                if (!empty($this->avatar) && ($this->banniere->PATH_BAN!==$this->avatar)) {
                    $file_ext = pathinfo($this->avatar->getClientOriginalName(), PATHINFO_EXTENSION);
                    $fileName = 'BANN_'.Help::dhSys().'_'. $obj->ID_BANNIERES.'.'. $file_ext;
                    $this->avatar->StoreAs($chemin, $fileName, "public_cemazone");
                    $obj->PATH_BAN = $chemin . $fileName;
                    $obj->save();
                }
                DB::commit();
                redirect()->route('banniereList');

            } catch (\Throwable $th) {
                DB::rollback();
                $mess = 'Une erreur s\'est produite, votre action n\'a pas été prise en compte. ERR:'. $th->getMessage();
                $this->addError('ajaxmess', $mess);
            }

        }

    }

    public function render() {
        return view('livewire.form-banniere');
    }

}
