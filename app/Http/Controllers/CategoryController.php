<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\CategoryRequest;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\BaseController;
use RealRashid\SweetAlert\Facades\Alert;

class CategoryController extends BaseController
{
    public function index()
    {
        try {
            return view('crop_category.index');
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


            $usersQuery = Category::query()
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
                $singleData = [$data->id,$data->icon, $data->name, '', ''];
                array_push($finalDataSet, $singleData);
                $singleData = [''];
            }


            return ['data' => $finalDataSet, 'recordsTotal' => Category::count(), 'recordsFiltered' => $recordsFiltered, 'status' => 200];
        } catch (Exception $e) {

            $error = $e->getMessage();
            return $this->sendError('Internal server error.', $error, 500);
        }
    }

    public function create()
    {
        try {
            return view('crop_category.create');
        } catch (Exception $e) {

            $error = $e->getMessage();
            return $this->sendError('Internal server error.', $error, 500);
        }
    }

    public function store(CategoryRequest $request)
    {
        try {
            $category = new Category();
            $category->name = $request->name;

            if ($request->file('icon')) {
                // Pass folder_name and file as param
                $path = uploadFile('category_icons', $request->file('icon'));
                $category->icon = $path;
            }
            $category->save();

            Alert::success('Congrate', 'Crop category created successfully!');
            return redirect()->route('categories.create');
        } catch (Exception $e) {

            $error = $e->getMessage();
            return $this->sendError('Internal server error.', $error, 500);
        }
    }

    public function show($id)
    {
        try {
            $category = Category::find($id);
            return view('crop_category.show', compact('category'));
        } catch (Exception $e) {

            $error = $e->getMessage();
            return $this->sendError('Internal server error.', $error, 500);
        }
    }

    public function edit($id)
    {
        try {
            $category = Category::find($id);
            return view('crop_category.edit', compact('category'));
        } catch (Exception $e) {

            $error = $e->getMessage();
            return $this->sendError('Internal server error.', $error, 500);
        }
    }

    public function update(CategoryRequest $request, $id)
    {
        try {
            $category = Category::find($id);
            $category->name = $request->name;

            if ($request->hasFile('icon')) {
                // Check if the category has a previous icon and unlink it
                if ($category->icon) {
                    Storage::disk('public')->delete($category->icon);
                }

                // Upload the new icon
                $newIconPath = uploadFile('category_icons', $request->file('icon'));

                // Update the category with the new icon path
                $category->icon = $newIconPath;
            }
            $category->save();

            Alert::success('Congrate', 'Crop category updated successfully!');
            return redirect()->route('categories.index');
        } catch (Exception $e) {

            $error = $e->getMessage();
            return $this->sendError('Internal server error.', $error, 500);
        }
    }

    public function destroy($id)
    {
        try {
            if ($category = Category::find($id)) {
                if ($category->icon) {
                    Storage::disk('public')->delete($category->icon);
                }

                $category->delete();
            }
            return true;

            Alert::success('Congrate', 'Crop category deleted successfully!');
            return redirect()->route('categories.index');
        } catch (Exception $e) {

            $error = $e->getMessage();
            return $this->sendError('Internal server error.', $error, 500);
        }
    }
}
