<?php

namespace App\Services;

use Exception;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BaseController;
use Laravel\Socialite\Facades\Socialite;

class GoogleService extends BaseController
{
    public function redirectToGoogle()
    {
        try {
            return Socialite::driver('google')->redirect();
        } catch (Exception $e) {

            $error = $e->getMessage();
            return $this->sendError('Internal server error.', $error, 500);
        }
    }

    public function handleGoogleCallback()
    {
        try {

            $user = Socialite::driver('google')->user();
            $finduser = User::where('google_id', $user->id)->first();

            if ($finduser) {

                Auth::login($finduser);
            } else {
                $newUser = User::updateOrCreate(
                    ['email' => $user->email],
                    [
                        'name' => $user->name,
                        'google_id' => $user->id,
                        'password' => encrypt('password')
                    ]
                );

                // Assign role for the user
                $newUser->assignRole('employee');
                Auth::login($newUser);
            }

            return redirect()->route('auth.dashboard');
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
}
