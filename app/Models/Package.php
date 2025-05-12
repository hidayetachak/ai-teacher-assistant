<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    protected $table = 'packages';
    protected $fillable = [
        'title',
        'description',
        'price',
        'is_active', 
        'duration',
        'features',
        'is_featured',
        'recovery_payment',
        'credits'
    ];

}