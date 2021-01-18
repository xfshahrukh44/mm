<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Ledger;

class Payment extends Model
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

            $old_amount = $query->getOriginal('amount');
            $new_amount = $query->amount;

            // old
            // ledger entry
            Ledger::create([
                'vendor_id' => $query->vendor_id,
                'amount' => $old_amount,
                'type' => 'debit'
            ]);

            // new
            // ledger entry
            Ledger::create([
                'vendor_id' => $query->vendor_id,
                'amount' => $new_amount,
                'type' => 'credit'
            ]);
        });

        static::deleting(function ($query) {
            // ledger entry
            Ledger::create([
                'vendor_id' => $query->vendor_id,
                'amount' => $query->amount,
                'type' => 'debit'
            ]);
        });

        static::created(function ($query) {
            // ledger entry
            Ledger::create([
                'vendor_id' => $query->vendor_id,
                'amount' => $query->amount,
                'type' => 'credit'
            ]);
        });
    }
    
    protected $fillable = [
        'vendor_id', 'amount', 'created_by', 'modified_by',
    ];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function vendor()
    {
        return $this->belongsTo('App\Models\Vendor');
    }
}
