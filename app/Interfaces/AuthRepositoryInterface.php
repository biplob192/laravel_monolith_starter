<?php

namespace App\Interfaces;

interface AuthRepositoryInterface
{
    public function loginView();
    public function loginViewNew();
    public function login($request);
    public function registerView();
    public function register($request);
    public function dashboard();
    public function home();
    public function logout();
}
