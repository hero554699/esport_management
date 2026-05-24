<?php

namespace App\Http\Requests\User;

use App\Models\Team;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateEventRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        $event = $this->route('event');

        return [
            'name' => ['required', 'string', 'max:255', Rule::unique('events', 'name')->ignore($event?->id)],
            'game_id' => ['required', 'exists:games,id'],
            'team_a_id' => ['required', 'exists:teams,id', 'different:team_b_id'],
            'team_b_id' => ['required', 'exists:teams,id'],
            'start_date' => ['required', 'date', 'after_or_equal:today'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
            'prize_pool' => ['nullable', 'string'],
            'type' => ['required', 'in:local,national,international,world'],
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            $teamIds = array_filter([$this->input('team_a_id'), $this->input('team_b_id')]);
            if (empty($teamIds)) {
                return;
            }

            $ownedCount = Team::whereIn('id', $teamIds)
                ->where('user_id', $this->user()->id)
                ->count();

            if ($ownedCount !== count($teamIds)) {
                $validator->errors()->add('team_a_id', 'You can only select your own teams.');
            }
        });
    }
}
