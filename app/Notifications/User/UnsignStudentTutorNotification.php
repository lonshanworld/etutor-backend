<?php

namespace App\Notifications\User;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UnsignStudentTutorNotification extends Notification
{
    use Queueable;

    protected $tutor;

    /**
     * Create a new notification instance.
     *
     * @param $tutor
     * @return void
     */
    public function __construct($tutor = null)
    {
        $this->tutor = $tutor;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        $tutorName = $this->tutor ? $this->tutor->name : 'your tutor';
        
        return [
            'message' => "You have been successfully unassigned from $tutorName.",
            'type' => 'unassignment',
            'tutor_id' => $this->tutor ? $this->tutor->id : null,
        ];
    }
}
