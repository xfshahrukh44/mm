<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Product;

class StockOut extends Model
{
    use SoftDeletes;
    
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($query) {
            $query->created_by = auth()->user()->id;
        });

        static::updating(function ($query) {
            $query->modified_by = auth()->user()->id;
        });

        static::created(function ($query) {
            $product = Product::find($query->product_id);
            $product->quantity_in_hand -= $query->quantity;
            $product->save();
        });
    }
    
    protected $fillable = [
        'customer_id', 'product_id', 'quantity', 'transaction_date', 'created_by', 'modified_by'
    ];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function customer()
    {
        return $this->belongsTo('App\Models\Customer');
    }

    public function product()
    {
        return $this->belongsTo('App\Models\Product');
    }
}
