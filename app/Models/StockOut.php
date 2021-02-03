<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Product;
use App\Models\Expense;

class StockOut extends Model
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
            $old_expense_type = $query->getOriginal('expense_type');
            $new_expense_type = $query->expense_type;

            // old            
            // update product quantity in hand
            $product->quantity_in_hand += $old_quantity;
            // cost and sales value
            $product->cost_value = $product->quantity_in_hand * $product->purchase_price;
            $product->sales_value = $product->quantity_in_hand * $product->consumer_selling_price;
            // adjustment expense entry
            if($old_expense_type != NULL){
                $expense = Expense::where('stock_out_id', $query->id)->where('type', $old_expense_type)->first();
                if($expense){
                    $expense->delete();
                }
            }
            
            // new            
            // update product quantity in hand
            $product->quantity_in_hand -= $new_quantity;
            // cost and sales value
            $product->cost_value = $product->quantity_in_hand * $product->purchase_price;
            $product->sales_value = $product->quantity_in_hand * $product->consumer_selling_price;

            $product->save();

            // adjustment expense entry
            if($new_expense_type != NULL){
                Expense::create([
                    'stock_out_id' => $query->id,
                    'type' => $new_expense_type,
                    'amount' => $product->purchase_price,
                    'detail' => $query->narration,
                    'date' => return_todays_date()
                ]);
            }
        });

        static::deleting(function ($query) {
            // find product
            $product = Product::find($query->product_id);
            
            // update product quantity in hand
            $product->quantity_in_hand += $query->quantity;

            // cost and sales value
            $product->cost_value = $product->quantity_in_hand * $product->purchase_price;
            $product->sales_value = $product->quantity_in_hand * $product->consumer_selling_price;
            
            $product->save();

            // adjustment expense entry
            if($query->expense_type != NULL){
                $expense = Expense::where('stock_out_id', $query->id)->where('type', $query->expense_type)->first();
                if($expense){
                    $expense->delete();
                }
            }
        });

        static::created(function ($query) {
            // find product
            $product = Product::find($query->product_id);

            // update product quantity in hand
            $product->quantity_in_hand -= $query->quantity;

            // cost and sales value
            $product->cost_value = $product->quantity_in_hand * $product->purchase_price;
            $product->sales_value = $product->quantity_in_hand * $product->consumer_selling_price;
            
            $product->save();

            // adjustment expense entry
            if($query->expense_type != NULL){
                Expense::create([
                    'stock_out_id' => $query->id,
                    'type' => $query->expense_type,
                    'amount' => $product->purchase_price,
                    'detail' => $query->narration,
                    'date' => return_todays_date()
                ]);
            }
        });
    }
    
    protected $fillable = [
        'customer_id', 'product_id', 'quantity', 'price', 'transaction_date', 'expense_type', 'narration', 'created_by', 'modified_by'
    ];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function customer()
    {
        return $this->belongsTo('App\Models\Customer');
    }

    public function product()
    {
        return $this->belongsTo('App\Models\Product');
    }
}
