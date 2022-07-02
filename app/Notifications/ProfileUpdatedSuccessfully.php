<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\BroadcastMessage;

class ProfileUpdatedSuccessfully extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [
            'mail',
            'broadcast',
            'database'
        ];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('TutorsArk Profile Was Updated Recently!!')
            ->line('Your profile was recently updated, check it out.')
            ->action('View Profile', config('app.url').'/@'.$notifiable->username)
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
        return [
            'title' => 'TutorsArk Profile Was Updated Recently!!',
            'message' => 'Your profile information was updated recently. view your profile to see changes made.',
            'actions' => [
                [
                    'title' => 'View Profile',
                    'url' => config('app.url').'/@'.$notifiable->username
                ]
            ],
            'icon_url' => config('app.url').'/icon.png',
            'created_at'=> now()
        ];
    }

    /**
     * Get the type of the notification being broadcast.
     *
     * @return string
     */
    public function broadcastType()
    {
        return 'profile.updated';
    }
}
