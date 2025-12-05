<?php

namespace App\Notifications;

use App\Models\Curso;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AdminCoursePublished extends Notification
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
            'title' => $this->curso->title,
            'status' => 'publicado',
            'message' => 'El mentor ha publicado el curso.',
        ];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Curso publicado')
            ->line('El curso "' . $this->curso->title . '" fue publicado por el mentor.')
            ->action('Ver curso', url(route('admin.courses.show', $this->curso->id)));
    }
}
