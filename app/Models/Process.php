<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Process
 * @package App\Models
 * @version March 3, 2021, 11:31 pm UTC
 *
 * @property \App\Models\User $user
 * @property \App\Models\User $responsible
 * @property \App\Models\Process $processTemplate
 * @property integer $user
 * @property integer $responsible
 * @property integer $process_template
 * @property string $comments
 * @property string $status
 * @property json $inputs
 * @property json $outputs
 * @property json $metadata
 * @property json $scheduled_date
 * @property json $executed_date
 */
class Process extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'processes';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'user',
        'responsible',
        'process_template',
        'comments',
        'status',
        'inputs',
        'outputs',
        'metadata',
        'scheduled_date',
        'executed_date'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'user' => 'integer',
        'responsible' => 'integer',
        'process_template' => 'integer',
        'comments' => 'string',
        'status' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'user' => 'required',
        'responsible' => 'required',
        'comments' => 'required',
        'status' => 'required',
        'inputs' => 'required'
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
    public function responsible_relation()
    {
        return $this->belongsTo(\App\Models\User::class, 'responsible', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function process_template_relation()
    {
        return $this->belongsTo(\App\Models\ProcessTemplate::class, 'process_template', 'id');
    }
}
