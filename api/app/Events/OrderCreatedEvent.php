<?php

namespace App\Events;

use App\Models\Currency;
use App\Models\Order;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OrderCreatedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $order;
    public $currency;
    public $amount;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Order $order, Currency $currency, float $amount)
    {
        $this->order = $order;
        $this->currency = $currency;
        $this->amount = $amount;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }
}
