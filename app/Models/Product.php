<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\StockIn;
use App\Models\StockOut;
use App\Models\Product;

class Product extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'category_id',
        'brand_id',
        'unit_id',
        'article',
        'gender',
        'purchase_price',
        'consumer_selling_price',
        'retailer_selling_price',
        'opening_quantity',
        'moq',
        'quantity_in_hand',
        'product_picture',
        'cost_value',
        'sales_value',
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
            // $query->modified_by = auth()->user()->id;

            // // old and new fields
            // $old_opening_quantity = $query->getOriginal('opening_quantity');
            // $new_opening_quantity = $query->opening_quantity;

            // // finding stock_in entry
            // $stock_in = StockIn::where('product_id', $query->id)
            //                     ->where('quantity', $old_opening_quantity)
            //                     ->first();

            // // updating stock_in
            // $stock_in->update([
            //     'quantity' => $new_opening_quantity,
            // ]);
            // $stock_in->save();
        });

        static::created(function ($query) {
            // stock_in entry
            if($query->opening_quantity > 0){
                StockIn::create([
                    'product_id' => $query->id,
                    'quantity' => $query->opening_quantity,
                ]);
            }

            // cost and sales value
            $product = Product::find($query->id);
            $product->cost_value = $product->quantity_in_hand * $product->purchase_price;
            $product->sales_value = $product->quantity_in_hand * $product->consumer_selling_price;
            $product->save();
        });

        static::updated(function ($query) {
            // cost and sales value
            $product = Product::find($query->id);
            $product->cost_value = $product->quantity_in_hand * $product->purchase_price;
            $product->sales_value = $product->quantity_in_hand * $product->consumer_selling_price;
            $product->save();
        });
    }

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }

    public function brand()
    {
        return $this->belongsTo('App\Models\Brand');
    }

    public function unit()
    {
        return $this->belongsTo('App\Models\Unit');
    }

    public function order_products()
    {
        return $this->hasMany('App\Models\OrderProduct');
    }

    public function stock_ins()
    {
        return $this->hasMany('App\Models\StockIn');
    }

    public function stock_outs()
    {
        return $this->hasMany('App\Models\StockOut');
    }
}
