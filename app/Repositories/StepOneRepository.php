<?php

namespace App\Repositories;

use App\Models\StepOne;
use App\Models\Assignment;
use App\Models\Schools;
use Illuminate\Support\Facades\DB;
use Laravolt\Indonesia\Models\District;
use Laravolt\Indonesia\Models\Village;

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
            'villages:id,district_code',
            'villages.district:id,code'
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
