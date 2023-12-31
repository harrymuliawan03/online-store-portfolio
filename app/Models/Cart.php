<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cart extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'products_id', 'users_id', 'store_id', 'qty'
    ];

    protected $hidden = [
        
    ];

    public function product()
    {
        return $this->hasOne(Product::class, 'id', 'products_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'users_id', 'id');
    }
    public function store()
    {
        return $this->belongsTo(User::class, 'store_id', 'id');
    }
}