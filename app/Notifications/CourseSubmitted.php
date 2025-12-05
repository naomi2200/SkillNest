<?php

namespace App\Notifications;

use App\Models\Curso;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CourseSubmitted extends Notification
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
            'message' => 'Nuevo curso enviado a revisión.',
            'url' => route('admin.courses.show', $this->curso->id),
        ];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Nuevo curso en revisión')
            ->line('El mentor envió el curso "' . $this->curso->title . '" a revisión.')
            ->action('Revisar curso', route('admin.courses.show', $this->curso->id));
    }
}
