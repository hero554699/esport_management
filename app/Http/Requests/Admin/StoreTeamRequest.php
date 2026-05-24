<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreTeamRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->role === 'admin';
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'tag' => ['nullable', 'string', 'max:10'],
            'game_id' => ['nullable', 'exists:games,id'],
            'organization_id' => ['nullable', 'exists:organizations,id'],
            'country' => ['nullable', 'string', 'max:60'],
            'logo_url' => ['nullable', 'url'],
        ];
    }
}
