<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderStatus extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var string
     */
    public string $orderStatus;

    /**
     * @var int
     */
    public int $order;

    /**
     * Create a new message instance.
     */
    public function __construct(string $orderStatus, int $order)
    {
        $this->orderStatus = $orderStatus;
        $this->order = $order;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Order Status',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.order-status-' . config('app.locale'),
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }

    /**
     * Создать сообщение.
     *
     * @return $this
     */
    public function build(): static
    {
        return $this->view('emails.order-status-' . config('app.locale'), [
                                                            'status' => $this->orderStatus,
                                                            'id' => $this->order,
                                                            'url' => route('order.id', ['id' => $this->order])
        ]);
    }
}
