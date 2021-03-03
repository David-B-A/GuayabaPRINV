<?php

namespace App\Repositories;

use App\Models\Purchase;
use App\Repositories\BaseRepository;

/**
 * Class PurchaseRepository
 * @package App\Repositories
 * @version March 2, 2021, 8:03 pm UTC
*/

class PurchaseRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id',
        'user',
        'supplier',
        'products',
        'total',
        'cash',
        'credit',
        'status',
        'payment_status',
        'created_at',
        'updated_at'
    ];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Purchase::class;
    }
}
