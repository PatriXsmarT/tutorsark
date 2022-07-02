<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ProfileCreatedSuccessfully extends Notification
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
        return ['mail'];
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
            ->subject('TutorsArk Profile Was Created Successfully!!')
            ->line('Your profile information has been stored, check it out.')
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
            'title' => 'TutorsArk Profile Created Successfully!!',
            'message' => 'Your profile information has been stored. view your profile to see it.',
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
        return 'profile.created';
    }
}
