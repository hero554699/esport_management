<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTeamRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('teams', 'name')->where(fn ($query) => $query->where('user_id', $this->user()->id)),
            ],
            'game_id' => ['nullable', 'exists:games,id'],
            'tag' => ['nullable', 'string', 'max:10'],
            'country' => ['nullable', 'string', 'max:60'],
            'logo_url' => ['nullable', 'url', 'max:500'],
            'logo_file' => ['nullable', 'image', 'max:2048'],
        ];
    }
}
