<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\BaseRepository;

/**
 * Class UserRepository
 * @package App\Repositories
 * @version March 2, 2021, 5:27 pm UTC
*/

class UserRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'email',
        'address',
        'city',
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
        return User::class;
    }
}
