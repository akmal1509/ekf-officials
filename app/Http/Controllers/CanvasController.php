<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\CanvasRepository;
use App\Http\Resources\CanvasResource;
use App\Http\Requests\Canvas\UpdateCanvasRequest;
use App\Http\Requests\Canvas\StoreCanvasRequest;
use App\Models\Canvas;

class CanvasController extends Controller
{

    /**
     * For identity menu dashboard active
     *
     * @var [string]
     */
    private $canvasRepository;

    public function __construct(CanvasRepository $canvasRepository)
    {
        $this->canvasRepository = $canvasRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return mixed|\Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $result = $this->canvasRepository->filter($request->all())->toJson();
        // return $result;
        return CanvasResource::paginateCollection($result);
    }

    public function show($id)
    {
        $result = $this->canvasRepository->findOrFail($id)->toJson();
        // return $result;
        return CanvasResource::otherCollection($result);
    }

    public function store(StoreCanvasRequest $request)
    {
        $result = $this->canvasRepository->create($request)->toJson();
         // return $result;
        return CanvasResource::otherCollection($result);
    }

      public function update(UpdateCanvasRequest $request, $id)
    {
        $result = $this->canvasRepository->update($id, $request)->toJson();
        return CanvasResource::otherCollection($result);
    }

    public function delete($id)
    {
        return $this->canvasRepository->delete($id)->toJson();
    }
}
