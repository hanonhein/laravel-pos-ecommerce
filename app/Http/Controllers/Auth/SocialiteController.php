<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;


class SocialiteController extends Controller
{
    /**
     * Redirect the user to the Google authentication page.
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Obtain the user information from Google.
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            // First, check if a user with this email already exists
            $user = User::where('email', $googleUser->email)->first();

            if ($user) {
                // If the user exists, update their google_id and log them in
                $user->update(['google_id' => $googleUser->id]);
            } else {
                // If the user does not exist, create a new one
                $user = User::create([
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'google_id' => $googleUser->id,
                    'password' => Hash::make(uniqid()), // Create a random, secure password
                ]);
            }

            // Log the user in
            Auth::login($user);

            // Redirect to the homepage
            return redirect()->route('home');

        } catch (\Exception $e) {
            // If something goes wrong, redirect to the login page with an error
            return redirect()->route('login')->with('error', 'Unable to login using Google. Please try again.');
        }
    }
}
