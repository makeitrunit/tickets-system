<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Event;

class PurchaseTicketRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'event_id' => 'required|exists:events,id',
            'email' => 'required|email',
            'qty' => 'required|integer|min:1',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'email' => trim($this->email),
        ]);
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            $eventId = $this->input('event_id');
            $qty = $this->input('qty');

            $event = Event::find($eventId);
            if ($event && $event->available_qty < $qty) {
                $validator->errors()->add('qty', 'La cantidad solicitada supera la cantidad disponible.');
            }
        });
    }
}
