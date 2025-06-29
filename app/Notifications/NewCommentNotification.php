<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Comment;

class NewCommentNotification extends Notification
{
    use Queueable;

    public $comment; // Properti untuk menyimpan data komentar

    /**
     * Create a new notification instance.
     */
    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via(object $notifiable): array
    {
        // Kita akan menyimpan notifikasi di database
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray(object $notifiable): array
    {
        // Ini adalah data yang akan disimpan dalam format JSON di database
        return [
            'comment_id' => $this->comment->id,
            'commenter_name' => $this->comment->user->name,
            'post_id' => $this->comment->post->id,
            'post_title' => $this->comment->post->title,
            'url' => route('forum.posts.show', $this->comment->post->id) . '#comment-' . $this->comment->id,
        ];
    }
}
