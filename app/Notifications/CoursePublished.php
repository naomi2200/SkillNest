<?php

namespace App\Notifications;

use App\Models\Curso;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CoursePublished extends Notification
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
            'status' => 'publicado',
            'message' => 'El curso ha sido publicado.',
            'url' => route('admin.courses.show', $this->curso->id),
        ];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Curso publicado')
            ->line('El mentor publicó el curso "' . $this->curso->title . '".')
            ->action('Ver curso', route('admin.courses.show', $this->curso->id));
    }
}
