<?php

namespace App\Http\Requests;

use App\Models\Event;
use App\Models\Purchase;
use App\Rules\ExistsEventPurchase;
use Illuminate\Foundation\Http\FormRequest;

class EventDeleteRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {

        $event = $this->event;

        if (!$event || !is_numeric($event)) {
            $this->failValidation();
        }

        $doesntExist = Event::where(['id'=>$event])->doesntExist();

        if ($doesntExist) {
            $this->failValidation('El evento no existe.');
        }

        return [];
    }

    protected function failValidation($message = 'El evento es inválido')
    {
        // Puedes personalizar el mensaje de error
        $validator = $this->getValidatorInstance();
        $validator->errors()->add('event', $message);

        throw new \Illuminate\Validation\ValidationException($validator);
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            $exists = Purchase::where(['event_id' => $this->event])->exists();

            if ($exists) {
                $validator->errors()->add('evento', "Ya existe una compra asociada a este evento.");
            }

        });
    }

}
