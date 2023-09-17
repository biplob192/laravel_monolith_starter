<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Interfaces\UserRepositoryInterface;

class UserController extends Controller
{
    public function __construct(private UserRepositoryInterface $userRepository)
    {
    }

    public function index()
    {
        return $this->userRepository->index();
    }

    public function getData(Request $request)
    {
        return $this->userRepository->getData($request);
    }

    public function create()
    {
        return $this->userRepository->create();
    }

    public function store(UserRequest $request)
    {
        return $this->userRepository->store($request);
    }

    public function destroy($id)
    {
        return $this->userRepository->destroy($id);
    }

    public function loggedInUser()
    {
        return $this->userRepository->loggedInUser();
    }

    public function export()
    {
        return $this->userRepository->export();
    }
}
