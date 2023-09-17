<?php

namespace App\Interfaces;


interface UserRepositoryInterface
{
    public function index();
    public function getData($request);
    public function create();
    public function store($request);
    public function destroy($id);
    public function loggedInUser();
    public function export();
}
