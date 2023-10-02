<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\CropRequirement;
use RealRashid\SweetAlert\Facades\Alert;
use App\Http\Controllers\BaseController;
use App\Http\Requests\CropRequirementRequest;
use App\Models\Crop;
use App\Models\Variety;

class CropRequirementController extends BaseController
{
    public function index()
    {
        try {
            $cropRequirements = CropRequirement::latest()->get();
            return view('crop_requirement.index', compact('cropRequirements'));
        } catch (Exception $e) {

            $error = $e->getMessage();
            return $this->sendError('Internal server error.', $error, 500);
        }
    }

    public function create()
    {
        try {
            $crops = Crop::latest()->get();
            return view('crop_requirement.create', compact('crops'));
        } catch (Exception $e) {

            $error = $e->getMessage();
            return $this->sendError('Internal server error.', $error, 500);
        }
    }

    public function store(CropRequirementRequest $request)
    {
        // dd($request->all());
        try {
            foreach ($request->sections as $sectionData) {
                CropRequirement::updateOrCreate(
                    [
                        'crop_id'           => $request->crop,
                        'variety_id'        => $request->variety_id,
                        'soil_type_id'      => $request->soil_type,
                        'groth_stage_id'    => $sectionData['groth_stage'],
                    ],
                    [
                        'water'             => $sectionData['water'],
                        'nitrogen'          => $sectionData['nitrogen'],
                        'potassium'         => $sectionData['potassium'],
                        'phosphorus'        => $sectionData['phosphorus'],
                    ]
                );
            }

            Alert::success('Congrate', 'Crop Requirement created successfully!');
            return redirect()->route('crop_requirements.create');
        } catch (Exception $e) {

            $error = $e->getMessage();
            return $this->sendError('Internal server error.', $error, 500);
        }
    }

    public function show($id)
    {
        try {
            $cropRequirement = CropRequirement::find($id);
            return view('crop_requirement.show', compact('cropRequirement'));
        } catch (Exception $e) {

            $error = $e->getMessage();
            return $this->sendError('Internal server error.', $error, 500);
        }
    }

    public function edit($id)
    {
        try {
            $cropRequirement = CropRequirement::find($id);
            return view('crop_requirement.edit', compact('cropRequirement'));
        } catch (Exception $e) {

            $error = $e->getMessage();
            return $this->sendError('Internal server error.', $error, 500);
        }
    }

    public function update(CropRequirementRequest $request, $id)
    {
        try {
            // $cropRequirement = CropRequirement::find($id);
            // $cropRequirement->crop_id           = $request->crop;
            // $cropRequirement->soil_type_id      = $request->soil_type;
            // $cropRequirement->groth_stage_id    = $request->groth_stage;
            // $cropRequirement->water             = $request->water;
            // $cropRequirement->nitrogen          = $request->nitrogen;
            // $cropRequirement->potassium         = $request->potassium;
            // $cropRequirement->phosphorus        = $request->phosphorus;
            // $cropRequirement->save();


            // another way
            CropRequirement::updateOrCreate(
                [
                    'crop_id'           => $request->crop,
                    'soil_type_id'      => $request->soil_type,
                    'groth_stage_id'      => $request->groth_stage,
                ],
                [
                    'water'             => $request->water,
                    'nitrogen'             => $request->nitrogen,
                    'potassium'             => $request->potassium,
                    'phosphorus'             => $request->phosphorus,
                ]
            );

            Alert::success('Congrate', 'Crop Requirement updated successfully!');
            return redirect()->route('crop_requirements.create');
        } catch (Exception $e) {

            $error = $e->getMessage();
            return $this->sendError('Internal server error.', $error, 500);
        }
    }

    public function destroy($id)
    {
        try {
            CropRequirement::find($id)?->delete();

            Alert::success('Congrate', 'Crop Requirement deleted successfully!');
            return redirect()->route('crop_requirements.index');
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
