<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AccountVerified extends Notification implements ShouldQueue
{
    use Queueable;

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Selamat! Akun Kamu Sudah Aktif')
            ->line('Halo! Akun kamu udah diverifikasi sama admin nih.')
            ->line('Sekarang kamu udah bisa login ke sistem Hati dan Layar Bersatu.')
            ->action('Yuk Login', route('login'));
    }

    public function toArray($notifiable)
    {
        return [
            'title' => 'Akun Diverifikasi',
            'message' => 'Akun Anda telah diverifikasi oleh admin.',
        ];
    }
}