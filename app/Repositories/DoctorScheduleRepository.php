<?php

namespace App\Repositories;

use App\Models\DoctorSchedule;

class DoctorScheduleRepository extends BaseRepository
{

    /**
     * Model class to be used in this repository for the common methods inside Eloquent
     * Don't remove or change $this->model variable name
     * @property Model|mixed $model;
     */
    protected $model;

    public function __construct(DoctorSchedule $model)
    {
        $this->model = $model;
    }

    public function create($data)
    {
        try {
            $result = $data->all();
            $checkTime = $this->model
                ->where('date', $data->date)
                // ->where('startTime', '>=',$date->startTime)
                // ->where('endTime','<', $date->startTime)
                ->whereBetWeen('startTime', [$data->startTime, $data->endTime])
                ->orWhereBetWeen('endTime', [$data->startTime, $data->endTime])
                ->count();

            if ($checkTime > 0) {
                return $this->setStatus(false)
                    ->setMessage('Data already exist')
                    ->setCode(400);
            }
            if ($data->startTime >= $data->endTime) {
                return $this->setStatus(false)
                    ->setMessage('Start Time must smaller then End Time')
                    ->setCode(400);
            }
            $this->model->create($result);

            return $this
                ->setCode(200)
                ->setStatus(true)
                ->setResult($data);
        } catch (\Exception $exception) {
            return $this->exceptionResponse($exception);
        }
    }

    // Write something awesome :)
}
