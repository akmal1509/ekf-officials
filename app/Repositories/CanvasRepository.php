<?php

namespace App\Repositories;

use App\Models\Canvas;

class CanvasRepository extends BaseRepository
{

    /**
     * Model class to be used in this repository for the common methods inside Eloquent
     * Don't remove or change $this->model variable name
     * @property Model|mixed $model;
     */
    protected $model;

    public function __construct(Canvas $model)
    {
        $this->model = $model;
    }

    public function real()
    {
        try {
            $result = $this->model->select('id', 'name', 'nik')->get();
            return $this->setResult($result)
                ->setCode(200)
                ->setStatus(true);
        } catch (\Exception $exception) {
            return $this->exceptionResponse($exception);
        }
    }

    // Write something awesome :)
}
