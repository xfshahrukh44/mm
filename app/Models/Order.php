<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'customer_id',
        'total',
        'status'
    ];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function customer()
    {
        return $this->belongsTo('App\Models\Customer');
    }

    public function order_products()
    {
        return $this->hasMany('App\Models\OrderProduct');
    }
}
