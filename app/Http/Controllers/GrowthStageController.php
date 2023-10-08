<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Http\Requests\GrowthStageRequest;
use App\Models\GrowthStage;

class GrowthStageController extends BaseController
{
    public function index()
    {
        try {
            return view('growth_stage.index');
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


            $usersQuery = GrowthStage::query()
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


            return ['data' => $finalDataSet, 'recordsTotal' => GrowthStage::count(), 'recordsFiltered' => $recordsFiltered, 'status' => 200];
        } catch (Exception $e) {

            $error = $e->getMessage();
            return $this->sendError('Internal server error.', $error, 500);
        }
    }

    public function create()
    {
        try {
            return view('growth_stage.create');
        } catch (Exception $e) {

            $error = $e->getMessage();
            return $this->sendError('Internal server error.', $error, 500);
        }
    }

    public function store(GrowthStageRequest $request)
    {
        dd($request->all());
        try {
            $season = new GrowthStage();
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

    public function certainCropGrowthStage($id)
    {
        try {
            $growthStages = GrowthStage::where('crop_id', $id)->latest()->get();
            return $growthStages;
        } catch (Exception $e) {

            $error = $e->getMessage();
            return $this->sendError('Internal server error.', $error, 500);
        }
    }
}
