<?php

namespace App\Http\Controllers;

use App\Http\Requests\AttendanceRequest;
use App\Interfaces\AttendanceRepositoryInterface;

class AttendanceController extends Controller
{
    public function __construct(private AttendanceRepositoryInterface $attendanceRepository)
    {
    }

    public function index()
    {
        return $this->attendanceRepository->index();
    }

    public function store(AttendanceRequest $request)
    {
        return $this->attendanceRepository->store($request);
    }

    public function show($id)
    {
        return $this->attendanceRepository->show($id);
    }

    public function edit($id)
    {
        return $this->attendanceRepository->edit($id);
    }

    public function update(AttendanceRequest $request, $id)
    {
        return $this->attendanceRepository->update($request, $id);
    }

    public function destroy($id)
    {
        return $this->attendanceRepository->destroy($id);
    }
}
