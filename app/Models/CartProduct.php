<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CartProduct extends Model
{
    use SoftDeletes;
    
    protected $fillable = ['cart_id', 'price', 'quantity'];
    
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function cart()
    {
        return $this->belongsTo('App\Models\Cart');
    }
}