<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LessonPlanRequest extends FormRequest
{
    

    public function rules()
    {
        return [
            'topic' => ['required', 'string', 'max:255'],
            'grade_level' => ['required', 'in:K-2,3-5,6-8,9-12'],
            'duration' => ['required', 'integer', 'min:1'],
            'tags' => ['nullable', 'string'],
        ];
    }
}