<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EventUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'qty' => ['required', 'integer', 'min:1'],
            'available_qty' => ['required', 'integer', 'min:1', 'greater_or_equal:qty'],
            'status' => ['boolean'],
            'date_from' => ['required', 'date_format:Y-m-d\TH:i', 'after_or_equal:today'],
            'date_until' => ['required', 'date_format:Y-m-d\TH:i', 'after:date_from'],
        ];
    }
}
