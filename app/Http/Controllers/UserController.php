<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use App\Http\Resources\UserResource;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Requests\User\StoreUserRequest;
use App\Models\User;

class UserController extends Controller
{

    /**
     * For identity menu dashboard active
     *
     * @var [string]
     */
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return mixed|\Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $result = $this->userRepository->filter($request->all())->toJson();
        // return $result;
        return UserResource::paginateCollection($result);
    }

    public function show($id)
    {
        $result = $this->userRepository->findOrFail($id)->toJson();
        // return $result;
        return UserResource::otherCollection($result);
    }

    public function getMe()
    {
        $result = $this->userRepository->getMe()->toJson();
        // return $result;
        return UserResource::otherCollection($result);
    }

    public function store(StoreUserRequest $request)
    {
        $result = $this->userRepository->create($request)->toJson();
        // return $result;
        return UserResource::otherCollection($result);
    }

    public function update(UpdateUserRequest $request, $id)
    {
        $result = $this->userRepository->update($id, $request)->toJson();
        return $result;
        return UserResource::otherCollection($result);
    }

    public function delete($id)
    {
        return $this->userRepository->delete($id)->toJson();
    }
}
