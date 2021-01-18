<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\StockOut;
use App\Models\StockIn;
use App\Models\Order;

class OrderProduct extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'price',
        'invoiced',
        'current_amount',
        'previous_amount',
        'final_amount',
        'payment',
        'amount',
        'balance_due',
        'dispatch_date',
        'created_by',
        'modified_by'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($query) {
            $query->created_by = auth()->user()->id;
        });

        static::updating(function ($query) {
            $query->modified_by = auth()->user()->id;

            // $order = Order::find($query->order_id);
            // $customer_id = $order->customer_id;
            // $old_quantity = $query->getOriginal('quantity');
            // $new_quantity = $query->quantity;

            // // old
            // StockIn::create([
            //     'product_id' => $query->product_id,
            //     'quantity' => $old_quantity,
            // ]);

            // // new
            // StockOut::create([
            //     'customer_id' => $customer_id,
            //     'product_id' => $query->product_id,
            //     'quantity' => $new_quantity,
            // ]);
        });

        static::deleting(function ($query) {
            // StockIn::create([
            //     'product_id' => $query->product_id,
            //     'quantity' => $query->quantity,
            // ]);
        });

        static::created(function ($query) {
            // $order = Order::find($query->order_id);
            // $customer_id = $order->customer_id;
            // StockOut::create([
            //     'customer_id' => $customer_id,
            //     'product_id' => $query->product_id,
            //     'quantity' => $query->quantity,
            // ]);
        });
    }

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function order()
    {
        return $this->belongsTo('App\Models\Order');
    }

    public function product()
    {
        return $this->belongsTo('App\Models\Product');
    }
}
