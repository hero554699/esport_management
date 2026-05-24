<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class StoreMatchRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            'event_id' => ['nullable', 'exists:events,id'],
            'team_a_id' => ['required', 'exists:teams,id', 'different:team_b_id'],
            'team_b_id' => ['required', 'exists:teams,id'],
            'stage' => ['required', 'string', 'max:100'],
            'status' => ['required', 'in:scheduled,live,completed,cancelled'],
            'scheduled_at' => ['required', 'date'],
        ];
    }
}
