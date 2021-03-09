<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Ledger;
use App\Models\Expense;

class Invoice extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'customer_id',
        'order_id',
        'rider_id',
        'total',
        'payment',
        'amount_pay',
        'previous_balance',
        'description',
        'date',
        'discount',
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

            $old_total = $query->getOriginal('total');
            $new_total = $query->total;
            $old_payment = $query->getOriginal('payment');
            $new_payment = $query->payment;
            $old_amount_pay = $query->getOriginal('amount_pay');
            $new_amount_pay = $query->amount_pay;
            $old_customer_id = $query->getOriginal('customer_id');
            $new_customer_id = $query->customer_id;
            $old_discount = $query->getOriginal('discount');
            $new_discount = $query->discount;

            $ledger = Ledger::where('customer_id', $query->customer_id)
                            ->where('invoice_id', $query->id)
                            ->where('amount', $old_total)
                            ->first();
            if($ledger && ($old_total != new_total)){ // experiment
                $temp_created_at = $ledger->created_at;
                $temp_transaction_date = $ledger->transaction_date;
                $ledger->delete();
            }
            // amount pay
            if($query->old_payment == 'cash'){
                $ledger = Ledger::where('customer_id', $query->customer_id)
                                ->where('invoice_id', $query->id)
                                ->where('amount', $old_amount_pay)
                                ->first();
                
                if($ledger){
                    $ledger->delete();
                }
            }
            // discount
            if($old_discount){
                $expense = Expense::where('customer_id', $old_customer_id)
                                ->where('amount', $old_amount_pay)
                                ->where('detail', 'customer discount')
                                ->first();
                if($expense){
                    $expense->delete();
                }
            }

            // new
            // invoice total in ledger
            if($old_total != new_total){ // experiment
                Ledger::create([
                    'customer_id' => $query->customer_id,
                    'invoice_id' => $query->id,
                    'amount' => $new_total,
                    'type' => 'debit',
                    'transaction_date' => $temp_transaction_date,
                    'created_at' => $temp_created_at
                ]);
            }
            // amount pay
            if($query->new_payment == 'cash'){
                Ledger::create([
                    'customer_id' => $query->customer_id,
                    'invoice_id' => $query->id,
                    'amount' => $new_amount_pay,
                    'type' => 'credit',
                    'transaction_date' => return_todays_date()
                ]);
            }
            // discount
            if($new_discount > 0){
                Expense::create([
                    'customer_id' => $new_customer_id,
                    'amount' => $new_amount_pay,
                    'detail' => 'customer discount',
                    'date' => return_todays_date()
                ]);
            }

        });

        static::deleting(function ($query) {
            $ledger = Ledger::where('customer_id', $query->customer_id)
                            ->where('invoice_id', $query->id)
                            ->where('amount', $query->total)
                            ->first();
            if($ledger){
                $ledger->delete();
            }
            
            // amount pay
            if($query->payment == 'cash'){
                $ledger = Ledger::where('customer_id', $query->customer_id)
                                ->where('invoice_id', $query->id)
                                ->where('amount', $query->amount_pay)
                                ->first();
                if($ledger){
                    $ledger->delete();
                }
            }

            // discount
            if($query->discount > 0){
                $expense = Expense::where('customer_id', $query->customer_id)
                                ->where('amount', $query->discount)
                                ->where('detail', 'customer discount')
                                ->first();
                if($expense){
                    $expense->delete();
                }
            }
        });

        static::created(function ($query) {
            // invoice total in ledger
            Ledger::create([
                'customer_id' => $query->customer_id,
                'invoice_id' => $query->id,
                'amount' => $query->total,
                'type' => 'debit',
                'transaction_date' => return_todays_date()
            ]);

            // amount pay
            if($query->payment == 'cash'){
                Ledger::create([
                    'customer_id' => $query->customer_id,
                    'invoice_id' => $query->id,
                    'amount' => $query->amount_pay,
                    'type' => 'credit',
                    'transaction_date' => return_todays_date()
                ]);
            }

            // discount
            if($query->discount > 0){
                Expense::create([
                    'customer_id' => $query->customer_id,
                    'amount' => $query->discount,
                    'detail' => 'customer discount',
                    'date' => return_todays_date()
                ]);
            }
        });
    }

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function saveQuietly(array $options = [])
    {
        return static::withoutEvents(function () use ($options) {
            return $this->save($options);
        });
    }

    public function customer()
    {
        return $this->belongsTo('App\Models\Customer');
    }

    public function invoice_products()
    {
        return $this->hasMany('App\Models\InvoiceProduct');
    }

    public function order()
    {
        return $this->belongsTo('App\Models\Order');
    }

    public function receivings()
    {
        return $this->hasMany('App\Models\Receiving');
    }

    public function ledgers()
    {
        return $this->hasMany('App\Models\Ledger');
    }

    public function marketings()
    {
        return $this->hasMany('App\Models\Marketing');
    }

}
