<?php

class STPayBoxValue
{
    public $code;
    public $numTel;
    public $cleretour;
    public $datePaiement;
    public $codePaiement;
    public $moyenPaiement;
    public $HeurePaiement;
    public $referencePaiement;
    public $montant;
    public $no_transation;
    public $benefice;
    public $service_id;
    public $p_last_wallet_amount;
    public $p_new_wallet_amount;
    public $url_callbk;

    public function __construct(
        $code = 0,
        $numTel = '',
        $cleretour = '',
        $datePaiement = '',
        $codePaiement = '',
        $moyenPaiement = '',
        $HeurePaiement = '',
        $referencePaiement = '',
        $montant = 0,
        $no_transation = '',
        $benefice = 0,
        $service_id = 0,
        $p_last_wallet_amount = 0,
        $p_new_wallet_amount = 0,
        $url_callbk = '',
    ) {
        $this->code = $code;
        $this->numTel = $numTel;
        $this->cleretour = $cleretour;
        $this->datePaiement = $datePaiement;
        $this->codePaiement = $codePaiement;
        $this->moyenPaiement = $moyenPaiement;
        $this->HeurePaiement = $HeurePaiement;
        $this->referencePaiement = $referencePaiement;
        $this->montant = $montant;
        $this->no_transation = $no_transation;
        $this->benefice = $benefice;
        $this->service_id = $service_id;
        $this->p_last_wallet_amount = $p_last_wallet_amount;
        $this->p_new_wallet_amount = $p_new_wallet_amount;
        $this->url_callbk = $url_callbk;
    }
}
