<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Payment;
use App\Models\Ledger;

class Expense extends Model
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
            $old_customer_id = $query->getOriginal('customer_id');
            $new_customer_id = $query->customer_id;

            // old
            // find payment and delete
            $payment = Payment::where('expense_id', $query->id)->where('amount', $old_amount)->first();
            if($payment){
                $payment->delete();
            }
            // find ledger and delete
            $ledger = Ledger::where('expense_id', $query->id)
                            ->where('customer_id', $old_customer_id)
                            ->where('type', 'credit')
                            ->where('amount', $old_amount)
                            ->first();
            if($ledger){
                $ledger->delete();
            }

            // new
            // payment entry
            Payment::create([
                'expense_id' => $query->id,
                'amount' => $new_amount
            ]);
            // if bad debt or cus discount
            if($new_customer_id){
                Ledger::create([
                    'expense_id' => $query->id,
                    'customer_id' => $new_customer_id,
                    'type' => 'credit',
                    'amount' => $new_amount
                ]);
            }
        });

        static::deleting(function ($query) {
            // find payment and delete
            $payment = Payment::where('expense_id', $query->id)->where('amount', $query->amount)->first();
            if($payment){
                $payment->delete();
            }

            // find ledger and delete
            $ledger = Ledger::where('expense_id', $query->id)
                            ->where('customer_id', $query->customer_id)
                            ->where('type', 'credit')
                            ->where('amount', $query->amount)
                            ->first();
            if($ledger){
                $ledger->delete();
            }
        });

        static::created(function ($query) {
            // payment entry
            Payment::create([
                'expense_id' => $query->id,
                'amount' => $query->amount
            ]);

            // if bad debt or cus discount
            if($query->customer_id){
                Ledger::create([
                    'expense_id' => $query->id,
                    'customer_id' => $query->customer_id,
                    'type' => 'credit',
                    'amount' => $query->amount
                ]);
            }
        });
    }

    protected $fillable = [
        'detail', 'type', 'amount', 'date', 'stock_out_id', 'customer_id', 'created_by', 'modified_by'
    ];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function payment()
    {
        return $this->hasOne('App\Models\Payment');
    }

    public function ledger()
    {
        return $this->hasOne('App\Models\Ledger');
    }

    public function customer()
    {
        return $this->belongsTo('App\Models\Customer');
    }
}
