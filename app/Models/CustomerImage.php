<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomerImage extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'customer_id',
        'location',
        'created_by',
        'modified_by'
    ];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

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
            // 
        });   
    }

    public function customer()
    {
        return $this->belongsTo('App\Models\Customer');
    }
}
