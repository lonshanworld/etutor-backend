<?php

namespace App\Notifications\Tutor;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AssignStudentNotification extends Notification
{
    use Queueable;

    protected $student;
    protected $tutor;

    /**
     * Create a new notification instance.
     */
    public function __construct($student, $tutor)
    {
        $this->student = $student;
        $this->tutor = $tutor;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('New Student Assignment Notification')
            ->greeting('Hello ' . $this->tutor->first_name . '!')
            ->line('You have been assigned a new student: ' . $this->student->full_name . '.')
            ->line('Please check your dashboard for more details about your new student.')
            ->action('View Dashboard', url('/dashboard'))
            ->line('Thank you for your dedication to teaching!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'message' => "You have a new student assigned: " . $this->student->full_name,
            'type' => 'new_student',
            'student_id' => $this->student ? $this->student->id : null,
        ];
    }
}
