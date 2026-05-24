<?php

namespace App\Http\Requests\User;

class UpdateMatchRequest extends StoreMatchRequest
{
    public function rules(): array
    {
        $rules = parent::rules();
        $rules['status'] = ['required', 'in:scheduled,live,completed,cancelled'];

        return $rules;
    }
}
