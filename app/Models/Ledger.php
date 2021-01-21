<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Customer;
use App\Models\Vendor;

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

            if($query->customer_id != NULL){
                $client = Customer::find($query->customer_id);
            }
            if($query->vendor_id != NULL){
                $client = Vendor::find($query->vendor_id);
            }

            // old
            if($old_type == 'credit'){
                // outstanding_balance
                $client->outstanding_balance -= $old_amount;
                // business_to_date for customer
                if($query->customer_id != NULL){
                    $client->business_to_date -= $old_amount;
                }
                $client->save();
            }
            if($old_type == 'debit'){
                // outstanding_balance
                $client->outstanding_balance -= $old_amount;
                // business_to_date for vendor
                if($query->vendor_id != NULL){
                    $client->business_to_date -= $old_amount;
                }
                $client->save();
            }

            // new
            if($new_type == 'credit'){
                // outstanding_balance
                $client->outstanding_balance += $new_amount;
                // business_to_date for customer
                if($query->customer_id != NULL){
                    $client->business_to_date += $new_amount;
                }
                $client->save();
            }
            if($new_type == 'debit'){
                // outstanding_balance
                $client->outstanding_balance -= $new_amount;
                // business_to_date for vendor
                if($query->vendor_id != NULL){
                    $client->business_to_date += $new_amount;
                }
                $client->save();
            }
        });

        static::deleting(function ($query) {
            if($query->customer_id != NULL){
                $client = Customer::find($query->customer_id);
            }
            if($query->vendor_id != NULL){
                $client = Vendor::find($query->vendor_id);
            }

            if($query->type == 'credit'){
                // outstanding_balance
                $client->outstanding_balance -= $query->amount;
                // business_to_date for customer
                if($query->customer_id != NULL){
                    $client->business_to_date -= $query->amount;
                }
                $client->save();
            }
            if($query->type == 'debit'){
                // outstanding_balance
                $client->outstanding_balance += $query->amount;
                // business_to_date for vendor
                if($query->vendor_id != NULL){
                    $client->business_to_date -= $query->amount;
                }
                $client->save();
            }
        });

        static::created(function ($query) {
            $check = 0;

            if($query->customer_id != NULL){
                $client = Customer::find($query->customer_id);
                $check = 1;
            }
            if($query->vendor_id != NULL){
                $client = Vendor::find($query->vendor_id);
                $check = 1;
            }

            if($check == 1){
                if($query->type == 'credit'){
                    // outstanding_balance
                    $client->outstanding_balance += $query->amount;
                    // business_to_date for customer
                    if($query->customer_id != NULL){
                        $client->business_to_date += $query->amount;
                    }
                    $client->save();
                }
                if($query->type == 'debit'){
                    // outstanding_balance
                    $client->outstanding_balance -= $query->amount;
                    // business_to_date for vendor
                    if($query->vendor_id != NULL){
                        $client->business_to_date += $query->amount;
                    }
                    $client->save();
                }
            }
        });
    }
    
    protected $fillable = [
        'customer_id', 'vendor_id', 'amount', 'type', 'created_by', 'modified_by', 'transaction_date'
    ];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function customer()
    {
        return $this->belongsTo('App\Models\Customer');
    }

    public function vendor()
    {
        return $this->belongsTo('App\Models\Vendor');
    }
}
