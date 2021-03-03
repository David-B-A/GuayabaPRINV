<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class ProcessTemplate
 * @package App\Models
 * @version March 3, 2021, 7:50 pm UTC
 *
 * @property string $name
 * @property string $description
 * @property json $inputs
 * @property json $outputs
 * @property json $metadata
 */
class ProcessTemplate extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'process_templates';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'name',
        'description',
        'inputs',
        'outputs',
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
        'description' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required',
        'description' => 'required',
        'inputs' => 'required'
    ];

    
}
