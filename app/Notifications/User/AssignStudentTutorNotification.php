<?php

namespace App\Notifications\User;

use App\Mail\Allocation\AllocateSuccessMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AssignStudentTutorNotification extends Notification
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
        // Create MailMessage instance instead of directly returning AllocateSuccessMail
        return (new MailMessage)
            ->subject('Tutor Assignment Notification')
            ->greeting('Hello ' . $this->student->first_name . '!')
            ->line('You have been successfully assigned to tutor ' . $this->tutor->first_name . '.')
            ->line('Please check your dashboard for more details.')
            ->action('View Dashboard', url('/dashboard'))
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'message' => "You have been successfully assigned to $this->tutor->first_name ",
            'type' => 'assigned',
            'student_id' => $this->student ? $this->student->id : null,
        ];
    }
}
