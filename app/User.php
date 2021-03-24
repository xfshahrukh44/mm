<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'phone', 'type', 'registration_ip', 'created_by', 'modified_by',
        'can_dashboard',
        'can_client_database',
        'can_customers',
        'can_customer_schedule',
        'can_vendors',
        'can_areas_and_markets',
        'can_stock_management',
        'can_products',
        'can_stock_in',
        'can_stock_out',
        'can_special_discounts',
        'can_categories',
        'can_brands',
        'can_units',
        'can_accounting',
        'can_customer_ledgers',
        'can_vendor_ledgers',
        'can_sales_ledgers',
        'can_receipts',
        'can_receipt_logs',
        'can_payments',
        'can_expenses',
        'can_expense_ledgers',
        'can_order_management',
        'can_orders',
        'can_invoices',
        'can_marketing_plan',
        'can_marketing_tasks',
        'can_security_shell',
        'can_user_management',
        'can_staff',
        'can_riders',
        'can_add_customers',
        'can_edit_customers',
        'can_view_customers',
        'can_delete_customers',
        'can_excel_customers',
        'can_add_vendors',
        'can_edit_vendors',
        'can_view_vendors',
        'can_delete_vendors',
        'can_excel_vendors',
        'can_add_areas',
        'can_edit_areas',
        'can_delete_areas',
        'can_add_products',
        'can_edit_products',
        'can_view_products',
        'can_delete_products',
        'can_excel_products',
        'can_add_stock_ins',
        'can_edit_stock_ins',
        'can_delete_stock_ins',
        'can_add_stock_outs',
        'can_edit_stock_outs',
        'can_delete_stock_outs',
        'can_add_categories',
        'can_edit_categories',
        'can_delete_categories',
        'can_add_brands',
        'can_edit_brands',
        'can_delete_brands',
        'can_add_units',
        'can_edit_units',
        'can_delete_units',
        'can_add_receivings',
        'can_edit_receivings',
        'can_delete_receivings',
        'can_add_payments',
        'can_edit_payments',
        'can_delete_payments',
        'can_add_expenses',
        'can_edit_expenses',
        'can_delete_expenses',
        'can_add_orders',
        'can_edit_orders',
        'can_view_orders',
        'can_delete_orders',
        'can_excel_orders',
        'can_invoice_orders',
        'can_add_invoices',
        'can_edit_invoices',
        'can_view_invoices',
        'can_delete_invoices',
        'can_print_invoices',
        'can_add_users',
        'can_edit_users',
        'can_delete_users',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($query) {
            dd($query);
            $query->created_by = (auth()->user() ? auth()->user()->id : 1);
        });

        static::created(function ($query) {
            if($query->type == "superadmin"){
                set_superadmin_rights($query->id);
            }
            if($query->type == "user"){
                set_user_rights($query->id);
            }
            if($query->type == "rider"){
                set_basic_rights($query->id);
            }
        });

        static::updated(function ($query) {
            // if($query->type == "superadmin"){
            //     set_superadmin_rights($query->id);
            // }
            // if($query->type == "user"){
            //     set_user_rights($query->id);
            // }
            // if($query->type == "rider"){
            //     set_basic_rights($query->id);
            // }
        });

        static::updating(function ($query) {
            $query->modified_by = (auth()->user() ? auth()->user()->id : 1);
        });
    }

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function saveQuietly(array $options = [])
    {
        return static::withoutEvents(function () use ($options) {
            return $this->save($options);
        });
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function marketings()
    {
        return $this->hasMany('App\Models\Marketing');
    }
}
