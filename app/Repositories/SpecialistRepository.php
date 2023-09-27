<?php

namespace App\Repositories;

use App\Models\Specialist;

class SpecialistRepository extends BaseRepository{

    /**
    * Model class to be used in this repository for the common methods inside Eloquent
    * Don't remove or change $this->model variable name
    * @property Model|mixed $model;
    */
    protected $model;

    public function __construct(Specialist $model)
    {
        $this->model = $model;
    }

    // Write something awesome :)
}
