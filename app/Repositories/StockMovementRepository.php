<?php

namespace App\Repositories;

use App\Models\StockMovement;
use App\Repositories\BaseRepository;

/**
 * Class StockMovementRepository
 * @package App\Repositories
 * @version March 3, 2021, 3:50 pm UTC
*/

class StockMovementRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id',
        'product',
        'sale',
        'purchase',
        'process',
        'ammount',
        'metadata',
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
        return StockMovement::class;
    }
}
