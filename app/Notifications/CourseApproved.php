<?php

namespace App\Notifications;

use App\Models\Curso;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CourseApproved extends Notification
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
            'status' => 'aprobado',
            'message' => 'Tu curso fue aprobado. Ahora puedes publicarlo.',
        ];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Tu curso fue aprobado')
            ->line('El curso "' . $this->curso->title . '" fue aprobado por el administrador.')
            ->action('Ver curso', url(route('cursos.editor', $this->curso->id)));
    }
}
