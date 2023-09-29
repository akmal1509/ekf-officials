<?php

namespace App\Repositories;

use App\Models\User;
use Exception;

class UserRepository extends BaseRepository
{

    /**
     * Model class to be used in this repository for the common methods inside Eloquent
     * Don't remove or change $this->model variable name
     * @property Model|mixed $model;
     */
    protected $model;

    public function __construct(User $model)
    {
        $this->model = $model;
        $this->option['with'] = [
            'assignments:id,userId,dapilDistrictId,districtId',
            'assignments.dapils:id,dapilCategoryId,provinceId,cityId',
            'assignments.dapils.provinces:id,code,name',
            'assignments.dapils.cities:id,code,name',
            'assignments.districts:id,name,code',
            'assignments.districts.villages:id,name,code,district_code',
            'stepOnes:id,schoolId,userId',
            'stepOnes.schools:id,name'

            // 'assignments',
            // 'assignments.dapils',
            // 'assignments.dapils.provinces',
            // 'assignments.dapils.cities',
            // 'assignments.districts',
            // 'assignments.districts.villages'
            // 'assignments'
        ];

        $this->option['withCount'] = [
            'stepOnes'
        ];
    }

    // Write something awesome :)

    public function changePassword($data)
    {
        try {
            $resource = $this->model->where('id', auth()->user()->id)->first();
            $oldPassword = $data['oldPassword'];
            $newPassword = bcrypt($data['newPassword']);
            if (!password_verify($oldPassword, $resource->password)) {

                throw new \Exception('Terjadi kesalahan dalam permintaan.');
                // return $this
                //     ->setCode(500)
                //     ->setStatus(false)
                //     ->setMessage('Password tidak sama');
            }
            $resource['password'] = $newPassword;
            $resource->save();
            return $this
                ->setCode(200)
                ->setStatus(true);
        } catch (\Exception $exception) {
            return $this->exceptionResponse($exception);
        }
    }

    public function getMe()
    {
        try {
            $result = $this->model->with($this->option['with'])->where('id', auth()->user()->id)->first();
            return $this
                ->setCode(200)
                ->setStatus(true)
                ->setResult($result);
        } catch (\Exception $exception) {
            return $this->exceptionResponse($exception);
        }
    }
    public function create($data)
    {
        try {
            $result = $data->all();
            $result['userId'] = auth()->user()->id;
            if ($data->avatar) {
                $result['avatar'] = $this->uploadImage($data);
            }
            if ($data->slug) {
                $result['slug'] = SlugService::createSlug($this->model, 'slug',  $data['slug']);
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
    public function update($id, $data)
    {
        try {
            $source = $this->model->where('id', auth()->user()->id)->first();
            $result = $data->all();
            if ($data->avatar) {
                $this->deleteImage($source->avatar);
                $image = $this->uploadImage($data);
                $result['avatar'] = $image;
            }
            if ($data->slug) {
                $result['slug'] = SlugService::createSlug($this->model, 'slug',  $data['slug']);
            }

            $source->update($result);
            return $this
                ->setCode(200)
                ->setStatus(true)
                ->setMessage($image)
                ->setResult($source);
        } catch (\Exception $exception) {
            return $this->exceptionResponse($exception);
        }
    }
}
