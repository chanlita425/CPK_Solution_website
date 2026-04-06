<?php
// app/Http/Controllers/Admin/ProfileController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    private function getAuthAdmin(): User
    {
        /** @var User */
        return Auth::user();
    }

    public function index()
    {
        $admin = $this->getAuthAdmin();
        return view('admin.pages.profile.index', compact('admin'));
    }

    public function updateProfile(Request $request)
    {
        $admin = $this->getAuthAdmin();

        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $admin->id,
        ]);

        $admin->update([
            'name'  => $request->name,
            'email' => $request->email,
        ]);

        return redirect()->route('admin.profile.index')
            ->with('success', 'Profile updated successfully!');
    }

    public function updatePassword(Request $request)
    {
        $admin = $this->getAuthAdmin();

        $request->validate([
            'current_password' => 'required|current_password',
            'password'         => ['required', 'confirmed', Password::min(8)],
        ]);

        $admin->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admin.profile.index')
            ->with('success', 'Password changed successfully!');
    }
}
