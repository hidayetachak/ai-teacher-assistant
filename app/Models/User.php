<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = ['name', 'email', 'password', 'role','school_id'];

    protected $hidden = [
        'password', 'remember_token',
    ];

   

    public function content()
    {
        return $this->hasMany(Content::class);
    }

    public function usage()
    {
        return $this->hasMany(Usage::class);
    }
    public function role()
    {
        return $this->belongsTo(Role::class);
    }


  

    public function school()
    {
        return $this->belongsTo(User::class, 'school_id');
    }
    
    public function teachers()
    {
        return $this->hasMany(User::class, 'school_id')->where('role', 'teacher');
    }



}