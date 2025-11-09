<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AccountRejected extends Notification implements ShouldQueue
{
    use Queueable;

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Maaf, Pendaftaran Belum Bisa Disetujui')
            ->line('Mohon maaf ya, pendaftaran kamu di sistem Hati dan Layar Bersatu belum bisa disetujui.')
            ->line('Kayaknya ada data yang nggak cocok sama data sekolah nih.')
            ->line('Coba deh hubungi admin sekolah buat tau lebih lanjut ya.');
    }
}