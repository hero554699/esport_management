<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreEventRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', Rule::unique('events', 'name')],
            'game_id' => ['required', 'exists:games,id'],
            'type' => ['required', 'in:local,national,international,world'],
            'prize_pool' => ['nullable', 'string', 'max:255'],
            'certification' => $this->getCertificationRules(),
            'is_certification_public' => ['nullable', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'certification.required' => 'Certification is required for ' . $this->input('type') . ' tournaments.',
            'certification.file' => 'Certification must be a file (PDF, image, etc).',
            'certification.max' => 'Certification file must not exceed 5MB.',
        ];
    }

    /**
     * Get certification validation rules based on tournament type
     */
    private function getCertificationRules(): array
    {
        $type = $this->input('type');

        // Local tournaments don't need certification
        if ($type === 'local') {
            return ['nullable', 'file'];
        }

        // National, International, World need certification
        return ['required', 'file', 'mimes:pdf,jpg,jpeg,png,gif,doc,docx', 'max:5120'];
    }
}
