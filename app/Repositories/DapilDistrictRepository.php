<?php

namespace App\Repositories;

use App\Models\DapilCategory;
use App\Models\DapilDistrict;
use App\Models\DapilDistrictGo;
use Illuminate\Support\Facades\DB;
use Laravolt\Indonesia\Models\City;
use Laravolt\Indonesia\Models\District;
use Laravolt\Indonesia\Models\Province;

class DapilDistrictRepository extends BaseRepository
{

    /**
     * Model class to be used in this repository for the common methods inside Eloquent
     * Don't remove or change $this->model variable name
     * @property Model|mixed $model;
     */
    protected $model;

    public function __construct(DapilDistrict $model)
    {
        $this->model = $model;
        $this->option['with'] = [
            'dapils:id,name',
            'provinces:id,name',
            'cities:id,name',
            'goWil:id,dapilDistrictId,districtId',
            'goWil.districts:id,name'
        ];
    }

    public function category()
    {
        try {
            $result = DapilCategory::select('id', 'name')->get();
            return $this
                ->setResult($result)
                ->setCode(200)
                ->setStatus(true);
        } catch (\Exception $exception) {
            return $this->exceptionResponse($exception);
        }
    }
    public function province()
    {
        try {
            $result = Province::select('id', 'name')->get();
            return $this
                ->setResult($result)
                ->setCode(200)
                ->setStatus(true);
        } catch (\Exception $exception) {
            return $this->exceptionResponse($exception);
        }
    }
    public function city($id)
    {
        try {
            $result = DB::table('indonesia_provinces')
                ->where('indonesia_provinces.id', $id)
                ->rightjoin('indonesia_cities', 'indonesia_provinces.code', '=', 'indonesia_cities.province_code')
                ->select('indonesia_cities.id', 'indonesia_cities.name')
                ->get();
            return $this
                ->setResult($result)
                ->setCode(200)
                ->setStatus(true);
        } catch (\Exception $exception) {
            return $this->exceptionResponse($exception);
        }
    }
    public function district($id)
    {
        try {
            // $result = District::select('id', 'name')->get();
            $result = DB::table('indonesia_cities')
                ->where('indonesia_cities.id', $id)
                ->rightjoin('indonesia_districts', 'indonesia_cities.code', '=', 'indonesia_districts.city_code')
                ->select('indonesia_districts.id', 'indonesia_districts.name')
                ->get();
            return $this
                ->setResult($result)
                ->setCode(200)
                ->setStatus(true);
        } catch (\Exception $exception) {
            return $this->exceptionResponse($exception);
        }
    }

    public function create($data)
    {
        try {
            $result = $data->all();
            $result['userId'] = auth()->user()->id;
            try {
                DB::beginTransaction();
                $created = $this->model->create($result);
                $go = $result['go_wil'];
                $elemen = explode(",", $go);
                $total = count($elemen);
                for ($i = 0; $i < $total; $i++) {
                    DapilDistrictGo::create([
                        'dapilDistrictId' => $created->id,
                        'districtId' => $elemen[$i]
                    ]);
                }


                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                return $this->exceptionResponse($e);
            }
            return $this
                ->setCode(200)
                ->setStatus(true)
                ->setResult($data);
        } catch (\Exception $exception) {
            return $this->exceptionResponse($exception);
        }
    }

    public function update($id, $data)
    {
        try {
            $source = $this->model->findOrFail($id);
            $result = $data->all();
            try {
                DB::beginTransaction();
                $source->update($result);
                $go = $result['go_wil'];
                $elemen = explode(",", $go);
                $total = count($elemen);
                DapilDistrictGo::where('dapilDistrictId', $id)->delete();
                for ($i = 0; $i < $total; $i++) {
                    DapilDistrictGo::create([
                        'dapilDistrictId' => $id,
                        'districtId' => $elemen[$i]
                    ]);
                }


                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                return $this->exceptionResponse($e);
            }


            return $this
                ->setCode(200)
                ->setStatus(true)
                ->setResult($source);
        } catch (\Exception $exception) {
            return $this->exceptionResponse($exception);
        }
    }

    // public function DistrictGo()
    // {
    //     try {
    //         $result = District::select('id', 'name')->get();
    //         return $this
    //             ->setResult($result)
    //             ->setCode(200)
    //             ->setStatus(true);
    //     } catch (\Exception $exception) {
    //         return $this->exceptionResponse($exception);
    //     }
    // }

    // Write something awesome :)
}
