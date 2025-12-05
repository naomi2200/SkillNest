<?php

namespace App\Notifications;

use App\Models\Curso;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CourseRejected extends Notification
{
    use Queueable;

    public function __construct(public Curso $curso, public string $reason)
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
            'status' => 'rechazado',
            'reason' => $this->reason,
            'message' => 'Tu curso fue rechazado. Revisa el motivo.',
        ];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Tu curso fue rechazado')
            ->line('El curso "' . $this->curso->title . '" fue rechazado.')
            ->line('Motivo: ' . $this->reason)
            ->action('Editar curso', url(route('cursos.editor', $this->curso->id)));
    }
}
