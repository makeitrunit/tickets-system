<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Foundation\Events\Dispatchable;

class TicketPurchased
{
    use Dispatchable;
    public $purchaseId;

    public function __construct($purchaseId)
    {
        $this->purchaseId = $purchaseId;
    }

    public function broadcastOn()
    {
        return new Channel('ticket-purchase.' . $this->purchaseId);
    }
}
