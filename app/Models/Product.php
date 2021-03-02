<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Product
 * @package App\Models
 * @version March 2, 2021, 5:27 pm UTC
 *
 * @property string $name
 * @property string $type
 * @property number $input_price
 * @property number $sale_price
 * @property integer $stock
 * @property json $metadata
 */
class Product extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'products';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'name',
        'type',
        'input_price',
        'sale_price',
        'stock',
        'metadata'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'type' => 'string',
        'input_price' => 'float',
        'sale_price' => 'float',
        'stock' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required',
        'type' => 'required',
        'input_price' => 'required',
        'sale_price' => 'required',
        'stock' => 'required'
    ];

    
}
