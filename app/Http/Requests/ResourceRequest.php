<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;

class ResourceRequest extends FormRequest
{
 

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        Log::info('Applying validation rules for ResourceRequest', [
            'input_data' => $this->all(),
        ]);

        return [
            'topic' => ['required', 'string', 'max:255'],
            'grade_level' => 'nullable|string|max:50',
            'tags' => 'nullable|array',
        ];
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    protected function failedValidation(\Illuminate\Validation\Validator $validator)
    {
        Log::error('ResourceRequest validation failed', [
            'errors' => $validator->errors()->toArray(),
            'input_data' => $this->all(),
            'url' => $this->url(),
        ]);

        parent::failedValidation($validator);
    }

    /**
     * Handle a successful validation attempt.
     *
     * @return void
     */
    public function validated()
    {
        Log::info('ResourceRequest validation passed', [
            'validated_data' => $this->all(),
            'url' => $this->url(),
        ]);

        return parent::validated();
    }
}