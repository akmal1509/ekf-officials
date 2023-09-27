<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\StepOneRepository;
use App\Http\Resources\StepOneResource;
use App\Http\Requests\StepOne\UpdateStepOneRequest;
use App\Http\Requests\StepOne\StoreStepOneRequest;
use App\Models\StepOne;

class StepOneController extends Controller
{

    /**
     * For identity menu dashboard active
     *
     * @var [string]
     */
    private $stepOneRepository;

    public function __construct(StepOneRepository $stepOneRepository)
    {
        $this->stepOneRepository = $stepOneRepository;
        $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     *
     * @return mixed|\Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $result = $this->stepOneRepository->filter($request->all())->toJson();
        // return $result;
        return StepOneResource::paginateCollection($result);
    }

    public function show($id)
    {
        $result = $this->stepOneRepository->findOrFail($id)->toJson();
        // return $result;
        return StepOneResource::otherCollection($result);
    }

    public function count()
    {
        $result = $this->stepOneRepository->count()->toJson();
        return $result;
    }

    public function getVillages()
    {
        $result = $this->stepOneRepository->getVillages()->toJson();
        return $result;
    }
    public function getSchools()
    {
        $result = $this->stepOneRepository->getSchools(request()->id)->toJson();
        return $result;
    }

    public function store(StoreStepOneRequest $request)
    {
        $result = $this->stepOneRepository->create($request)->toJson();
        return $result;
        return StepOneResource::otherCollection($result);
    }

    public function update(UpdateStepOneRequest $request, $id)
    {
        $result = $this->stepOneRepository->update($id, $request)->toJson();
        return StepOneResource::otherCollection($result);
    }

    public function delete($id)
    {
        return $this->stepOneRepository->delete($id)->toJson();
    }
}
