<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\AssignmentRepository;
use App\Http\Resources\AssignmentResource;
use App\Http\Requests\Assignment\UpdateAssignmentRequest;
use App\Http\Requests\Assignment\StoreAssignmentRequest;
use App\Models\Assignment;

class AssignmentController extends Controller
{

    /**
     * For identity menu dashboard active
     *
     * @var [string]
     */
    private $assignmentRepository;

    public function __construct(AssignmentRepository $assignmentRepository)
    {
        $this->assignmentRepository = $assignmentRepository;
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return mixed|\Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $result = $this->assignmentRepository->filter($request->all())->toJson();
        // return $result;
        return AssignmentResource::paginateCollection($result);
    }

    public function show($id)
    {
        $result = $this->assignmentRepository->findOrFail($id)->toJson();
        // return $result;
        return AssignmentResource::otherCollection($result);
    }

    public function store(StoreAssignmentRequest $request)
    {
        return $this->assignmentRepository->create($request)->toJson();
        // return $result;
        // return AssignmentResource::otherCollection($result);
    }

    public function update(UpdateAssignmentRequest $request, $id)
    {
        return  $this->assignmentRepository->update($id, $request)->toJson();
    }

    public function delete($id)
    {
        return $this->assignmentRepository->delete($id)->toJson();
    }

    public function district()
    {
        return $this->assignmentRepository->district(request()->id)->toJson();
    }

    public function dapil()
    {
        return $this->assignmentRepository->dapil()->toJson();
    }

    public function users()
    {
        return $this->assignmentRepository->users()->toJson();
    }
}
