<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Interfaces\AuthRepositoryInterface;

class AuthController extends Controller
{
    public function __construct(private AuthRepositoryInterface $authRepository)
    {
    }

    public function loginView()
    {
        return $this->authRepository->loginView();
    }

    public function loginViewNew()
    {
        return $this->authRepository->loginViewNew();
    }

    public function login(LoginRequest $request)
    {
        return $this->authRepository->login($request);
    }

    public function registerView()
    {
        return $this->authRepository->registerView();
    }

    public function register(RegisterRequest $request)
    {
        return $this->authRepository->register($request);
    }

    public function dashboard()
    {
        return $this->authRepository->dashboard();
    }

    public function home()
    {
        return $this->authRepository->home();
    }

    public function logout()
    {
        return $this->authRepository->logout();
    }
}
