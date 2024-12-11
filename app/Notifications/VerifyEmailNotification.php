<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class VerifyEmailNotification extends Notification
{
    public function __construct()
    {
        //
    }

    public function via($notifiable)
    {
        return ['mail']; // Kirim melalui email
    }

    public function toMail($notifiable) { return (new MailMessage) ->subject('Verifikasi Email') ->line('Silakan klik tombol di bawah untuk memverifikasi email Anda.') ->action('Verifikasi Email', url('/verify-email/' . $notifiable->id . '/' . sha1($notifiable->getEmailForVerification()))) ->line('Jika Anda tidak membuat akun, tidak perlu melakukan tindakan lebih lanjut.'); }
}
