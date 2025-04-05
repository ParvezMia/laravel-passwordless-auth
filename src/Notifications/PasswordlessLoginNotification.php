<?php

namespace Jea\PasswordlessAuth\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PasswordlessLoginNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * The login token.
     *
     * @var string
     */
    protected $token;

    /**
     * Create a new notification instance.
     *
     * @param  string  $token
     * @return void
     */
    public function __construct($token)
    {
        $this->token = $token;
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
        $url = url(route('passwordless.verify', [
            'token' => $this->token,
        ]));

        // Use the markdown method for better email compatibility
        return (new MailMessage)
            ->subject('Your Login Link')
            ->markdown('passwordless-auth::emails.login-link', ['url' => $url]);
    }
}
