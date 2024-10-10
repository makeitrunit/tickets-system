<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Eloquent\OptimisticLockException;
use Illuminate\Support\Facades\DB;

class Ticket extends Model
{
    protected $fillable = ['event_id', 'qty', 'version'];

    public function purchaseTickets(int $eventId, int $ticketQty)
    {
        // Iniciar una transacción
        return DB::transaction(function () use ($eventId, $ticketQty) {
            // Busca el evento correspondiente
            $event = Event::where('id', $eventId)
                ->where('available_qty', '>=', $ticketQty)
                ->first();

            if (!$event) {
                throw new ModelNotFoundException('Event not found or insufficient quantity.');
            }

            // Crear un nuevo ticket
            $ticket = new Ticket();
            $ticket->event_id = $eventId;
            $ticket->qty = $ticketQty;
            $ticket->version = 1; // Inicializa la versión

            // Intenta guardar el ticket
            if (!$ticket->save()) {
                throw new OptimisticLockException('Could not save the ticket due to version conflict.');
            }

            // Actualiza la cantidad disponible en el evento
            $event->available_qty -= $ticketQty; // Decrementa la cantidad disponible
            $event->version++; // Incrementa la versión
            if (!$event->save()) {
                throw new OptimisticLockException('Could not update the event due to version conflict.');
            }

            return $ticket; // Devuelve el ticket creado
        });
    }
}
