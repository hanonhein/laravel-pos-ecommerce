<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\MagicLoginCode;

class MagicLinkController extends Controller
{
    /**
     * Show the form to request a magic login code.
     */
    public function showLinkRequestForm()
    {
        return view('auth.magic-link-request');
    }

    /**
     * Send the magic login code to the user.
     */
    public function sendLink(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);
        $user = User::where('email', $request->email)->first();

        // Generate a 6-digit random code
        $code = random_int(100000, 999999);

        // Save the code (as the token) and an expiry date to the user
        $user->update([
            'login_token' => (string) $code,
            'login_token_expires_at' => now()->addMinutes(15),
        ]);

        // Send the email with the code
        Mail::to($user->email)->send(new MagicLoginCode($user, $code));

        // Redirect to the new verification page, passing the email along
        return redirect()->route('magic-link.verify.form', ['email' => $user->email]);
    }

    /**
     * Show the form to enter the magic code.
     */
    public function showVerifyForm(Request $request)
    {
        return view('auth.magic-link-verify', ['email' => $request->email]);
    }

    /**
     * Log the user in using the magic code.
     */
    public function loginWithToken(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'token' => 'required|numeric|digits:6',
        ]);

        // --- Start of new, detailed logging ---
        Log::debug('--- Magic Code Login Attempt ---');
        Log::debug('Request Email: ' . $request->email);
        Log::debug('Request Token: ' . $request->token);
        Log::debug('Current App Time: ' . now());

        // Find the user by email ONLY first, so we can inspect their data.
        $userInDb = User::where('email', $request->email)->first();

        if ($userInDb) {
            Log::debug('User found by email in DB.');
            Log::debug('Token in DB: "' . $userInDb->login_token . '" (Type: ' . gettype($userInDb->login_token) . ')');
            Log::debug('Token from Request: "' . $request->token . '" (Type: ' . gettype($request->token) . ')');
            Log::debug('Token Expires At (DB): ' . $userInDb->login_token_expires_at);
            if ($userInDb->login_token_expires_at) {
                 Log::debug('Is token expired? ' . (now()->gt($userInDb->login_token_expires_at) ? 'Yes' : 'No'));
            }
        } else {
            Log::debug('User NOT found by email in DB.');
        }
        // --- End of new, detailed logging ---

        $user = User::where('email', $request->email)
                    ->where('login_token', $request->token)
                    ->first();

        if (!$user || ($user->login_token_expires_at && now()->gt($user->login_token_expires_at))) {
             return back()->withErrors(['token' => 'The code is invalid or has expired.']);
        }

        Auth::login($user);

        $user->update([
            'login_token' => null,
            'login_token_expires_at' => null,
        ]);

        return redirect()->route('home');
    }
}
