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
        return view('admin.pages.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $settings = Setting::first();

        // Validation rules
        $rules = [
            'company_name' => 'nullable|string|max:255',
            'company_url' => 'nullable|string|max:255|regex:/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/i',
            'company_phone_number_first' => 'nullable|string|max:20',
            'company_phone_number_second' => 'nullable|string|max:20',
            'about_company' => 'nullable|string',
            'facebook_link' => 'nullable|url|max:255',
            'telegram_link' => 'nullable|url|max:255',
            'tiktok_link' => 'nullable|url|max:255',
            'instagram_link' => 'nullable|url|max:255',
            'shipping_fee' => 'required|numeric|min:0',
            'tax_percent' => 'required|numeric|min:0|max:100',
            'seller_telegram' => 'nullable|string|max:255',
            'company_logo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'hero_banner_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'promotion_banner_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'popup_banner_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'favicon' => 'nullable|image|mimes:jpeg,png,jpg,ico,svg,webp|max:1024',
        ];

        $messages = [
            'company_url.regex' => 'Please enter a valid URL (e.g., www.cpksolution.com or https://cpksolution.com)',
            'facebook_link.url' => 'Please enter a valid Facebook URL',
            'telegram_link.url' => 'Please enter a valid Telegram URL',
            'tiktok_link.url' => 'Please enter a valid TikTok URL',
            'instagram_link.url' => 'Please enter a valid Instagram URL',
            'popup_banner_image.image' => 'Please upload a valid image file for popup banner',
            'popup_banner_image.max' => 'Popup banner image size must not exceed 2MB',
            'favicon.image' => 'Please upload a valid image file for favicon',
            'favicon.max' => 'Favicon image size must not exceed 1MB',
        ];

        $validated = $request->validate($rules, $messages);

        // Prepare data for update (exclude file inputs)
        $data = $request->except([
            'company_logo',
            'hero_banner_image',
            'promotion_banner_image',
            'popup_banner_image',
            'favicon',
            '_token',
            '_method'
        ]);

        // Process company_url - add https:// if missing
        if ($request->filled('company_url')) {
            $url = trim($request->company_url);
            $url = str_replace(' ', '', $url);
            if (!preg_match('/^https?:\/\//i', $url)) {
                $url = 'https://' . $url;
            }
            $data['company_url'] = $url;
        }

        // Handle Company Logo Upload
        if ($request->hasFile('company_logo')) {
            if ($settings->company_logo && Storage::disk('public')->exists($settings->company_logo)) {
                Storage::disk('public')->delete($settings->company_logo);
            }
            $data['company_logo'] = $request->file('company_logo')->store('settings', 'public');
        }

        // Handle Hero Banner Upload
        if ($request->hasFile('hero_banner_image')) {
            if ($settings->hero_banner_image && Storage::disk('public')->exists($settings->hero_banner_image)) {
                Storage::disk('public')->delete($settings->hero_banner_image);
            }
            $data['hero_banner_image'] = $request->file('hero_banner_image')->store('settings', 'public');
        }

        // Handle Promotion Banner Upload
        if ($request->hasFile('promotion_banner_image')) {
            if ($settings->promotion_banner_image && Storage::disk('public')->exists($settings->promotion_banner_image)) {
                Storage::disk('public')->delete($settings->promotion_banner_image);
            }
            $data['promotion_banner_image'] = $request->file('promotion_banner_image')->store('settings', 'public');
        }

        // NEW: Handle Popup Banner Upload
        if ($request->hasFile('popup_banner_image')) {
            // Delete old image if exists
            if ($settings->popup_banner_image && Storage::disk('public')->exists($settings->popup_banner_image)) {
                Storage::disk('public')->delete($settings->popup_banner_image);
            }
            // Store new image
            $data['popup_banner_image'] = $request->file('popup_banner_image')->store('settings', 'public');
        }

        // NEW: Handle Favicon Upload
        if ($request->hasFile('favicon')) {
            // Delete old favicon if exists
            if ($settings->favicon && Storage::disk('public')->exists($settings->favicon)) {
                Storage::disk('public')->delete($settings->favicon);
            }
            // Store new favicon
            $data['favicon'] = $request->file('favicon')->store('settings', 'public');
        }

        // Update settings
        $settings->update($data);

        return redirect()->route('admin.settings.index')
            ->with('toast', ['message' => 'Settings updated successfully!', 'type' => 'success']);
    }
}
