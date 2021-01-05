<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Customer;

class Ledger extends Model
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

            $old_type = $query->getOriginal('type');
            $new_type = $query->type;
            $old_amount = $query->getOriginal('amount');
            $new_amount = $query->amount;
            $customer = Customer::find($query->customer_id);

            // old
            if($old_type == 'credit'){
                $customer->outstanding_balance -= old_amount;
                $customer->save();
            }
            if($old_type == 'debit'){
                $customer->outstanding_balance -= $old_amount;
                $customer->save();
            }

            // new
            if($new_type == 'credit'){
                $customer->outstanding_balance += $new_amount;
                $customer->save();
            }
            if($new_type == 'debit'){
                $customer->outstanding_balance -= $new_amount;
                $customer->save();
            }
        });

        static::deleting(function ($query) {
            $customer = Customer::find($query->customer_id);

            if($query->type == 'credit'){
                $customer->outstanding_balance -= $query->amount;
                $customer->save();
            }
            if($query->type == 'debit'){
                $customer->outstanding_balance += $query->amount;
                $customer->save();
            }
        });

        static::created(function ($query) {
            $customer = Customer::find($query->customer_id);
            if($query->type == 'credit'){
                $customer->outstanding_balance += $query->amount;
                $customer->save();
            }
            if($query->type == 'debit'){
                $customer->outstanding_balance -= $query->amount;
                $customer->save();
            }
        });
    }
    
    protected $fillable = [
        'customer_id', 'amount', 'type', 'created_by', 'modified_by', 'transaction_date'
    ];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function customer()
    {
        return $this->belongsTo('App\Models\Customer');
    }
}
