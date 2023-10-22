<?php

namespace App\Repositories;

use Exception;
use App\Models\User;
use App\Exports\UsersExport;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\BaseController;
use RealRashid\SweetAlert\Facades\Alert;
use App\Interfaces\UserRepositoryInterface;

class UserRepository extends BaseController implements UserRepositoryInterface
{
    public function index()
    {
        try {
            $users = User::orderBy('id', 'DESC')->where('status', '!=', null)->get();
            return view('user.index', ['users' => $users]);
        } catch (Exception $e) {

            $error = $e->getMessage();
            return $this->sendError('Internal server error.', $error, 500);
        }
    }

    public function getData($request)
    {
        try {
            // Define the default page and perPage values
            $perPage        = $request->input("length", 10);
            $searchValue    = $request->search['value'];
            $start          = $request->input("start");
            $orderBy        = 'id';
            $order          = 'desc';


            $usersQuery = User::query()
                ->when($searchValue, function ($query, $searchValue) {
                    $query->where(function ($query) use ($searchValue) {
                        $query->where('name', 'like', '%' . $searchValue . '%')
                            ->orWhere('email', 'like', '%' . $searchValue . '%');
                    });
                });

            $recordsFiltered = $usersQuery->count();


            if ($perPage != -1 && is_numeric($perPage)) {
                $usersQuery->offset($start)->limit($perPage);
            }

            $users = $usersQuery->orderBy($orderBy, $order)->get();
            $allUsers = array();
            foreach ($users as $user) {
                // $usersData = [$user->name, $user->email, $user->phone, $user->id, '', ''];
                $usersData = [$user->id, $user->name, $user->email, $user->phone, '', ''];
                array_push($allUsers, $usersData);
                $usersData = [''];
            }


            return ['data' => $allUsers, 'recordsTotal' => User::count(), 'recordsFiltered' => $recordsFiltered, 'status' => 200];
        } catch (Exception $e) {

            $error = $e->getMessage();
            return $this->sendError('Internal server error.', $error, 500);
        }
    }

    public function create()
    {
        try {
            return view('user.create');
        } catch (Exception $e) {

            $error = $e->getMessage();
            return $this->sendError('Internal server error.', $error, 500);
        }
    }

    public function store($request)
    {
        try {
            $user = new User();

            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->password = Hash::make($request->password);

            if ($request->file('profile_image')) {
                // Pass folder_name and file as param
                $path = uploadFile('users/profile_image', $request->file('profile_image'));
                $user->profile_image = $path;
            }
            $user->save();

            if ($request->user_role) {
                $user->assignRole($request->user_role);
            }

            Alert::success('Congrats', 'You\'ve Successfully Registered');
            return redirect()->route('users.index');
        } catch (Exception $e) {

            $error = $e->getMessage();
            return $this->sendError('Internal server error.', $error, 500);
        }
    }

    public function edit($id)
    {
        try {
            $user = User::with('roles')->findOrFail($id);
            return view('user.edit', compact('user'));
        } catch (Exception $e) {

            $error = $e->getMessage();
            return $this->sendError('Internal server error.', $error, 500);
        }
    }

    public function update($request, $id)
    {
        // dd($request->all());
        try {
            $user = User::findOrFail($id);

            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;

            if ($request->password) {
                $user->password = Hash::make($request->password);
            }
            if ($request->hasFile('profile_image')) {
                // Check if the category has a previous icon and unlink it
                if ($user->profile_image) {
                    Storage::disk('public')->delete($user->profile_image);
                }

                // Upload the new icon
                $path = uploadFile('users/profile_image', $request->file('profile_image'));

                // Update the category with the new icon path
                $user->profile_image = $path;
            }

            if ($request->user_role) {
                // Remove the previous role
                $user->removeRole($user->getRoleNames()->first());

                // Assign a new role
                $user->assignRole($request->user_role);
            }

            $user->save();

            Alert::success('Congrats', 'User updated successfully');
            return redirect()->route('users.index');
        } catch (Exception $e) {

            $error = $e->getMessage();
            return $this->sendError('Internal server error.', $error, 500);
        }
    }

    public function destroy($id)
    {
        try {
            User::find($id)?->delete();
            // Alert::success('Congrats', 'User Successfully Deleted');
            return true;
            // return redirect()->back();
        } catch (Exception $e) {

            $error = $e->getMessage();
            return $this->sendError('Internal server error.', $error, 500);
        }
    }

    public function loggedInUser()
    {
        try {
            $user = auth()->user();
            $roles = $user->getRoleNames();

            return $roles;
        } catch (Exception $e) {

            $error = $e->getMessage();
            return $this->sendError('Internal server error.', $error, 500);
        }
    }

    public function export()
    {
        try {
            return Excel::download(new UsersExport, 'users.xlsx');
        } catch (Exception $e) {

            $error = $e->getMessage();
            return $this->sendError('Internal server error.', $error, 500);
        }
    }
}
