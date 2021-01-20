<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Product;
use App\Models\StockIn;

class StockIn extends Model
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

            // find product
            $product = Product::find($query->product_id);

            $old_quantity = $query->getOriginal('quantity');
            $new_quantity = $query->quantity;
            $old_amount = $query->getOriginal('amount');
            $new_amount = $query->amount;
            $old_rate = $query->getOriginal('rate');
            $new_rate = $query->rate;

            // old
            // update product quantity in hand
            $product->quantity_in_hand -= $old_quantity;

            // update vendor ledger
            Ledger::create([
                'vendor_id' => $query->vendor_id,
                'customer_id' => 0,
                'amount' => $old_amount,
                'type' => 'credit'
            ]);
            // new
            // update product quantity in hand
            $product->quantity_in_hand += $new_quantity;

            // update vendor ledger
            Ledger::create([
                'vendor_id' => $query->vendor_id,
                'customer_id' => 0,
                'amount' => $new_amount,
                'type' => 'debit'
            ]);


            // update product purchase price
            $stockIns = StockIn::where('product_id', $query->product_id)->get();
            $purchase_price = 0;
            foreach($stockIns as $stockIn){
                $purchase_price += intval($stockIn->rate ? $stockIn->rate : 0);
            }
            $purchase_price -= $query->old_rate;
            $purchase_price += $query->new_rate;
            $purchase_price = $purchase_price / (count($stockIns) != 0 ? count($stockIns) : 1);
            $product->purchase_price = $purchase_price;

            $product->save();
        });

        static::deleting(function ($query) {
            // find product
            $product = Product::find($query->product_id);

            // update product purchase price
            $stockIns = StockIn::where('product_id', $query->product_id)->get();
            $purchase_price = 0;
            foreach($stockIns as $stockIn){
                $purchase_price += intval($stockIn->rate ? $stockIn->rate : 0);
            }
            $purchase_price -= $query->rate;
            $purchase_price = $purchase_price / (count($stockIns) - 1);
            $product->purchase_price = $purchase_price;

            // update product quantity in hand
            $product->quantity_in_hand -= $query->quantity;
            $product->save();

            // update vendor ledger
            Ledger::create([
                'vendor_id' => $query->vendor_id,
                'customer_id' => 0,
                'amount' => $query->amount,
                'type' => 'credit'
            ]);
        });

        static::created(function ($query) {
            // find product
            $product = Product::find($query->product_id);

            // update product purchase price
            $stockIns = StockIn::where('product_id', $query->product_id)->get();
            $purchase_price = 0;
            foreach($stockIns as $stockIn){
                $purchase_price += intval($stockIn->rate ? $stockIn->rate : "0");
            }
            $purchase_price = $purchase_price / count($stockIns);
            $product->purchase_price = $purchase_price;

            // update product quantity in hand
            $product->quantity_in_hand += $query->quantity;
            $product->save();

            // update vendor ledger
            Ledger::create([
                'vendor_id' => $query->vendor_id,
                'customer_id' => 0,
                'amount' => $query->amount,
                'type' => 'debit'
            ]);
        });
    }
    
    protected $fillable = [
        'vendor_id', 'product_id', 'quantity', 'rate', 'amount', 'transaction_date', 'created_by', 'modified_by'
    ];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function product()
    {
        return $this->belongsTo('App\Models\Product');
    }

    public function vendor()
    {
        return $this->belongsTo('App\Models\Vendor');
    }
}
