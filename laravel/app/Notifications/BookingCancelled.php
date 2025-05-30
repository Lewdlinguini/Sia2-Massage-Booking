<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class BookingCancelled extends Notification
{
    use Queueable;

    protected $booking;

    public function __construct($booking)
    {
        $this->booking = $booking;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Booking Cancelled')
                    ->line('Your booking for ' . $this->booking->service->name . ' has been cancelled.')
                    ->line('We hope to see you again!');
    }

    public function toDatabase($notifiable)
    {
        return [
            'booking_id' => $this->booking->id,
            'message' => 'Your booking for ' . $this->booking->service->name . ' was cancelled.',
        ];
    }
}