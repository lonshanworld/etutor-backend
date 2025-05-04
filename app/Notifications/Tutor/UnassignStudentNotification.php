<?php

namespace App\Notifications\Tutor;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UnassignStudentNotification extends Notification
{
    use Queueable;

    protected $student;
    protected $students;

    /**
     * Create a new notification instance.
     */
    public function __construct($student = null, $students = null)
    {
        $this->student = $student;
        $this->students = $students;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Student Unassignment Notification')
            ->greeting('Hello ' . $notifiable->first_name . '!')
            ->line('One or more students have been unassigned from you.')
            ->line('Please check your dashboard for updated student list.')
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
        if ($this->student) {
            return [
                'message' => "Student " . $this->student->full_name . " has been unassigned from you.",
                'type' => 'unassignment',
                'student_id' => $this->student->id ?? null,
            ];
        } else {
            // If multiple students
            $count = $this->students ? $this->students->count() : 0;
            return [
                'message' => $count . " student" . ($count > 1 ? "s have" : " has") . " been unassigned from you.",
                'type' => 'unassignment',
                'count' => $count,
            ];
        }
    }
}
