<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMatchRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            'team_a_id' => ['required', 'exists:teams,id', 'different:team_b_id'],
            'team_b_id' => ['required', 'exists:teams,id'],
            'stage' => ['required', 'string', 'max:100'],
            'scheduled_at' => ['required', 'date', 'after_or_equal:now'],
        ];
    }

    public function messages(): array
    {
        return [
            'scheduled_at.after_or_equal' => 'Match cannot be scheduled in the past. Please select a future date and time.',
            'team_a_id.different' => 'Team A and Team B must be different.',
        ];
    }
}
