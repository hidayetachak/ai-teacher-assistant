<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AssignmentRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->user()->role->name === 'teacher';
    }

    public function rules()
    {
        return [
            'topic' => ['required', 'string', 'max:255'],
            'grade_level' => ['required', 'in:K-2,3-5,6-8,9-12'],
            'num_questions' => ['required', 'integer', 'min:1', 'max:50'],
            'question_type' => ['required', 'in:MCQ,True/False,Short Answer'],
            'tags' => ['nullable', 'string'],
        ];
    }
}