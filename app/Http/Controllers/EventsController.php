<?php

namespace App\Http\Controllers;

use App\Events\TicketPurchased;
use App\Http\Requests\PurchaseTicketRequest;
use App\Jobs\PurchaseTicketJob;
use App\Models\Event;
use App\Models\Purchase;
use App\Models\User;
use App\Services\PurchaseTicketService;
use App\Services\UserService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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

    public function list(): View
    {
        $events = Event::upcoming()->get();
        return view('list', ['events' => $events]);
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
