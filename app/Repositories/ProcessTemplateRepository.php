<?php

namespace App\Repositories;

use App\Models\ProcessTemplate;
use App\Repositories\BaseRepository;

/**
 * Class ProcessTemplateRepository
 * @package App\Repositories
 * @version March 3, 2021, 7:50 pm UTC
*/

class ProcessTemplateRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'description',
        'inputs',
        'outputs',
        'metadata'
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
        return ProcessTemplate::class;
    }
}
