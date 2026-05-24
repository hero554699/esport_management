<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateEventRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->role === 'admin';
    }

    public function rules(): array
    {
        $event = $this->route('event');

        return [
            'name' => ['required', 'string', 'max:255', Rule::unique('events', 'name')->ignore($event?->id)],
            'game_id' => ['required', 'exists:games,id'],
            'status' => ['required', 'in:upcoming,live,completed'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
            'prize_pool' => ['nullable', 'string'],
            'banner_url' => ['nullable', 'url'],
            'type' => ['nullable', 'in:local,national,international,world'],
        ];
    }
}
