<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Sale
 * @package App\Models
 * @version March 3, 2021, 3:50 pm UTC
 *
 * @property \App\Models\User $user
 * @property \App\Models\User $customer
 * @property integer $user
 * @property integer $customer
 * @property json $products
 * @property number $total
 * @property number $cash
 * @property number $credit
 * @property string $status
 * @property string $payment_status
 */
class Sale extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'sales';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'user',
        'customer',
        'products',
        'total',
        'cash',
        'credit',
        'status',
        'payment_status'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'user' => 'integer',
        'customer' => 'integer',
        'total' => 'float',
        'cash' => 'float',
        'credit' => 'float',
        'status' => 'string',
        'payment_status' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'customer' => 'required',
        'products' => 'required',
        'total' => 'required',
        'cash' => 'required',
        'credit' => 'required',
        'status' => 'required',
        'payment_status' => 'required'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function user_relation()
    {
        return $this->belongsTo(\App\Models\User::class, 'user', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function customer_relation()
    {
        return $this->belongsTo(\App\Models\User::class, 'customer', 'id');
    }
}
