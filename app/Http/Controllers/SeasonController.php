<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Season;
use Illuminate\Http\Request;
use App\Http\Requests\SeasonRequest;
use App\Http\Controllers\BaseController;
use RealRashid\SweetAlert\Facades\Alert;

class SeasonController extends BaseController
{
    public function index()
    {
        try {
            return view('season.index');
        } catch (Exception $e) {

            $error = $e->getMessage();
            return $this->sendError('Internal server error.', $error, 500);
        }
    }

    public function getData(Request $request)
    {
        try {
            // Define the default page and perPage values
            $perPage        = $request->input("length", 10);
            $searchValue    = $request->search['value'];
            $start          = $request->input("start");
            $orderBy        = 'id';
            $order          = 'desc';


            $usersQuery = Season::query()
                ->when($searchValue, function ($query, $searchValue) {
                    $query->where(function ($query) use ($searchValue) {
                        $query->where('name', 'like', '%' . $searchValue . '%');
                    });
                });

            $recordsFiltered = $usersQuery->count();


            if ($perPage != -1 && is_numeric($perPage)) {
                $usersQuery->offset($start)->limit($perPage);
            }

            $quesyDatas = $usersQuery->orderBy($orderBy, $order)->get();
            $finalDataSet = array();

            foreach ($quesyDatas as $data) {
                $singleData = [$data->id, $data->name, '', ''];
                array_push($finalDataSet, $singleData);
                $singleData = [''];
            }


            return ['data' => $finalDataSet, 'recordsTotal' => Season::count(), 'recordsFiltered' => $recordsFiltered, 'status' => 200];
        } catch (Exception $e) {

            $error = $e->getMessage();
            return $this->sendError('Internal server error.', $error, 500);
        }
    }

    public function create()
    {
        try {
            return view('season.create');
        } catch (Exception $e) {

            $error = $e->getMessage();
            return $this->sendError('Internal server error.', $error, 500);
        }
    }

    public function store(SeasonRequest $request)
    {
        try {
            $season = new Season();
            $season->name = $request->name;
            $season->save();

            Alert::success('Congrate', 'Crop season created successfully!');
            return redirect()->route('seasons.create');
        } catch (Exception $e) {

            $error = $e->getMessage();
            return $this->sendError('Internal server error.', $error, 500);
        }
    }

    public function show($id)
    {
        try {
            if (!$season = Season::find($id)) {
                throw new Exception("No record found.", 404);
            }

            return view('season.show', compact('season'));
        } catch (Exception $e) {

            $error = $e->getMessage();
            return $this->sendError('Internal server error.', $error, 500);
        }
    }

    public function edit($id)
    {
        try {
            if (!$season = Season::find($id)) {
                throw new Exception("No record found.", 404);
            }

            return view('season.edit', compact('season'));
        } catch (Exception $e) {

            $error = $e->getMessage();
            return $this->sendError('Internal server error.', $error, 500);
        }
    }

    public function update(SeasonRequest $request, $id)
    {
        try {
            if (!$season = Season::find($id)) {
                throw new Exception("No record found.", 404);
            }

            $season->name = $request->name;
            $season->save();

            Alert::success('Congrate', 'Crop season updated successfully!');
            return redirect()->route('seasons.index');
        } catch (Exception $e) {

            $error = $e->getMessage();
            return $this->sendError('Internal server error.', $error, 500);
        }
    }

    public function destroy($id)
    {
        try {
            if (!Season::find($id)?->delete()) {
                throw new Exception("No record found.", 404);
            }

            return true;
        } catch (Exception $e) {

            $error = $e->getMessage();
            return $this->sendError('Internal server error.', $error, 500);
        }
    }
}
