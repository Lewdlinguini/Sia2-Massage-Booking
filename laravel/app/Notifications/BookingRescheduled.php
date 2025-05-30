<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Carbon\Carbon;

class BookingRescheduled extends Notification
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
                    ->subject('Booking Rescheduled')
                    ->line('Your booking for ' . $this->booking->service->name . ' has been rescheduled.')
                    ->line('New Date: ' . Carbon::parse($this->booking->booking_date)->format('M d, Y'))
                    ->line('Thank you for using our service!');
    }

    public function toDatabase($notifiable)
    {
        return [
            'booking_id' => $this->booking->id,
            'message' => 'Your booking for ' . $this->booking->service->name . ' has been rescheduled to ' . Carbon::parse($this->booking->booking_date)->format('M d, Y'),
        ];
    }
}
