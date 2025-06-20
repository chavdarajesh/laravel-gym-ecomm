<?php

namespace App\Mail\Order;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderStatusUpdatedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $latestStatus;

    public function __construct(Order $order)
    {
        $this->order = $order;
        $this->latestStatus =  $order->latestStatus()->first();
    }

    public function build()
    {
        return $this->subject(ucfirst($this->latestStatus->name) . ' | Order Status Updated - #' . $this->order->id . ' | ' . env('APP_NAME', 'Laravel App'))
                    ->view('emails.orders.order_status_update');
    }
}
