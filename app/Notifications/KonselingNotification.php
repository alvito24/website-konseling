<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Konseling;
use App\Models\Konseling;

class KonselingNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $konseling;
    protected $type;
    protected $message;

    public function __construct(Konseling $konseling, $type, $message)
    {
        $this->konseling = $konseling;
        $this->type = $type;
        $this->message = $message;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Notifikasi Konseling - ' . ucfirst($this->type))
            ->line($this->message)
            ->action('Lihat Detail', route('konseling.show', $this->konseling))
            ->line('Terima kasih telah menggunakan layanan konseling kami.');
    }

    public function toArray($notifiable)
    {
        return [
            'konseling_id' => $this->konseling->id,
            'type' => $this->type,
            'message' => $this->message,
        ];
    }
}