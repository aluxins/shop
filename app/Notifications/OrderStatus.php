<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Lang;

class OrderStatus extends Notification implements ShouldQueue
{
    use Queueable;

    public array $order;

    /**
     * Create a new notification instance.
     */
    public function __construct(array $order)
    {
        $this->order = $order;
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
                    ->subject(Lang::get('Changing the order status'))
                    ->line(Lang::get('The order status has been changed: '). cache('siteSettings')['order_status'][$this->order['status']] .'.')
                    ->action(Lang::get('View the order'), url(route('order.id', ['id' => $this->order['id']])));
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
