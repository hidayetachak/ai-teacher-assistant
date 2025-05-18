<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ResourceRequest extends FormRequest
{
    

    public function rules()
    {
        return [
            'topic' => ['required', 'string', 'max:255'],
            'grade_level' => 'nullable|string|max:50',
            'tags' => 'nullable|array',
        ];
    }
}