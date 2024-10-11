<?php

namespace App\Http\Controllers;

use App\Events\TicketPurchased;
use App\Http\Requests\PurchaseTicketRequest;
use App\Jobs\PurchaseTicketJob;
use App\Models\Event;
use App\Models\Purchase;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class EventsController extends Controller
{
    public function list(): View
    {
        $events = Event::upcoming()->get();
        return view('list', ['events' => $events]);
    }

    public function show(Event $event): View
    {
        return view('show', ['event' => $event]);
    }

    public function purchase(PurchaseTicketRequest $request)
    {
        $user = User::byEmail($request['email'])->first();

        if (!$user) {
            $user = User::createFromEmail($request['email']);
        }

        $purchase = Purchase::create([
            'user_id' => $user->id,
            'event_id' => $request['event_id'],
            'qty' => $request['qty'],
        ]);
        PurchaseTicketJob::dispatch($purchase->id);
        event(new TicketPurchased($purchase->id));
        return redirect()->route('purchase.status', ['purchaseId' => $purchase->id]);
    }

    public function status(Request $request): View
    {
        $purchaseId = $request->query('purchaseId');
        $purchase = Purchase::with('tickets')->findOrFail($purchaseId);
        return view('status', ['purchase' => $purchase]);
    }
}
