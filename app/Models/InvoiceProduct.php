<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\StockOut;
use App\Models\StockIn;
use App\Models\Invoice;

class InvoiceProduct extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'invoice_id',
        'product_id',
        'quantity',
        'price',
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

        static::deleting(function ($query) {
            
        });

        static::created(function ($query) {
            $invoice = Invoice::find($query->invoice_id);
            $customer_id = $invoice->customer_id;
            StockOut::create([
                'customer_id' => $customer_id,
                'product_id' => $query->product_id,
                'quantity' => $query->quantity,
            ]);
        });
    }

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function invoice()
    {
        return $this->belongsTo('App\Models\Invoice');
    }

    public function product()
    {
        return $this->belongsTo('App\Models\Product');
    }
}
