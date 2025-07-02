<?php
// app/Notifications/TaskDeadlineReminder.php

namespace App\Notifications;

use App\Models\Tasks;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TaskDeadlineReminder extends Notification implements ShouldQueue
{
    use Queueable;

    protected $task;
    protected $reminderType;

    /**
     * @param \App\Models\Tasks $task Tugas yang akan diingatkan
     * @param string $reminderType Jenis pengingat ('1 hari' atau '3 jam')
     */
    public function __construct(Tasks $task, string $reminderType)
    {
        $this->task = $task;
        $this->reminderType = $reminderType;
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $deadlineFormatted = \Carbon\Carbon::parse($this->task->deadline)->format('d M Y, H:i');

        return (new MailMessage)
                    ->subject('Pengingat Deadline Tugas: ' . $this->task->judul_tugas)
                    ->greeting('Halo, ' . $notifiable->name . '!')
                    ->line('Ini adalah pengingat bahwa tugas Anda akan segera mencapai deadline.')
                    ->line('**Judul Tugas:** ' . $this->task->judul_tugas)
                    ->line('**Deadline:** ' . $deadlineFormatted . ' (Tinggal ' . $this->reminderType . ' lagi!)')
                    ->action('Lihat Tugas', route('tasks.show', $this->task))
                    ->line('Segera selesaikan tugasmu dan tetap semangat!');
    }
}