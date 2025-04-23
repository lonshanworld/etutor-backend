<?php

namespace App\Notifications\User;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class InactiveUserNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct()
    {
        //
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
        // Get a friendly name to use in the greeting, with fallback to email if first_name is missing
        $name = $notifiable->first_name ?? explode('@', $notifiable->email)[0] ?? 'User';
        
        return (new MailMessage)
            ->subject('We Miss You!')
            ->greeting('Hello ' . $name . '!')
            ->line('We noticed you haven\'t logged into our platform for 28 days.')
            ->line('We miss you and hope to see you back soon.')
            ->action('Log In Now', url('/login'))
            ->line('If you have any questions or need assistance, please don\'t hesitate to contact us.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'We Miss You!',
            'message' => 'You haven\'t logged in for 28 days. We hope to see you back soon!',
            'action_url' => '/login'
        ];
    }
}
