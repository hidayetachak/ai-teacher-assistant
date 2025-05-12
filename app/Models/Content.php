<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    protected $table = 'content';

    protected $fillable = [
        'user_id',
        'type',
        'topic',
        'grade_level',
        'num_questions',
        'question_type',
        'duration',
        'data',
        'tags',
    ];

    protected $casts = [
        'data' => 'array',
        'tags' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function usage()
    {
        return $this->hasMany(Usage::class);
    }
}