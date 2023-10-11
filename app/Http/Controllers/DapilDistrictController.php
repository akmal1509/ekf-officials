<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\DapilDistrictRepository;
use App\Http\Resources\DapilDistrictResource;
use App\Http\Requests\DapilDistrict\UpdateDapilDistrictRequest;
use App\Http\Requests\DapilDistrict\StoreDapilDistrictRequest;
use App\Models\DapilDistrict;

class DapilDistrictController extends Controller
{

    /**
     * For identity menu dashboard active
     *
     * @var [string]
     */
    private $dapilDistrictRepository;

    public function __construct(DapilDistrictRepository $dapilDistrictRepository)
    {
        $this->dapilDistrictRepository = $dapilDistrictRepository;
        $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     *
     * @return mixed|\Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $result = $this->dapilDistrictRepository->filter($request->all())->toJson();
        // return $result;
        return DapilDistrictResource::paginateCollection($result);
    }

    public function show($id)
    {
        $result = $this->dapilDistrictRepository->findOrFail($id)->toJson();
        // return $result;
        return DapilDistrictResource::otherCollection($result);
    }

    public function category()
    {
        $result = $this->dapilDistrictRepository->category()->toJson();
        return $result;
    }
    public function city()
    {
        $result = $this->dapilDistrictRepository->city(request()->id)->toJson();
        return $result;
    }
    public function district()
    {
        $result = $this->dapilDistrictRepository->district(request()->id)->toJson();
        return $result;
    }
    public function province()
    {
        $result = $this->dapilDistrictRepository->province()->toJson();
        return $result;
    }

    public function store(StoreDapilDistrictRequest $request)
    {
        $result = $this->dapilDistrictRepository->create($request)->toJson();
        // return $result;
        return DapilDistrictResource::otherCollection($result);
    }

    public function update(UpdateDapilDistrictRequest $request, $id)
    {
        $result = $this->dapilDistrictRepository->update($id, $request)->toJson();
        return DapilDistrictResource::otherCollection($result);
    }

    public function delete($id)
    {
        return $this->dapilDistrictRepository->delete($id)->toJson();
    }
}
