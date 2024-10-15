<?php

namespace App\Http\Controllers\Admin;

use App\Events\TicketPurchased;
use App\Http\Controllers\Controller;
use App\Http\Requests\EventDeleteRequest;
use App\Http\Requests\EventStoreRequest;
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

    public function __construct()
    {
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

    public function create(): View
    {
        return view('events.show');
    }

    public function store(EventStoreRequest $request): RedirectResponse
    {
        $event = new Event();

        $event->fill($request->validated());
        $event->save();

        return Redirect::route('events.create', $event->id)->with('status', 'event-created');
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

    public function destroy(EventDeleteRequest $event): RedirectResponse
    {
        Event::destroy($event);
        return Redirect::back()->with('status', 'event-deleted');
    }

    public function show(Event $event): View
    {
        return view('show', ['event' => $event]);
    }

    public function purchases(Request $request): View
    {
        $query = Purchase::query();
        $events = Event::all();

        if ($request->filled('event_id')) {
            $query->whereHas('event', function ($q) use ($request) {
                $q->where('event_id', $request->get('event_id'));
            });
        }

        $purchases = $query->paginate(10);
        return view('purchases.list', ['purchases' => $purchases, 'events' => $events]);
    }
}
