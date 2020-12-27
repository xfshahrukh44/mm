<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\StockIn;

class Product extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'category_id',
        'brand_id',
        'unit_id',
        'article',
        'purchase_price',
        'selling_price',
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
            $query->modified_by = auth()->user()->id;
        });

        static::created(function ($query) {
            if($query->opening_quantity > 0){
                StockIn::create([
                    'product_id' => $query->id,
                    'quantity' => $query->opening_quantity,
                ]);
            }
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
