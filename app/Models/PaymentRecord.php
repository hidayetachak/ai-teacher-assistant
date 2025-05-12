<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentRecord extends Model
{
    protected $table = 'payment_records';
    public $timestamps = true; 
    protected $fillable = [ 
        'user_id',  
        'package_id', 
        'amount',
        'original_amount',
        'discount_amount',
        'coupon_code',
        'email',
        'name',
        'payment_method',
        'stripe_payment_id',
        'advert_id',
        'package_duration',
        'credits'
    ];
    public function user()
    {
        return $this->belongsTo(User::class); 
    }    
    public function package()
    {
        return $this->belongsTo(Package::class); 
    }
}
