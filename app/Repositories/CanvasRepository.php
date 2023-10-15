<?php

namespace App\Repositories;

use App\Models\Canvas;
use Illuminate\Support\Facades\DB;

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
        $this->option['with'] = [
            'parents:id,name,nik,nkk'
        ];
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

    public function create($data)
    {
        try {
            $result = $data->all();
            $result['createdBy'] = auth()->user()->id;
            $result['ktpImage'] = $this->uploadImage2($data, 'ktp');
            $result['withImage'] = $this->uploadImage2($data, 'withImage');
            $result['rumahImage'] = $this->uploadImage2($data, 'rumah');
            $result['kkImage'] = $this->uploadImage2($data, 'kk');
            try {
                DB::beginTransaction();
                $parent = $this->model->create($result);
                if ($data->real) {
                    // dd($data->real);
                    foreach ($data->real as $insert) {
                        $i = 0;

                        $create = [
                            'name' => $insert['name'],
                            'nik' => $insert['nik'],
                            'nkk' => $insert['nkk'],
                        ];
                        if (isset($insert['kk'])) {

                            $create['kkImage'] = $this->uploadImage3($insert, 'real', $i, 'kk');
                        }
                        if (isset($insert['ktp'])) {
                            // dd($insert);
                            $create['ktpImage'] = $this->uploadImage3($data,  'real', $i, 'ktp');
                        }
                        $create['parentId'] = $parent->id;
                        $create['createdBy'] = auth()->user()->id;
                        $create['villageId'] = $data->villageId;
                        $this->model->create($create);
                        $i++;
                    }
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

    // Write something awesome :)
}
