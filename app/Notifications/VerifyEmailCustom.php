<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Carbon;

class VerifyEmailCustom extends VerifyEmail
{
    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable)
    {
        $verificationUrl = $this->verificationUrl($notifiable);

        return (new MailMessage)
            ->subject('🇧🇯 Vérifiez votre adresse email - Culture Bénin')
            ->greeting('Bonjour ' . $notifiable->prenom . ' ' . $notifiable->nom .  ' !  👋')
            ->line('Bienvenue sur **Culture Bénin**, la plateforme dédiée à la promotion et la préservation de notre riche patrimoine culturel béninois.')
            ->line('Nous sommes ravis de vous compter parmi nous !')
            ->line('Pour finaliser votre inscription et accéder à toutes les fonctionnalités, veuillez vérifier votre adresse email en cliquant sur le bouton ci-dessous :')
            ->action('✅ Vérifier mon email', $verificationUrl)
            ->line('Ce lien est valable pendant **60 minutes**.')
            ->line('Si vous n\'avez pas créé de compte sur Culture Bénin, aucune action n\'est requise de votre part.')
            ->salutation('Cordialement,
L\'équipe Culture Bénin 🇧🇯');
        // ❌ SUPPRIMÉ : ->with(['notifiable' => $notifiable]);
    }

    /**
     * Get the verification URL for the given notifiable.
     */
    protected function verificationUrl($notifiable)
    {
        return URL::temporarySignedRoute(
            'verification.verify',
            Carbon::now()->addMinutes(60),
            [
                'id' => $notifiable->getKey(),
                'hash' => sha1($notifiable->getEmailForVerification()),
            ]
        );
    }
}
