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
 * @property \App\Models\Product $product
 * @property \App\Models\Sale $sale
 * @property \App\Models\Purchase $purchase
 * @property \App\Models\Process $process
 * @property integer $product
 * @property integer $sale
 * @property integer $purchase
 * @property integer $process
 * @property json $metadata
 */
class StockMovement extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'stock_movements';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'product',
        'sale',
        'purchase',
        'process',
        'ammount',
        'metadata'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'product' => 'integer',
        'sale' => 'integer',
        'purchase' => 'integer',
        'process' => 'integer',
        'ammount' => 'float'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'user' => 'required',
        'product' => 'required',
        'ammount' => 'required',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function product_relation()
    {
        return $this->belongsTo(\App\Models\Products::class, 'product', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function sale_relation()
    {
        return $this->belongsTo(\App\Models\Sale::class, 'sale', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function purchase_relation()
    {
        return $this->belongsTo(\App\Models\Purchase::class, 'purchase', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function process_relation()
    {
        return $this->belongsTo(\App\Models\Process::class, 'process', 'id');
    }
}
