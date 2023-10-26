<?php

namespace App\Repositories;

use App\Models\Schools;
use App\Models\StepOne;
use App\Models\Assignment;
use App\Models\DapilDistrict;
use App\Models\IndonesiaCity;
use App\Models\IndonesiaVillage;
use App\Models\IndonesiaDistrict;
use Illuminate\Support\Facades\DB;
use Laravolt\Indonesia\Models\Village;
use Laravolt\Indonesia\Models\District;

class StepOneRepository extends BaseRepository
{


    /**
     * Model class to be used in this repository for the common methods inside Eloquent
     * Don't remove or change $this->model variable name
     * @property Model|mixed $model;
     */
    protected $model;
    protected $with;
    private $table;

    public function __construct(StepOne $model)
    {
        $this->model = $model;
        $this->option['with'] = [
            'schools:id,name',
            'villages:id,district_code,name',
            'villages.district:id,name,code,city_code',
            'villages.district.city:id,name,code',
            'users:id,name'
        ];
        $this->table = 'step_ones';
    }

    public function count()
    {
        try {
            $guest = auth()->user();
            if ($guest->admin == 0) {
                $data =  $this->model->where('userId', $guest->id)->count();
                $result = [
                    'total' => $data,
                ];
            } else {
                $kuningan = \Indonesia::findCity('168', ['villages'])->villages->pluck('id')->toArray();
                $ciamis = \Indonesia::findCity('167', ['villages'])->villages->pluck('id')->toArray();
                $pangandaran = \Indonesia::findCity('178', ['villages'])->villages->pluck('id');
                $banjar = \Indonesia::findCity('187', ['villages'])->villages->pluck('id')->toArray();
                $countKuningan = $this->model->whereIn('villageId', $kuningan)->count();
                $countCiamis = $this->model->whereIn('villageId', $ciamis)->count();
                $countPangandaran = $this->model->whereIn('villageId', $pangandaran)->count();
                $countBanjar = $this->model->whereIn('villageId', $banjar)->count();
                $total = $this->model->count();
                $result = [
                    'countKuningan' => $countKuningan,
                    'countCiamis' => $countCiamis,
                    'countPangandaran' => $countPangandaran,
                    'countBanjar' => $countBanjar,
                    'total' => $total
                ];
            }
            return $this->setResult($result)
                ->setCode(200)
                ->setStatus(true);
        } catch (\Exception $exception) {
            return $this->exceptionResponse($exception);
        };
    }

    public function pemetaan($data)
    {
        try {
            $type = $data->type ?? '1';
            if ($type == '2') {
                $kuningan = \Indonesia::findCity('168', ['villages'])->villages->pluck('id')->toArray();
                $ciamis = \Indonesia::findCity('167', ['villages'])->villages->pluck('id')->toArray();
                $pangandaran = \Indonesia::findCity('178', ['villages'])->villages->pluck('id');
                $banjar = \Indonesia::findCity('187', ['villages'])->villages->pluck('id')->toArray();

                $filterData = DB::table('indonesia_cities')
                    ->join('indonesia_districts', 'indonesia_cities.code', '=', 'indonesia_districts.city_code')
                    ->join('indonesia_villages', 'indonesia_districts.code', '=', 'indonesia_villages.district_code')
                    ->leftJoin('step_ones', 'indonesia_villages.id', '=', 'step_ones.villageId')
                    ->whereIn('indonesia_cities.id', ['168', '167', '178', '187'])
                    ->groupBy('indonesia_cities.id')
                    ->select(
                        'indonesia_cities.id',
                        'indonesia_cities.name',
                        DB::raw('(COUNT(step_ones.id)) as step_one_count'),
                        DB::raw('SUM(CASE WHEN step_ones.verify = true THEN 1 ELSE 0 END) as verif_step_one_count')
                    )
                    ->get();
                $total = $filterData->sum('step_one_count');
                return
                    $this->setResult([
                        'total' => $total,
                        'data' => $filterData
                    ])
                    // $this->setResult($result)
                    ->setCode(200)
                    ->setStatus(true);
            }
            if ($type == '1') {
                $filterData = DapilDistrict::select(['id', DB::raw('CONCAT("Dapil ", dapilCategoryId, " ", (SELECT name FROM indonesia_cities WHERE indonesia_cities.id = dapil_districts.cityId)) as name')])->get();
                $filterData = DB::table('dapil_districts as a')
                    ->join('dapil_district_gos as b', 'b.dapilDistrictId', '=', 'a.id')
                    ->join('indonesia_cities', 'a.cityId', '=', 'indonesia_cities.id')
                    ->join('indonesia_districts as c', 'c.id', '=', 'b.districtId')
                    ->join('indonesia_villages', 'c.code', '=', 'indonesia_villages.district_code')
                    ->leftJoin('step_ones', 'indonesia_villages.id', '=', 'step_ones.villageId')
                    ->where('indonesia_cities.id', $data->filterId)
                    ->where('b.deleted_at', null)
                    ->groupBy('a.id', 'a.dapilCategoryId')
                    // ->distinct()

                    ->select(
                        'a.id',
                        DB::raw('CONCAT("Dapil ", dapilCategoryId) as name'),
                        DB::raw('COUNT(DISTINCT step_ones.id) as step_one_count'),
                        DB::raw('SUM(CASE WHEN step_ones.verify = true THEN 1 ELSE 0 END) as verif_step_one_count')
                    )
                    ->get();
                // $filterData = DapilDistrict::with('test')->find($data->filterId)->test->pluck('id')->toArray();
                // $dataReal = IndonesiaDistrict::whereIn('id', $filterData)
                //     ->select([])
                //     // ->select(['id', 'step_one_count'])
                //     // ->with('stepOne')
                //     ->withCount(['stepOne', 'verifStepOne'])
                //     ->addSelect(['id', 'code', 'name',])
                //     ->get();
                // $total = $dataReal->sum('step_one_count');
                $total = $filterData->sum('step_one_count');
                return
                    $this->setResult([
                        'total' => $total,
                        'data' => $filterData
                    ])
                    // $this->setResult($filterData)
                    ->setCode(200)
                    ->setStatus(true);
            }

            if ($type == '4') {
                $filterData = \Indonesia::findDistrict($data->filterId, ['villages'])->villages->pluck('id')->toArray();
                $dataReal = IndonesiaVillage::whereIn('id', $filterData)
                    ->select([])
                    // ->select(['id', 'step_one_count'])
                    // ->with('stepOne')
                    ->withCount(['stepOne', 'verifStepOne'])
                    ->addSelect(['id', 'name'])
                    ->get();
            }

            if ($type == '3') {
                // $filterData = \Indonesia::findCity($data->filterId, ['districts'])->districts->pluck('id')->toArray();
                $filterData = DB::table('indonesia_districts as a')
                    ->select(
                        'a.id',
                        'a.name',
                        DB::raw('COUNT(DISTINCT e.id) as step_one_count'),
                        DB::raw('SUM(CASE WHEN e.verify = true THEN 1 ELSE 0 END) as verif_step_one_count')
                    )
                    ->join('dapil_district_gos as b', 'b.districtId', '=', 'a.id')
                    ->join('dapil_districts as c', 'c.id', '=', 'b.dapilDistrictId')
                    ->join('indonesia_villages as d', 'd.district_code', '=', 'a.code')
                    ->leftJoin('step_ones as e', 'd.id', '=', 'e.villageId')
                    ->where('b.deleted_at', null)
                    ->where('c.id', $data->filterId)
                    ->groupBy('a.id')
                    ->get();

                // $dataReal = IndonesiaDistrict::whereIn('id', $filterData)
                //     ->select([])
                //     // ->select(['id', 'step_one_count'])
                //     // ->with('stepOne')
                //     ->withCount(['stepOne', 'verifStepOne'])
                //     ->addSelect(['id', 'code', 'name',])
                //     ->get();
                // $total = count($filterData);
                $total = $filterData->sum('step_one_count');
                return
                    $this->setResult([
                        'total' => $total,
                        'data' => $filterData
                    ])
                    // $this->setResult($filterData)
                    ->setCode(200)
                    ->setStatus(true);
            }
            $idkecamatanciamis = '2224';
            $idKuningan = '168';
            $idCiamis = '167';
            $idPengandaran = '178';
            $idBanjar = '187';
            $idKecamatan = $data->district;



            $total = $dataReal->sum('step_one_count');
            return
                $this->setResult([
                    'total' => $total,
                    'data' => $dataReal
                ])
                ->setCode(200)
                ->setStatus(true);
        } catch (\Exception $exception) {
            return $this->exceptionResponse($exception);
        };
    }

    public function getVillages()
    {
        try {
            // ->villages->pluck('name', 'id')
            $userId = auth()->user()->id;
            $assigment = Assignment::where('userId', $userId)->get()->pluck('districtId')->toArray();
            // $result = District::with(['villages'])->whereIn('id', $assigment)->get();
            $result = DB::table('indonesia_districts')
                ->where('indonesia_districts.id', $assigment)
                ->rightjoin('indonesia_villages', 'indonesia_districts.code', '=', 'indonesia_villages.district_code')
                ->select('indonesia_villages.id', 'indonesia_villages.name')
                ->get();

            return $this->setResult($result)
                ->setCode(200)
                ->setStatus(true);
        } catch (\Exception $exception) {
            return $this->exceptionResponse($exception);
        }
    }
    public function getSchools($id)
    {
        try {
            $result = Schools::where('villageId', $id)->select('id', 'name')->get();
            // $result = Schools::all()->count();
            // $result = DB::table('schools')->where('villageId', $id)->select('id', 'name')->get();

            return $this->setResult($result)
                ->setCode(200)
                ->setStatus(true);
        } catch (\Exception $exception) {
            return $this->exceptionResponse($exception);
        }
    }

    // Write something awesome :)
}
