<?php

namespace App\Repositories;

use App\Models\Process;
use App\Repositories\BaseRepository;

/**
 * Class ProcessRepository
 * @package App\Repositories
 * @version March 3, 2021, 11:31 pm UTC
*/

class ProcessRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
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
        return Process::class;
    }
}
