<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use App\Models\NotificationsUser;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CompteClientNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct()
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
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail(object $notifiable): MailMessage
    {
        $motpass = '012024';
        $login = $notifiable->LOGIN;
        $iduser = $notifiable->ID_UTILISATEUR;
        $libuser = $notifiable->NOM.' '.$notifiable->PRENOMS;
        $nbmail = NotificationsUser::NbNotifications() + 1;
        return (new MailMessage)
        ->subject('Identifants de votre gestion immo')
        ->view("emails.identifiants-compte", [
            "id" => $iduser,
            'NomPrenoms' => $libuser,
            "login" => $login,
            "mdp" => $motpass,
            "idmail" => $nbmail
        ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray($notifiable): array
    {
        $motpass = '012024';
        $login = $notifiable->LOGIN;
        $iduser = $notifiable->ID_UTILISATEUR;
        $libuser = $notifiable->NOM.' '.$notifiable->PRENOMS;
        $nbmail = NotificationsUser::NbNotifications() + 1;
        return [
            "message"=>"Un nouvel identifiant client a été crée pour $libuser.",
            "identifiant"=>"IMS-$iduser",
            "login"=>$login,
            "refmail"=>$nbmail,
            "mdp"=>$motpass
        ];
    }
}
