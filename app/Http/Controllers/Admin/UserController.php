<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User; // Import the User model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Import the Auth facade

class UserController extends Controller
{
     /**
     * Display a listing of all users.
     */
    public function index()
    {
        // Fetch all users, ordered by name, and paginate
        $users = User::orderBy('name')->paginate(15);

        return view('admin.users.index', compact('users'));
    }

    /**
     * Toggle the admin status of a user.
     */
    public function toggleAdmin(User $user)
    {
        // Prevent an admin from revoking their own admin status
        if ($user->id === Auth::id()) {
            return redirect()->route('admin.users.index')->with('error', 'You cannot revoke your own admin status.');
        }

        // Flip the boolean value of is_admin
        $user->is_admin = !$user->is_admin;
        $user->save();

        $message = $user->is_admin ? "{$user->name} is now an admin." : "{$user->name} is no longer an admin.";

        return redirect()->route('admin.users.index')->with('success', $message);
    }
}
