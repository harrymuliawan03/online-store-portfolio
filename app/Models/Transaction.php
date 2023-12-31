<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'users_id',
        'insurance_price',
        'shipping_price',
        'service_fee',
        'payment_status',
        'transaction_status',
        'awb',
        'total_price',
        'code',
        'code_checkout_all',
    ];

    protected $hidden = [
        
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id', 'id');
    }

}