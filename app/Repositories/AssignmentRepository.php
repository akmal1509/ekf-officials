<?php

namespace App\Repositories;

use App\Models\Assignment;
use App\Models\DapilCategory;
use App\Models\DapilDistrict;
use App\Models\User;

class AssignmentRepository extends BaseRepository
{

    /**
     * Model class to be used in this repository for the common methods inside Eloquent
     * Don't remove or change $this->model variable name
     * @property Model|mixed $model;
     */
    protected $model;

    public function __construct(Assignment $model)
    {
        $this->model = $model;
        $this->option['with'] = [
            'users:id,name',
            'dapils',
            'districts:id,name',
        ];
    }

    public function district($id)
    {
        try {
            $result1 = DapilDistrict::with(['goWil:id,dapilDistrictId,districtId', 'goWil.districts:id,name'])->where('id', $id)->first()->toArray();
            $result2 = $result1;
            $result = collect($result1['go_wil'])->map(function ($item) {
                return [
                    'id' => $item['districts']['id'],
                    'name' => $item['districts']['name']
                ];
            });
            return $this
                ->setResult($result)
                // ->setResult($result2)
                ->setCode(200)
                ->setStatus(true);
        } catch (\Exception $exception) {
            return $this->exceptionResponse($exception);
        }
    }

    public function dapil()
    {
        try {
            $result = DapilDistrict::with(['cities'])->get()->map(function ($item) {
                return [
                    'id' => $item->id,
                    'name' => $item->dapil_name
                ];
            });
            return $this
                ->setResult($result)
                ->setCode(200)
                ->setStatus(true);
        } catch (\Exception $exception) {
            return $this->exceptionResponse($exception);
        }
    }
    public function users()
    {
        try {
            $result = User::select('id', 'name')->get();
            return $this
                ->setResult($result)
                ->setCode(200)
                ->setStatus(true);
        } catch (\Exception $exception) {
            return $this->exceptionResponse($exception);
        }
    }

    // Write something awesome :)
}
