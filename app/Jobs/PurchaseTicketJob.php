<?php

namespace App\Jobs;

use App\Events\TicketPurchased;
use App\Models\Event;
use App\Models\Purchase;
use App\Models\Ticket;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class PurchaseTicketJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $purchaseId;

    public function __construct($purchaseId)
    {
        $this->purchaseId = $purchaseId;
    }

    public function handle()
    {
        try {
            $purchase = Purchase::findOrFail($this->purchaseId);

            DB::transaction(static function () use ($purchase) {
                $event = Event::findOrFail($purchase->event_id);

                if ($event->available_qty < $purchase->qty) {
                    throw new \RuntimeException('No hay suficientes tickets disponibles');
                }

                for ($i = 0; $i < $purchase->qty; $i++) {
                    Ticket::create([
                        'event_id' => $event->id,
                        'code' => random_int(1000, 9999),
                        'purchase_id' => $purchase->id,
                    ]);
                }

                $event->decrement('available_qty', $purchase->qty);
                $purchase->status = 1;
                $purchase->qr = QrCode::size(300)->generate(route('purchase.status', ['purchaseId' => $purchase->id]));
                $purchase->save();
            });
            event(new TicketPurchased($this->purchaseId, 'completed'));
        } catch (\Exception $exception) {
            event(new TicketPurchased($this->purchaseId, 'failed'));
            $purchase->status = 3;
            $purchase->save();
            DB::rollBack();
            Log::error($exception->getMessage());
        }

    }

}
