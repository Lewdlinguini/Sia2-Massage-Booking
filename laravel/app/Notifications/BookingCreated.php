<?php

namespace App\Notifications;

use App\Notifications\BookingCreated;
use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class BookingCreated extends Notification
{
    use Queueable;

    public $booking;

    public function __construct(Booking $booking)
    {
        $this->booking = $booking;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'message' => 'A new booking has been made for your service: ' . $this->booking->service->title,
            'booking_id' => $this->booking->id,
        ];
    }
}