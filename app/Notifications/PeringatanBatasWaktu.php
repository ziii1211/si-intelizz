<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PeringatanBatasWaktu extends Notification
{
    use Queueable;

    protected $pesan;
    protected $url;

    public function __construct($pesan, $url)
    {
        $this->pesan = $pesan;
        $this->url = $url;
    }

    public function via($notifiable)
    {
        // Kita simpan notifikasinya ke database
        return ['database'];
    }

    public function toArray($notifiable)
    {
        // Ini data yang bakal dibaca sama lonceng di Dashboard
        return [
            'pesan' => $this->pesan,
            'url' => $this->url,
        ];
    }
}
