<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Market extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'area_id',
        'name'
    ];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function area()
    {
        return $this->belongsTo('App\Models\Area');
    }

    public function customers()
    {
        return $this->hasMany('App\Models\Customer');
    }
}
