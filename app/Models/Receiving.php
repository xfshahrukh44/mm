<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Ledger;
use App\Models\Invoice;

class Receiving extends Model
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

            // fetch invoice
            $invoice = Invoice::find($query->invoice_id);

            // old
            // update invoice
            $invoice->amount_pay -= $old_amount;

            // ledger entry
            // Ledger::create([
            //     'customer_id' => $invoice->customer_id,
            //     'amount' => $old_amount,
            //     'type' => 'debit',
            //     'transaction_date' => return_todays_date()
            // ]);
            $ledger = Ledger::where('customer_id', $invoice->customer_id)
                            ->where('receiving_id', $query->id)
                            ->where('amount', $old_amount)
                            ->first();
            $ledger->delete();

            // new
            // update invoice
            $invoice->amount_pay += $new_amount;

            // ledger entry
            Ledger::create([
                'customer_id' => $invoice->customer_id,
                'receiving_id' => $query->id,
                'amount' => $new_amount,
                'type' => 'credit',
                'transaction_date' => return_todays_date()
            ]);

            $invoice->save();
        });

        static::deleting(function ($query) {
            // update invoice
            $invoice = Invoice::find($query->invoice_id);
            $invoice->amount_pay -= $query->amount;
            $invoice->save();

            // ledger entry
            // Ledger::create([
            //     'customer_id' => $invoice->customer_id,
            //     'amount' => $query->amount,
            //     'type' => 'debit',
            //     'transaction_date' => return_todays_date()
            // ]);
            $ledger = Ledger::where('customer_id', $invoice->customer_id)
                            ->where('receiving_id', $query->id)
                            ->where('amount', $query->amount)
                            ->first();
            $ledger->delete();
        });

        static::created(function ($query) {
            // update invoice
            $invoice = Invoice::find($query->invoice_id);
            $invoice->amount_pay += $query->amount;
            $invoice->save();

            // ledger entry
            Ledger::create([
                'customer_id' => $invoice->customer_id,
                'receiving_id' => $query->id,
                'amount' => $query->amount,
                'type' => 'credit',
                'transaction_date' => return_todays_date()
            ]);
        });
    }
    
    protected $fillable = [
        'invoice_id', 'amount', 'created_by', 'modified_by',
    ];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function invoice()
    {
        return $this->belongsTo('App\Models\Invoice');
    }

    public function ledgers()
    {
        return $this->hasMany('App\Models\Ledger');
    }
}
