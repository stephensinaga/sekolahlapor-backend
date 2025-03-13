<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\BroadcastMessage;

class ReportStatusNotification extends Notification
{
    use Queueable;

    protected $status;
    protected $report;

    public function __construct($status, $report)
    {
        $this->status = $status;
        $this->report = $report;
    }

    // Tentukan channel notifikasi (email, database, broadcast, dll.)
    public function via($notifiable)
    {
        return ['database', 'broadcast']; // Notifikasi akan disimpan di database & dikirim via websocket
    }

    // Notifikasi untuk database
    public function toDatabase($notifiable)
    {
        return [
            'report_id' => $this->report->id,
            'status' => $this->status,
            'message' => "Status laporan Anda telah diperbarui menjadi: {$this->status}",
        ];
    }

    // Notifikasi untuk broadcast (real-time)
    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'report_id' => $this->report->id,
            'status' => $this->status,
            'message' => "Status laporan Anda telah diperbarui menjadi: {$this->status}",
        ]);
    }

    // Jika ingin mengirim email, tambahkan method ini
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Pembaruan Status Laporan')
                    ->line("Status laporan Anda telah diperbarui menjadi: {$this->status}")
                    ->action('Lihat Laporan', url("/reports/{$this->report->id}"))
                    ->line('Terima kasih telah menggunakan layanan kami!');
    }
}
