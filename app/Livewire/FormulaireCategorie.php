<?php

namespace App\Livewire;

use Help;
use Livewire\Component;
use App\Models\Categories;
use App\Models\TypeOffres;
use Livewire\WithFileUploads;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;

class FormulaireCategorie extends Component {

    use WithFileUploads;
    public $us;
    public $ID;

    public $typebien;
    public $libcategorie;
    public $description;
    public $imgID;
    public $image;
    public $icons;

    public $types;
    public $categories;

    protected function rules(){
        return [
            'libcategorie' => "required|min:5",
            'typebien' => "required|gt:0",
            'description' => "required|min:10",
        ];
    }

    protected $messages = [
        'libcategorie.required' => 'Veuillez renseigner une designation pour la catégorie.',
        'libcategorie.min' => 'Veuillez renseigner une designation valide, minimum 5 caractères.',
        'typebien.required' => 'Le \'type\' est obligatoire.',
        'typebien.gt' => 'Veuillez indiquer un type valide.',
        'description.required' => 'Veuillez renseigner une description pour la catégorie.',
        'description.min' => 'Veuillez renseigner une description valide, minimum 10 caractères.',
    ];

    public function mount($id){
        $this->ID = $id;
        if ($this->ID>0) {
            $data = Categories::find($id);
            if (isset($data->ID_CATEGORIES) && $data->ID_CATEGORIES>0) {
                $this->typebien = $data->ID_TYPE;
                $this->libcategorie = $data->LIB_CATEGORIE;
                $this->description = $data->DESCRIPTION_CATEGORIE;
            }else{ $this->addError('ajaxmess', 'Une erreur s\'est produite 1001'); }
        }else{ $this->categories = new Categories(); }
        $this->us = Help::getAuthUser();
        $this->types = TypeOffres::dataListe();
    }

    public function saveCategorie(){

        if ($this->ID!=null) {
            (bool) $bError = false;
            $obj = new Categories();
            if ($this->ID>0) {
                $obj = Categories::find($this->ID);
                if (!isset($obj->ID_CATEGORIES)) {
                    $bError = true;
                    $this->addError('ajaxmess', 'Une erreur s\'est produite 1002');
                }else{
                    $obj->DATEMAJ = Help::dhSys();
                    if (strtoupper($obj->LIB_CATEGORIE) != strtoupper($this->libcategorie)) {
                        $res = Categories::where('LIB_CATEGORIE', strtoupper($this->libcategorie))
                        ->where('ID_TYPE', $this->typebien)
                        ->where('ID_ENTREPRISE', $this->us->ID_ENTREPRISE)
                        ->where('STATUT', Help::$ACTIF)->first();
                        if (isset($res->ID_CATEGORIES)) {
                            $bError = true;
                            $this->addError('ajaxmess', 'Une catégorie de bien existe déjà pour la designation indiquée.');
                        }
                    }
                }
            }else{
                $res = Categories::where('LIB_CATEGORIE', strtoupper($this->libcategorie))
                ->where('ID_TYPE', $this->typebien)
                ->where('ID_ENTREPRISE', $this->us->ID_ENTREPRISE)
                ->where('STATUT', Help::$ACTIF)->first();
                if (isset($res->ID_CATEGORIES)) {
                    $bError = true;
                    $this->addError('ajaxmess', 'Une catégorie de bien existe déjà pour la designation indiquée.');
                }
            }
            if ($bError==false) {
                $this->validate();
                $obj->ID_TYPE = $this->typebien;
                $obj->LIB_CATEGORIE = strtoupper($this->libcategorie);
                $obj->DESCRIPTION_CATEGORIE = $this->description;
                if ($this->ID==0) {
                    // Cas creation
                    $obj->STATUT = Help::$ACTIF;
                    $obj->DATECREA = Help::dhSys();
                    $obj->ID_ENTREPRISE = $this->us->ID_ENTREPRISE;
                }
                if (isset($this->image) && $this->image!=null) {
                    $chemin = Help::fRepCree('/ImageCategories/'.$obj->ID_ENTREPRISE);
                    $fileName = trim(time().$this->image->getClientOriginalName());
                    $this->image->StoreAs('ImageCategories/'.$obj->ID_ENTREPRISE.'/', $fileName, "public_cemazone");
                    $obj->PATH_CATEGORIE = 'ImageCategories/'.$obj->ID_ENTREPRISE.'/'.$fileName;
                }
                $obj->save();
                redirect()->route('categorieList');
            }
        }

    }

    public function render() {
        return view('livewire.formulaire-categorie');
    }
}
