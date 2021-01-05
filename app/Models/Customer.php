<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Ledger;

class Customer extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'name',
        'market_id',
        'business_to_date',
        'outstanding_balance',
        'contact_number',
        'whatsapp_number',
        'type',
        'floor',
        'shop_name',
        'shop_number',
        'shop_picture',
        'shop_keeper_picture',
        'payment_terms',
        'cash_on_delivery',
        'visiting_days',
        'status',
        'opening_balance',
        'special_discount',
        'created_by',
        'modified_by'
    ];
    
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($query) {
            $query->created_by = auth()->user()->id;
            $query->outstanding_balance = 0;
        });

        static::updating(function ($query) {
            // $query->modified_by = auth()->user()->id;

            // // old and new fields
            // $old_opening_balance = $query->getOriginal('opening_balance');
            // $new_opening_balance = $query->opening_balance;
            // // adjusting new balance
            // if($new_opening_balance > 0){
            //     $type = 'credit';
            // }
            // if($new_opening_balance < 0){
            //     $type = 'debit';
            //     $new_opening_balance *= -1;
            // }
            // dd($query);

            // // finding ledger entry
            // $ledger = Ledger::where('customer_id', $query->id)
            //         ->where('amount', $old_opening_balance)
            //         ->where('type', $type)
            //         ->first();

            // // updating ledger
            // $ledger->update([
            //     'amount' => $new_opening_balance,
            //     'type' => $type
            // ]);
            // $ledger->save();
        });

        static::created(function ($query) {
            if($query->opening_balance != NULL){
                if($query->opening_balance > 0){
                    $type = 'debit';
                }
                if($query->opening_balance < 0){
                    $type = 'credit';
                    $query['opening_balance'] *= -1;
                }
                Ledger::create([
                    'customer_id' => $query->id,
                    'amount' => $query->opening_balance,
                    'type' => $type
                ]);
            }
        });   
    }

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function market()
    {
        return $this->belongsTo('App\Models\Market');
    }

    public function orders()
    {
        return $this->hasMany('App\Models\Order');
    }

    public function ledgers()
    {
        return $this->hasMany('App\Models\Ledger');
    }

    public function stock_outs()
    {
        return $this->hasMany('App\Models\StockOut');
    }
}
