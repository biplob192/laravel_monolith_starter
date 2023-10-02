<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\CropRequirementRequest;

class TestController extends Controller
{
    public function create()
    {
        // Fetch the growth stages data from your database or any other source.
        $crops = User::limit(10)->get(); // Assuming you have a GrowthStage model.

        // Pass the growth stages data to your view.
        return view('groth_stage.create', compact('crops'));
        return view('your.blade.view', compact('growthStages'));
    }

    public function store(CropRequirementRequest $request)
    {
        dd($request->all());

        // Validate the request data
        $validatedData = $request->validate([
            'crop' => 'required',
            'soil_type' => 'required',
            // Add validation rules for other fields in the main form
        ]);

        // Create a new user record with data from the main form
        $user = new User;
        $user->crop = $validatedData['crop'];
        $user->soil_type = $validatedData['soil_type'];
        // Set other fields from the main form

        // Save the user
        $user->save();

        // Handle sections
        $sections = $request->input('sections');
        foreach ($sections as $sectionData) {
            // Validate section data if needed
            // Create a new section record and associate it with the user
            $section = new Section;
            $section->user_id = $user->id; // Assuming a user_id foreign key
            $section->groth_stage = $sectionData['groth_stage'];
            $section->water = $sectionData['water'];
            $section->nitrogen = $sectionData['nitrogen'];
            $section->potassium = $sectionData['potassium'];
            $section->phosphorus = $sectionData['phosphorus'];

            // Save the section
            $section->save();
        }

        // Redirect or respond with a success message
        return redirect()->route('users.index')->with('success', 'User created successfully');
    }

    public function userList()
    {
        $users = User::limit(10)->get();
        return $users;
        dd(gettype($users));

        // Redirect or respond with a success message
        return redirect()->route('users.index')->with('success', 'User created successfully');
    }
}
