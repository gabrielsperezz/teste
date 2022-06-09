<?php

namespace App\Http\Requests;

use App\Utils\Enums\AccountEventType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EventRequest extends FormRequest
{
    public function getEventType()
    {
        return $this->get('type');
    }

    public function getAmount()
    {
        return $this->get('amount');
    }

    public function getDestination()
    {
        return $this->get('destination');
    }

    public function getOrigin()
    {
        return $this->get('origin');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'type' => ['required', Rule::in([AccountEventType::DEPOSIT, AccountEventType::TRANSFER, AccountEventType::WITHDRAW])],
        ];
    }
}
