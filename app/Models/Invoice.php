<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Ledger;

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

            // $old_total = $query->getOriginal('total');
            // $new_total = $query->total;
            // $old_payment = $query->getOriginal('payment');
            // $new_payment = $query->payment;
            // $old_amount_pay = $query->getOriginal('amount_pay');
            // $new_amount_pay = $query->amount_pay;

            // // old
            // // invoice total in ledger
            // Ledger::create([
            //     'customer_id' => $query->customer_id,
            //     'amount' => $old_total,
            //     'type' => 'debit'
            // ]);
            // if($old_payment == 'cash'){
            //     Ledger::create([
            //         'customer_id' => $query->customer_id,
            //         'amount' => $old_amount_pay,
            //         'type' => 'credit'
            //     ]);
            // }

            // // new
            // Ledger::create([
            //     'customer_id' => $query->customer_id,
            //     'amount' => $new_total,
            //     'type' => 'credit'
            // ]);
            // if($new_payment == 'cash'){
            //     Ledger::create([
            //         'customer_id' => $query->customer_id,
            //         'amount' => $new_amount_pay,
            //         'type' => 'debit'
            //     ]);
            // }
        });

        static::deleting(function ($query) {
            // invoice total in ledger
            // Ledger::create([
            //     'customer_id' => $query->customer_id,
            //     'amount' => $query->total,
            //     'type' => 'debit'
            // ]);
            // if($query->payment == 'cash'){
            //     Ledger::create([
            //         'customer_id' => $query->customer_id,
            //         'amount' => $query->amount_pay,
            //         'type' => 'credit'
            //     ]);
            // }
        });

        static::created(function ($query) {
            // invoice total in ledger
            Ledger::create([
                'customer_id' => $query->customer_id,
                'amount' => $query->total,
                'type' => 'credit'
            ]);

            if($query->payment == 'cash'){
                Ledger::create([
                    'customer_id' => $query->customer_id,
                    'amount' => $query->amount_pay,
                    'type' => 'debit'
                ]);
            }
        });
    }

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

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
}
