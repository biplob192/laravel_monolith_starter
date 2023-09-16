<?php

namespace App\Repositories;

use Exception;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\BaseController;
use RealRashid\SweetAlert\Facades\Alert;
use App\Interfaces\AuthRepositoryInterface;

class AuthRepository extends BaseController implements AuthRepositoryInterface
{
    public function loginView()
    {
        try {
            if (Auth::check()) {
                return redirect()->route('auth.dashboard');
            }

            return view('auth.login');
        } catch (Exception $e) {

            $error = $e->getMessage();
            return $this->sendError('Internal server error.', $error, 500);
        }
    }

    public function loginViewNew()
    {
        try {
            if (Auth::check()) {
                return redirect()->route('auth.dashboard');
            }

            return view('login');
        } catch (Exception $e) {

            $error = $e->getMessage();
            return $this->sendError('Internal server error.', $error, 500);
        }
    }

    public function login($request)
    {
        try {
            $credentials = $request->only('email', 'password');

            if (Auth::attempt($credentials)) {
                return redirect()->route('auth.dashboard');
            } else {
                return back()->with("error", "Invalide credential");
            }
        } catch (Exception $e) {

            $error = $e->getMessage();
            return $this->sendError('Internal server error.', $error, 500);
        }
    }

    public function registerView()
    {
        try {
            if (Auth::check()) {
                return redirect()->route('auth.dashboard');
            }

            return view('auth.register');
        } catch (Exception $e) {

            $error = $e->getMessage();
            return $this->sendError('Internal server error.', $error, 500);
        }
    }

    public function register($request)
    {
        try {
            $user = new User();

            $user->name         = $request->name;
            $user->email        = $request->email;
            $user->phone        = $request->phone;
            $user->password     = Hash::make($request->password);
            $user->save();

            // Assign role for the user
            $user->assignRole('employee');


            Alert::success('Congrate', 'Registration successfull!');
            Auth::login($user);

            return redirect()->route('auth.dashboard');
        } catch (Exception $e) {

            $error = $e->getMessage();
            return $this->sendError('Internal server error.', $error, 500);
        }
    }

    public function dashboard()
    {
        try {
            if (Auth::check()) {
                return view('dashboard');
            }
            return redirect()->route('auth.login_view');
        } catch (Exception $e) {

            $error = $e->getMessage();
            return $this->sendError('Internal server error.', $error, 500);
        }
    }

    public function home()
    {
        try {
            if (Auth::check()) {
                return redirect()->route('auth.dashboard');
            }
            return view('auth.login');
        } catch (Exception $e) {

            $error = $e->getMessage();
            return $this->sendError('Internal server error.', $error, 500);
        }
    }

    public function logout()
    {
        try {
            Auth::logout();
            return redirect()->route('auth.home');
        } catch (Exception $e) {

            $error = $e->getMessage();
            return $this->sendError('Internal server error.', $error, 500);
        }
    }
}
