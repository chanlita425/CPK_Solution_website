<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class SettingController extends Controller
{
    // Profile Settings
    public function profile()
    {
        $admin = Auth::guard('admin')->user();
        return view('admin.pages.settings.profile', compact('admin'));
    }

    public function updateProfile(Request $request)
    {
        $admin = Auth::guard('admin')->user();
        $adminId = $admin->id;

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:admins,email,' . $adminId,
            'current_password' => 'nullable|required_with:new_password',
            'new_password' => 'nullable|min:6|confirmed',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        // Update password
        if ($request->filled('current_password')) {
            if (!Hash::check($request->current_password, $admin->password)) {
                return back()->withErrors(['current_password' => 'Current password is incorrect']);
            }
            $data['password'] = Hash::make($request->new_password);
        }

        DB::table('admins')->where('id', $adminId)->update($data);

        return redirect()->route('admin.settings.profile')
            ->with('success', 'Profile updated successfully');
    }

    // System Settings
    public function system()
    {
        $settings = Setting::getGroup('system');
        return view('admin.pages.settings.system', compact('settings'));
    }

    public function updateSystem(Request $request)
    {
        $request->validate([
            'website_url' => 'nullable|string|max:255',
            'navbar_logo' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
            'phone_1' => 'nullable|string|max:50',
            'phone_2' => 'nullable|string|max:50',
            'facebook_url' => 'nullable|url|max:255',
            'tiktok_url' => 'nullable|url|max:255',
            'instagram_url' => 'nullable|url|max:255',
            'telegram_url' => 'nullable|url|max:255',
        ]);

        // Update website URL
        Setting::set('website_url', $request->website_url, 'text', 'system');

        // Update navbar logo
        if ($request->hasFile('navbar_logo')) {
            $oldLogo = Setting::get('navbar_logo');
            if ($oldLogo && Storage::disk('public')->exists($oldLogo)) {
                Storage::disk('public')->delete($oldLogo);
            }
            $logoPath = $request->file('navbar_logo')->store('settings', 'public');
            Setting::set('navbar_logo', $logoPath, 'image', 'system');
        }

        // Update phone numbers
        Setting::set('phone_1', $request->phone_1, 'text', 'system');
        Setting::set('phone_2', $request->phone_2, 'text', 'system');

        // Update social media links
        Setting::set('facebook_url', $request->facebook_url, 'text', 'system');
        Setting::set('tiktok_url', $request->tiktok_url, 'text', 'system');
        Setting::set('instagram_url', $request->instagram_url, 'text', 'system');
        Setting::set('telegram_url', $request->telegram_url, 'text', 'system');

        return redirect()->route('admin.settings.system')
            ->with('success', 'Settings updated successfully');
    }
}
