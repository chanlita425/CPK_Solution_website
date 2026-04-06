<?php
// app/Http/Controllers/Admin/SettingController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::first();
        if (!$settings) {
            $settings = Setting::create([
                'company_name' => 'CPK Solution',
                'shipping_fee' => 5.00,
                'tax_percent' => 10.00,
            ]);
        }
        // FIXED: Changed from 'admin.settings.index' to 'admin.pages.settings.index'
        return view('admin.pages.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $settings = Setting::first();

        $request->validate([
            'company_name' => 'nullable|string|max:255',
            'company_url' => 'nullable|url',
            'company_phone_number_first' => 'nullable|string',
            'company_phone_number_second' => 'nullable|string',
            'about_company' => 'nullable|string',
            'facebook_link' => 'nullable|url',
            'telegram_link' => 'nullable|url',
            'tiktok_link' => 'nullable|url',
            'instagram_link' => 'nullable|url',
            'shipping_fee' => 'required|numeric|min:0',
            'tax_percent' => 'required|numeric|min:0|max:100',
            'seller_telegram' => 'nullable|string',
            'company_logo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'hero_banner_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'promotion_banner_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->except(['company_logo', 'hero_banner_image', 'promotion_banner_image', '_token', '_method']);

        if ($request->hasFile('company_logo')) {
            if ($settings->company_logo && Storage::disk('public')->exists($settings->company_logo)) {
                Storage::disk('public')->delete($settings->company_logo);
            }
            $data['company_logo'] = $request->file('company_logo')->store('settings', 'public');
        }

        if ($request->hasFile('hero_banner_image')) {
            if ($settings->hero_banner_image && Storage::disk('public')->exists($settings->hero_banner_image)) {
                Storage::disk('public')->delete($settings->hero_banner_image);
            }
            $data['hero_banner_image'] = $request->file('hero_banner_image')->store('settings', 'public');
        }

        if ($request->hasFile('promotion_banner_image')) {
            if ($settings->promotion_banner_image && Storage::disk('public')->exists($settings->promotion_banner_image)) {
                Storage::disk('public')->delete($settings->promotion_banner_image);
            }
            $data['promotion_banner_image'] = $request->file('promotion_banner_image')->store('settings', 'public');
        }

        $settings->update($data);

        return redirect()->route('admin.settings.index')
            ->with('success', 'Settings updated successfully!');
    }
}
