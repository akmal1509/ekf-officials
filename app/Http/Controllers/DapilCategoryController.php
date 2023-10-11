<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\DapilCategoryRepository;
use App\Http\Resources\DapilCategoryResource;
use App\Http\Requests\DapilCategory\UpdateDapilCategoryRequest;
use App\Http\Requests\DapilCategory\StoreDapilCategoryRequest;
use App\Models\DapilCategory;

class DapilCategoryController extends Controller
{

    /**
     * For identity menu dashboard active
     *
     * @var [string]
     */
    private $dapilCategoryRepository;

    public function __construct(DapilCategoryRepository $dapilCategoryRepository)
    {
        $this->dapilCategoryRepository = $dapilCategoryRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return mixed|\Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $result = $this->dapilCategoryRepository->filter($request->all())->toJson();
        // return $result;
        return DapilCategoryResource::paginateCollection($result);
    }

    public function show($id)
    {
        $result = $this->dapilCategoryRepository->findOrFail($id)->toJson();
        // return $result;
        return DapilCategoryResource::otherCollection($result);
    }

    public function store(StoreDapilCategoryRequest $request)
    {
        $result = $this->dapilCategoryRepository->create($request)->toJson();
         // return $result;
        return DapilCategoryResource::otherCollection($result);
    }

      public function update(UpdateDapilCategoryRequest $request, $id)
    {
        $result = $this->dapilCategoryRepository->update($id, $request)->toJson();
        return DapilCategoryResource::otherCollection($result);
    }

    public function delete($id)
    {
        return $this->dapilCategoryRepository->delete($id)->toJson();
    }
}
