<?php

namespace App\Repositories;

use Exception;
use App\Models\Attendance;
use App\Http\Controllers\BaseController;
use RealRashid\SweetAlert\Facades\Alert;
use App\Interfaces\AttendanceRepositoryInterface;

class AttendanceRepository extends BaseController implements AttendanceRepositoryInterface
{
    public function index()
    {
        try {
            $attendances = Attendance::with('user')->orderBy('id', 'DESC')->get();
            return view('attendance.index', ['attendances' => $attendances]);
        } catch (Exception $e) {

            $error = $e->getMessage();
            return $this->sendError('Internal server error.', $error, 500);
        }
    }

    public function store($request)
    {
        try {
            $attendance = Attendance::where('user_id', $request->user_id)->whereDate('check_in', now())->first();


            if (!$attendance) {
                $attendance = new Attendance();

                $attendance->user_id = $request->user_id;
                $attendance->check_in = now();
                $attendance->save();

                $message = 'Successfully logged in!';
            } else {
                $attendance->check_out = now();
                $attendance->status = 1;
                $attendance->save();

                $message = 'Successfully logged out!';
            }

            $response = ['data' => $attendance, 'message' => $message];
            return $response;
        } catch (Exception $e) {

            $error = $e->getMessage();
            return $this->sendError('Internal server error.', $error, 500);
        }
    }

    public function show($id)
    {
        try {
            return Attendance::where('user_id', $id)->whereDate('created_at', now())->first();
        } catch (Exception $e) {

            $error = $e->getMessage();
            return $this->sendError('Internal server error.', $error, 500);
        }
    }

    public function edit($id)
    {
        try {
            $attendance = Attendance::with('user')->find($id);
            return view('attendance.edit', ['attendance' => $attendance]);
        } catch (Exception $e) {

            $error = $e->getMessage();
            return $this->sendError('Internal server error.', $error, 500);
        }
    }

    public function update($request, $id)
    {
        try {
            $attendance = Attendance::find($id);

            $attendance->check_in = $request->check_in;
            $attendance->check_out = $request->check_out;
            $attendance->save();

            if ($attendance->check_in && $attendance->check_out) {
                $attendance->status = 1;
            } else $attendance->status = 0;

            $attendance->save();

            Alert::success('Attendance', 'Record updated successfully!');
            return redirect()->route('attendance.index');
        } catch (Exception $e) {

            $error = $e->getMessage();
            return $this->sendError('Internal server error.', $error, 500);
        }
    }

    public function destroy($id)
    {
        try {
            return Attendance::find($id)->delete();
        } catch (Exception $e) {

            $error = $e->getMessage();
            return $this->sendError('Internal server error.', $error, 500);
        }
    }
}
