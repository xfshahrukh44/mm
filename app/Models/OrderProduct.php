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
        'is_available',
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
        });

        static::deleting(function ($query) {
            
        });

        static::created(function ($query) {
            
        });
    }

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function saveQuietly(array $options = [])
    {
        return static::withoutEvents(function () use ($options) {
            return $this->save($options);
        });
    }

    public function order()
    {
        return $this->belongsTo('App\Models\Order');
    }

    public function product()
    {
        return $this->belongsTo('App\Models\Product');
    }
}
