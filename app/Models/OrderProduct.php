<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderProduct extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'current_amount',
        'previous_amount',
        'final_amount',
        'payment',
        'amount',
        'balance_due',
        'dispatch_date'
    ];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function order()
    {
        return $this->belongsTo('App\Models\Orders');
    }

    public function product()
    {
        return $this->belongsTo('App\Models\Product');
    }
}
