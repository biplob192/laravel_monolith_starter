<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Crop;
use App\Models\User;
use App\Models\Season;
use App\Models\Variety;
use App\Models\Category;
use App\Models\SoilType;
use App\Models\CropSeason;
use App\Models\GrowthStage;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Models\CropRequirement;
use App\Http\Requests\CropRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\BaseController;
use RealRashid\SweetAlert\Facades\Alert;

class CropController extends BaseController
{
    public function index()
    {
        try {
            return view('crop.index');
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


            $usersQuery = Crop::query()
                ->when($searchValue, function ($query, $searchValue) {
                    $query->where(function ($query) use ($searchValue) {
                        $query->where('name', 'like', '%' . $searchValue . '%')
                            ->orWhere('scientific_name', 'like', '%' . $searchValue . '%');
                    });
                });

            $recordsFiltered = $usersQuery->count();


            if ($perPage != -1 && is_numeric($perPage)) {
                $usersQuery->offset($start)->limit($perPage);
            }

            $quesyDatas = $usersQuery->orderBy($orderBy, $order)->get();
            $finalDataSet = array();

            foreach ($quesyDatas as $data) {
                $singleData = [$data->id, $data->image, $data->name, $data->scientific_name, '', ''];
                array_push($finalDataSet, $singleData);
                $singleData = [''];
            }


            return ['data' => $finalDataSet, 'recordsTotal' => Crop::count(), 'recordsFiltered' => $recordsFiltered, 'status' => 200];
        } catch (Exception $e) {

            $error = $e->getMessage();
            return $this->sendError('Internal server error.', $error, 500);
        }
    }

    public function create()
    {
        try {
            $categories = Category::latest()->get();
            $seasons = Season::latest()->get();
            return view('crop.create', compact('seasons', 'categories'));
        } catch (Exception $e) {

            $error = $e->getMessage();
            return $this->sendError('Internal server error.', $error, 500);
        }
    }

    public function store(CropRequest $request)
    {
        try {
            // Start a database transaction
            DB::beginTransaction();

            $crop = new Crop();

            $crop->name             = $request->name;
            $crop->scientific_name  = $request->scientific_name;
            $crop->category_id      = $request->category_id;
            $crop->description      = $request->description;

            if ($request->file('image')) {
                // Pass folder_name and file as param
                $path = uploadFile('crop_images', $request->file('image'));
                $crop->image = $path;
            }
            $crop->save();


            foreach ($request->seasons as $season_id) {
                CropSeason::updateOrCreate(
                    [
                        'crop_id'   => $crop->id,
                        'season_id' => $season_id,
                    ],
                    [
                        'status'    => 1,
                    ]
                );
            }

            foreach ($request->sections as $sectionData) {
                GrowthStage::updateOrCreate(
                    [
                        'crop_id'   => $crop->id,
                        'name'      => $sectionData['growth_stage']
                    ],
                    [
                        'status'      => 1
                    ]
                );
            }

            foreach ($request->varieties as $variety) {
                Variety::updateOrCreate(
                    [
                        'crop_id'   => $crop->id,
                        'name'      => $variety['variety']
                    ],
                    [
                        'status'    => 1
                    ]
                );
            }

            // If everything is successful, commit the transaction
            DB::commit();

            Alert::success('Congrate', 'Crop created successfully!');
            return redirect()->route('crops.create');
        } catch (Exception $e) {

            // Something went wrong, so rollback the transaction
            DB::rollBack();

            $error = $e->getMessage();
            return $this->sendError('Internal server error.', $error, 500);
        }
    }

    public function show($id)
    {
        try {
            $crop = Crop::find($id);
            $varieties = Variety::where('crop_id', $id)->latest()->get();
            $soil_types = SoilType::latest()->get();
            return view('crop.show', compact('crop', 'varieties', 'soil_types'));
        } catch (Exception $e) {

            $error = $e->getMessage();
            return $this->sendError('Internal server error.', $error, 500);
        }
    }

    public function detailsData(Request $request, $id)
    {
        try {
            // Define the default page and perPage values
            $varietyID      = $request->variety_id;
            $soilType_ID    = $request->soil_type_id;

            $perPage        = $request->input("length", 10);
            $searchValue    = $request->search['value'];
            $start          = $request->input("start");
            $orderBy        = 'id';
            $order          = 'desc';


            $usersQuery = CropRequirement::query()
                ->with(['growthStage'])
                ->where('crop_id', $id)
                ->when($soilType_ID, function ($query, $soilType_ID) {
                    $query->where(function ($query) use ($soilType_ID) {
                        $query->where('soil_type_id', $soilType_ID);
                    });
                })
                ->when($varietyID, function ($query, $varietyID) {
                    $query->where(function ($query) use ($varietyID) {
                        $query->where('variety_id', $varietyID);
                    });
                })
                ->when($searchValue, function ($query, $searchValue) {
                    $query->where(function ($query) use ($searchValue) {
                        $query->where('water', 'like', '%' . $searchValue . '%')
                            ->orWhere('nitrogen', 'like', '%' . $searchValue . '%')
                            ->orWhere('potassium', 'like', '%' . $searchValue . '%')
                            ->orWhere('phosphorus', 'like', '%' . $searchValue . '%');
                        // ->orWhereHas('growthStage', function ($subQuery) use ($searchValue) {
                        //     $subQuery->where('name', 'like', '%' . $searchValue . '%');
                        // });
                    });
                });

            // if ($request->variety_id) {
            //     $usersQuery->where('variety_id', $request->variety_id);
            // }
            $recordsFiltered = $usersQuery->count();


            if ($perPage != -1 && is_numeric($perPage)) {
                $usersQuery->offset($start)->limit($perPage);
            }

            $quesyDatas = $usersQuery->orderBy($orderBy, $order)->get();
            // dd($quesyDatas);
            $finalDataSet = array();

            foreach ($quesyDatas as $data) {
                $singleData = [$data->id, $data->growthStage->name, $data->water, $data->nitrogen, $data->potassium, $data->phosphorus];
                array_push($finalDataSet, $singleData);
                $singleData = [''];
            }


            // dd($finalDataSet);
            return ['data' => $finalDataSet, 'recordsTotal' => CropRequirement::where('crop_id', $id)->count(), 'recordsFiltered' => $recordsFiltered, 'status' => 200];
        } catch (Exception $e) {

            $error = $e->getMessage();
            return $this->sendError('Internal server error.', $error, 500);
        }
    }

    public function edit($id)
    {
        try {
            if (!$crop = Crop::with(['category', 'crop_season', 'growth_stage', 'variety'])->find($id)) {
                throw new Exception("No record found.", 404);
            }

            $categories = Category::latest()->get();
            $seasons = Season::latest()->get();
            $growthStageCount = GrowthStage::where('crop_id', $id)->count();
            $varietyCount = Variety::where('crop_id', $id)->count();

            return view('crop.edit', compact('crop', 'categories', 'seasons', 'growthStageCount', 'varietyCount'));
        } catch (Exception $e) {

            $error = $e->getMessage();
            return $this->sendError('Internal server error.', $error, 500);
        }
    }

    public function update(CropRequest $request, $id)
    {
        // dd($exGrowthStageIds);

        // dd($request->all());

        // $exGrowthStageIds = GrowthStage::where('crop_id', $id)->pluck('id');
        // $growthStageIds = [];
        // foreach ($request->sections as $section) {
        //     if (isset($section['growth_stage_id'])) {
        //         $growthStageIds[] = $section['growth_stage_id'];
        //     }
        // }
        // dd($growthStageIds);

        try {
            if (!$crop = Crop::find($id)) {
                throw new Exception("No record found.", 404);
            }

            // Start a database transaction
            DB::beginTransaction();

            $crop->name             = $request->name;
            $crop->scientific_name  = $request->scientific_name;
            $crop->category_id      = $request->category_id;
            $crop->description      = $request->description;

            if ($request->file('image')) {
                // Check if the category has a previous icon and unlink it
                if ($crop->image) {
                    Storage::disk('public')->delete($crop->image);
                }

                // Pass folder_name and file as param
                $path = uploadFile('crop_images', $request->file('image'));
                $crop->image = $path;
            }
            $crop->save();


            CropSeason::where('crop_id', $id)->delete();
            foreach ($request->seasons as $season_id) {
                CropSeason::updateOrCreate(
                    [
                        'crop_id'   => $crop->id,
                        'season_id' => $season_id,
                    ],
                    [
                        'status'    => 1,
                    ]
                );
            }

            // Previous code
            // GrowthStage::where('crop_id', $id)->delete();
            // foreach ($request->sections as $sectionData) {
            //     GrowthStage::updateOrCreate(
            //         [
            //             'crop_id'   => $crop->id,
            //             'name'      => $sectionData['growth_stage']
            //         ],
            //         [
            //             'status'      => 1
            //         ]
            //     );
            // }

            // New code
            // Initialize an array to store the IDs of "GrowthStage" records to be deleted
            $exGrowthStageIds = GrowthStage::where('crop_id', $id)->pluck('id')->toArray();
            $growthStageIds = [];

            // Loop through the "sections" array and extract "growth_stage_id"
            foreach ($request->sections as $section) {
                if (isset($section['growth_stage_id'])) {
                    $growthStageId = $section['growth_stage_id'];
                    $growthStageIds[] = $growthStageId;

                    $growthStage = GrowthStage::find($growthStageId);
                    $growthStage->name = $section['growth_stage'];
                    $growthStage->crop_id = $crop->id;

                    $growthStage->save();
                } else {
                    GrowthStage::updateOrCreate(
                        [
                            'name'      => $section['growth_stage'],
                            'crop_id'   => $crop->id,
                        ],
                        [
                            'status'      => 1
                        ]
                    );
                }
            }

            $idsToDelete = array_diff($exGrowthStageIds, $growthStageIds);

            // Delete the "GrowthStage" records with IDs found in $idsToDelete
            GrowthStage::whereIn('id', $idsToDelete)->delete();

            Variety::where('crop_id', $id)->delete();
            foreach ($request->varieties as $variety) {
                Variety::updateOrCreate(
                    [
                        'crop_id'   => $crop->id,
                        'name'      => $variety['variety']
                    ],
                    [
                        'status'    => 1
                    ]
                );
            }

            // If everything is successful, commit the transaction
            DB::commit();

            Alert::success('Congrate', 'Crop updated successfully!');
            return redirect()->route('crops.index');
        } catch (Exception $e) {

            // Something went wrong, so rollback the transaction
            DB::rollBack();

            $error = $e->getMessage();
            return $this->sendError('Internal server error.', $error, 500);
        }
    }

    public function destroy($id)
    {
        try {
            if ($crop = Crop::find($id)) {
                if ($crop->image) {
                    Storage::disk('public')->delete($crop->image);
                }

                $crop->delete();
            }
            return true;

            Alert::success('Congrate', 'Crop deleted successfully!');
            return redirect()->route('crops.index');
        } catch (Exception $e) {

            $error = $e->getMessage();
            return $this->sendError('Internal server error.', $error, 500);
        }
    }

    public function userList()
    {
        $users = User::limit(10)->get();
        return $users;
    }
}
