<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReminderCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string',
            'description' => 'required|string',
            'remind_at' => 'required|numeric|lte:event_at',
            'event_at' => 'required|numeric',
        ];
    }

    public function passedValidation(): void
    {
        $this->merge([
            'remind_at' => date('Y-m-d H:i:s', $this->remind_at),
            'event_at' => date('Y-m-d H:i:s', $this->event_at),
        ]);
    }

    public function messages()
    {
        return [
            'remind_at.lte' => 'Remind at must be less than or equal to event at',
        ];
    }
}
