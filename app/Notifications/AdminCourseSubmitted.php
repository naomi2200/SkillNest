<?php

namespace App\Notifications;

use App\Models\Curso;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AdminCourseSubmitted extends Notification
{
    use Queueable;

    public function __construct(public Curso $curso)
    {
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'course_id' => $this->curso->id,
            'mentor_id' => $this->curso->mentor_id,
            'title' => $this->curso->title,
            'status' => 'pendiente',
        ];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Nuevo curso en revisión')
            ->line('Se envió un curso a revisión.')
            ->line('Título: ' . $this->curso->title)
            ->action('Revisar curso', url(route('admin.courses.show', $this->curso->id)));
    }
}
