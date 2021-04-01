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
            $ledger = Ledger::where('vendor_id', $query->vendor_id)
                            ->where('amount', $query->amount)
                            ->where('type', 'credit')
                            ->first();
            if($ledger){
                $ledger->delete();
            }

            // new
            // update product purchase price
            // if(!(($product->cost_value - $old_amount + $new_amount) == 0 && ($product->quantity_in_hand - $old_quantity + $new_quantity) == 0)){
            //     $product->purchase_price = ($product->cost_value - $old_amount + $new_amount) / ($product->quantity_in_hand - $old_quantity + $new_quantity);
            // }
            $product->purchase_price = $new_rate;
            // update product quantity in hand
            $product->quantity_in_hand += $new_quantity;

            // cost and sales value
            $product->cost_value = $product->quantity_in_hand * $product->purchase_price;
            $product->sales_value = $product->quantity_in_hand * $product->consumer_selling_price;

            // update vendor ledger
            Ledger::create([
                'vendor_id' => $query->vendor_id,
                'amount' => $new_amount,
                'type' => 'credit',
                'transaction_date' => return_todays_date()
            ]);

            $product->saveQuietly();
        });

        static::deleting(function ($query) {
            // find product
            $product = Product::find($query->product_id);

            // update product purchase price
            // if(!(($product->cost_value - $query->amount) == 0 && ($product->quantity_in_hand - $query->quantity) == 0)){
            //     $product->purchase_price = ($product->cost_value - $query->amount) / ($product->quantity_in_hand - $query->quantity);
            // }
            $stock_in = StockIn::orderBy('created_at', 'desc')->skip(1)->take(1)->first();
            $product->purchase_price = $stock_in->rate;

            // update product quantity in hand
            $product->quantity_in_hand -= $query->quantity;

            // cost and sales value
            $product->cost_value = $product->quantity_in_hand * $product->purchase_price;
            $product->sales_value = $product->quantity_in_hand * $product->consumer_selling_price;
            $product->saveQuietly();

            // update vendor ledger
            $ledger = Ledger::where('vendor_id', $query->vendor_id)
                            ->where('amount', $query->amount)
                            ->where('type', 'credit')
                            ->first();
            // dd($ledger);
            if($ledger){
                $ledger->delete();
            }
        });

        static::created(function ($query) {
            // find product
            $product = Product::find($query->product_id);

            // update product purchase price
            // if(!(($product->cost_value + $query->amount) == 0 && ($product->quantity_in_hand + $query->quantity) == 0)){
            //     $product->purchase_price = ($product->cost_value + $query->amount) / ($product->quantity_in_hand + $query->quantity);
            // }
            $product->purchase_price = $query->rate;

            // update product quantity in hand
            $product->quantity_in_hand += $query->quantity;

            // cost and sales value
            $product->cost_value = $product->quantity_in_hand * $product->purchase_price;
            $product->sales_value = $product->quantity_in_hand * $product->consumer_selling_price;
            $product->save();

            // update vendor ledger
            Ledger::create([
                'vendor_id' => (($query->vendor_id) ? ($query->vendor_id) : NULL),
                'amount' => $query->amount,
                'type' => 'credit',
                'transaction_date' => return_todays_date()
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
