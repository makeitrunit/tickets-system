<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Foundation\Events\Dispatchable;

class TicketPurchased
{
    use Dispatchable;
    public $purchaseId;

    public $purchaseStatus;

    public function __construct($purchaseId, $purchaseStatus = 'processing')
    {
        $this->purchaseId = $purchaseId;
        $this->purchaseStatus = $purchaseStatus;
    }

    public function broadcastOn()
    {
        return new Channel('ticket-purchase.' . $this->purchaseId . '.' . $this->purchaseStatus);
    }
}
