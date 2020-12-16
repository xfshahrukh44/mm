<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'name',
        'market_id',
        'business_to_date',
        'outstanding_balance',
        'contact_number',
        'whatsapp_number',
        'floor',
        'shop_name',
        'shop_number',
        'shop_picture',
        'shop_keeper_picture',
        'payment_terms',
        'cash_on_delivery',
        'visiting_days',
        'status',
        'opening_balance',
        'special_discount',
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
    }

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function market()
    {
        return $this->belongsTo('App\Models\Market');
    }

    public function orders()
    {
        return $this->hasMany('App\Models\Order');
    }
}
