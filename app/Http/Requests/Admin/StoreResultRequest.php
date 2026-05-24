<?php

namespace App\Http\Requests\Admin;

use App\Models\Matches;
use App\Models\Player;
use Illuminate\Foundation\Http\FormRequest;

class StoreResultRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->role === 'admin';
    }

    public function rules(): array
    {
        return [
            'match_id' => ['required', 'exists:matches,id'],
            'winner_team_id' => ['required', 'exists:teams,id'],
            'score_a' => ['required', 'integer', 'min:0'],
            'score_b' => ['required', 'integer', 'min:0'],
            'mvp_player' => ['nullable', 'exists:players,id'],
            'notes' => ['nullable', 'string', 'max:500'],
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            $match = Matches::find($this->input('match_id'));
            if (!$match) {
                return;
            }

            if (!in_array((int) $this->input('winner_team_id'), [(int) $match->team_a_id, (int) $match->team_b_id], true)) {
                $validator->errors()->add('winner_team_id', 'Winner must be one of the match teams.');
            }

            if ($this->filled('mvp_player')) {
                $mvp = Player::find($this->input('mvp_player'));
                if (!$mvp || !in_array((int) $mvp->team_id, [(int) $match->team_a_id, (int) $match->team_b_id], true)) {
                    $validator->errors()->add('mvp_player', 'MVP must be from one of the match teams.');
                }
            }
        });
    }
}
