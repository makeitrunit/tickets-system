<?php

namespace App\Services;

use App\Events\TicketPurchased;
use App\Jobs\PurchaseTicketJob;
use App\Models\Purchase;

class PurchaseTicketService
{
    public function __construct()
    {
    }

    public function purchaseTicket($user, $eventId, $qty): ?Purchase
    {
        try {
            $purchase = Purchase::create([
                'user_id' => $user->id,
                'event_id' => $eventId,
                'qty' => $qty,
            ]);

            PurchaseTicketJob::dispatch($purchase->id);
            event(new TicketPurchased($purchase->id));
            return $purchase;
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
        }

        return null;
    }
}
