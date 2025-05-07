<?php

namespace App\Notifications;

use App\Models\Prospect;
use App\Models\Proprietes;
use App\Models\DemandeVisite;
use Illuminate\Bus\Queueable;
use App\Models\NotificationsUser;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DemandeRejetNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public Prospect $prospect, public Proprietes $propriete, public DemandeVisite $demande)
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail','database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $iddem= $this->demande->ID_DEMANDE_VISIT;
        $libuser = $this->prospect->NOM.' '.$this->prospect->PRENOMS;
        $nbmail = NotificationsUser::NbNotifications() + 1;
        return (new MailMessage)
        ->subject('Demande rejetee')
        ->view("emails.demande-rejetee", [
            "id" => $iddem,
            "idmail" => $nbmail,
            'NomPrenoms' => $libuser,
            "demande" => $this->demande,
            "propriete" => $this->propriete
        ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        $motif = $this->demande->MOTIFS;
        $id = $this->demande->ID_DEMANDE_VISIT;
        $libprop = $this->propriete->LIB_PROPRIETE;
        $libuser = $this->prospect->NOM.' '.$this->prospect->PRENOMS;
        $nbmail = NotificationsUser::NbNotifications() + 1;
        return [
            "message"=>"La demande n° $id du client $libuser pour la propriete '$libprop'a ete rejetee, au motif de: $motif",
            "identifiant"=>"$id",
            "refmail"=>$nbmail
        ];
    }
}
