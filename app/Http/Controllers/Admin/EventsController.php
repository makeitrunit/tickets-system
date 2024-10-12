<?php

namespace App\Http\Controllers\Admin;

use App\Events\TicketPurchased;
use App\Http\Controllers\Controller;
use App\Http\Requests\EventUpdateRequest;
use App\Http\Requests\ProfileUpdateRequest;
use App\Http\Requests\PurchaseTicketRequest;
use App\Jobs\PurchaseTicketJob;
use App\Models\Event;
use App\Models\Purchase;
use App\Models\User;
use App\Services\PurchaseTicketService;
use App\Services\UserService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use SimpleSoftwareIO\QrCode\QrCodeServiceProvider;

class EventsController extends Controller
{
    private UserService $userService;
    private PurchaseTicketService $ticketService;

    public function __construct()
    {
        $this->userService = new UserService();
        $this->ticketService = new PurchaseTicketService();
    }

    public function index(Request $request): View
    {
        $query = Event::query();


        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->get('name') . '%');
        }

        if ($request->filled('qty')) {
            $query->where('qty', $request->get('qty'));
        }

        $events = $query->paginate(10);

        return view('events.list', compact('events'));
    }

    public function edit(Event $event): View
    {
        return view('events.edit', [
            'event' => $event,
        ]);
    }

    public function update(EventUpdateRequest $request, Event $event): RedirectResponse
    {
        $event->fill($request->validated());

        if ($event->isDirty()) {
            $event->save();
        }

        return Redirect::route('events.edit', $event->id)->with('status', 'event-updated');
    }

    public function show(Event $event): View
    {
        return view('show', ['event' => $event]);
    }

    public function purchase(PurchaseTicketRequest $request): RedirectResponse
    {
        $email = $request['email'];
        $user = $this->userService->getUserForPurchaseByEmail($email);
        if (!$user) {
            throw ValidationException::withMessages(['field_name' => 'No se pudo obtener el usuario para realizar la compra']);
        }

        $purchase = $this->ticketService->purchaseTicket($user, $request['event_id'], $request['qty']);
        if (!$purchase) {
            throw ValidationException::withMessages(['field_name' => 'No se pudo generar la compra']);
        }
        return redirect()->route('purchase.status', ['purchaseId' => $purchase->id]);
    }

    public function status(Request $request): View
    {
        $purchaseId = $request->query('purchaseId');
        $purchase = Purchase::with('tickets')->findOrFail($purchaseId);
        return view('status', ['purchase' => $purchase]);
    }
}
