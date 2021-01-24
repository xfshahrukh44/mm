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

            // find product
            $product = Product::find($query->product_id);
            
            $old_quantity = $query->getOriginal('quantity');
            $new_quantity = $query->quantity;

            // old            
            // update product quantity in hand
            $product->quantity_in_hand += $old_quantity;
            // cost and sales value
            $product->cost_value = $product->quantity_in_hand * $product->purchase_price;
            $product->sales_value = $product->quantity_in_hand * $product->consumer_selling_price;
            
            // new            
            // update product quantity in hand
            $product->quantity_in_hand -= $new_quantity;
            // cost and sales value
            $product->cost_value = $product->quantity_in_hand * $product->purchase_price;
            $product->sales_value = $product->quantity_in_hand * $product->consumer_selling_price;

            $product->save();
        });

        static::deleting(function ($query) {
            // find product
            $product = Product::find($query->product_id);
            
            // update product quantity in hand
            $product->quantity_in_hand += $query->quantity;

            // cost and sales value
            $product->cost_value = $product->quantity_in_hand * $product->purchase_price;
            $product->sales_value = $product->quantity_in_hand * $product->consumer_selling_price;
            
            $product->save();
        });

        static::created(function ($query) {
            // find product
            $product = Product::find($query->product_id);

            // update product quantity in hand
            $product->quantity_in_hand -= $query->quantity;

            // cost and sales value
            $product->cost_value = $product->quantity_in_hand * $product->purchase_price;
            $product->sales_value = $product->quantity_in_hand * $product->consumer_selling_price;
            
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
