<?php

namespace App\Notifications;

use App\Models\Reminder;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DueReminderNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $reminder;

    /**
     * Create a new notification instance.
     */
    public function __construct(Reminder $reminder)
    {
        $this->reminder = $reminder;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Reminder: Upcoming Event')
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line('This is a reminder that you have an upcoming event.')
            ->line('Event Title: ' . $this->reminder->title)
            ->line('Event Date: ' . $this->reminder->event_at->format('Y-m-d H:i:s'))
            ->line('Event Description: ' . $this->reminder->description)
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
            //
        ];
    }
}
