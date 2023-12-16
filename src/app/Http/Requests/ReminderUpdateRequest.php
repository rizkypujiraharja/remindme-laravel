<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReminderUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function rules(): array
    {
        return [
            'title' => 'nullable|string',
            'description' => 'nullable|string',
            'remind_at' => 'nullable|numeric|lte:event_at',
            'event_at' => 'nullable|numeric',
        ];
    }

    public function passedValidation(): void
    {
        $this->merge([
            'remind_at' => date('Y-m-d H:i:s', $this->remind_at),
            'event_at' => date('Y-m-d H:i:s', $this->event_at),
        ]);
    }
}
