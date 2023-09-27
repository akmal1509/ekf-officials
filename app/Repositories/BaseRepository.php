<?php


namespace App\Repositories;

use App\Traits\HasImage;
use App\Traits\ResultService;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rules\Exists;
use Cviebrock\EloquentSluggable\Services\SlugService;

class BaseRepository
{
    use ResultService;
    use HasImage;

    protected $model;
    protected $option;
    protected $title = "";
    protected $create_message = "";
    protected $update_message = "";
    protected $delete_message = "";


    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Find an item by id
     * @param mixed $id
     * @return Model|null
     */
    public function find($id)
    {
        try {
            $result = $this->model->find($id);
            return $this->setResult($result)
                ->setCode(200)
                ->setStatus(true);
        } catch (\Exception $exception) {
            return $this->exceptionResponse($exception);
        }
    }

    /**
     * Find an item by id or fail
     * @param mixed $id
     * @return Model|null
     */
    public function findOrFail($id)
    {
        try {
            $result = $this->model->with($this->option['with'] ?? [])->withCount($this->option['withCount'] ?? [])->findOrFail($id);
            return $this->setResult($result)
                ->setCode(200)
                ->setStatus(true);
        } catch (\Exception $exception) {
            return $this->exceptionResponse($exception);
        }
    }

    /**
     * Find an item by where clouse
     * @param mixed $id
     * @return Model|null
     */
    public function whereFirst($column, $data)
    {
        try {
            $result = $this->model->with($this->option['with'] ?? [])->withCount($this->option['withCount'] ?? [])->where($column, $data)->first();
            return $this->setResult($result)
                ->setCode(200)
                ->setStatus(true);
        } catch (\Exception $exception) {
            return $this->exceptionResponse($exception);
        }
    }

    /**
     * Return all items
     * @return Collection|null
     */
    public function all()
    {
        try {
            $result = $this->model->all();;
            return $this->setResult($result)
                ->setCode(200)
                ->setStatus(true);
        } catch (\Exception $exception) {
            return $this->exceptionResponse($exception);
        }
    }


    public function paginate($limit)
    {
        try {
            $result = $this->model->with($this->option['with'] ?? '')->withCount($this->option['withCount'] ?? '')->paginate($limit);
            return $this->setResult($result)
                ->setCode(200)
                ->setStatus(true);
        } catch (\Exception $exception) {
            return $this->exceptionResponse($exception);
        }
    }

    /**
     * Create an item
     * @param array|mixed $data
     * @return Model|null
     */
    public function create($data)
    {
        try {
            $result = $data->all();
            $result['userId'] = auth()->user()->id;
            if ($data->image) {
                $result['image'] = $this->uploadImage($data);
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

    public function filter($data)
    {
        $limitIdent = $data['limit'] ?? '5';
        $limit = $limitIdent < 1 ? PHP_INT_MAX : $limitIdent;
        $data['guest'] = auth()->user()->admin == 0 ? true : false;
        try {

            $result = $this->model->with($this->option['with'] ?? [])->withCount($this->option['withCount'] ?? [])->filter($data)->latest()->paginate($limit);


            return $this->setCode(200)
                ->setStatus(true)
                ->setResult($result);
        } catch (\Exception $exception) {
            return $this->exceptionResponse($exception);
        }
    }

    public function filterWithOutPaginate($data)
    {
        try {
            $result = $this->model->latest()->filter($data)->get();
            return $this->setCode(200)
                ->setStatus(true)
                ->setResult($result);
        } catch (\Exception $exception) {
            return $this->exceptionResponse($exception);
        }
    }

    /**
     * Update a model
     * @param int|mixed $id
     * @param array|mixed $data
     * @return bool|mixed
     */
    public function update($id, $data)
    {
        try {
            $source = $this->model->findOrFail($id);
            $result = $data->all();
            if ($data->image) {
                $this->deleteImage($source->image);
                $result['image'] = $this->uploadImage($data);
            }
            if ($data->slug) {
                $result['slug'] = SlugService::createSlug($this->model, 'slug',  $data['slug']);
            }

            $source->update($result);
            return $this
                ->setCode(200)
                ->setStatus(true)
                ->setResult($source);
        } catch (\Exception $exception) {
            return $this->exceptionResponse($exception);
        }
    }

    /**
     * Delete a model
     * @param int|Model $id
     */
    public function delete($id)
    {
        try {
            $result = $this->model->findOrFail($id);
            if ($result) {
                $this->model->destroy($id);
            }
            return $this
                ->setCode(200)
                ->setStatus(true)
                ->setMessage('Data has been deleted');
        } catch (\Exception $exception) {
            return $this->exceptionResponse($exception);
        }
    }

    /**
     * multiple delete
     * @param array $id
     * @return mixed
     */
    public function destroy(array $id)
    {
        try {
            $this->model->destroy($id);
            return $this
                ->setCode(200)
                ->setStatus(true);
        } catch (\Exception $exception) {
            return $this->exceptionResponse($exception);
        }
    }
}
