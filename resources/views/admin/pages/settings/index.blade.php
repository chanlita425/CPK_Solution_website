{{-- resources/views/admin/pages/settings/index.blade.php --}}
@extends('admin.layouts.app')

@section('title', 'Settings')
@section('header', 'System Settings')
@section('subheader', 'Configure your store settings')

@section('content')
    @if ($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-800 rounded-lg p-4 mb-6">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="space-y-6">
            <!-- Company Information Section -->
            <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-[#D7B259]/10 rounded-xl flex items-center justify-center">
                            <i class="fas fa-building text-[#D7B259] text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800">Company Information</h3>
                            <p class="text-sm text-gray-500">Your business details and contact information</p>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Company Name</label>
                            <input type="text" name="company_name"
                                value="{{ old('company_name', $settings->company_name) }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#D7B259] focus:border-transparent"
                                placeholder="Your Company Name">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Company URL</label>
                            <input type="text" name="company_url"
                                value="{{ old('company_url', $settings->company_url) }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#D7B259] focus:border-transparent"
                                placeholder="www.example.com">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Phone Number (Primary)</label>
                            <input type="text" name="company_phone_number_first"
                                value="{{ old('company_phone_number_first', $settings->company_phone_number_first) }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#D7B259] focus:border-transparent"
                                placeholder="+855 XX XXX XXX">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Phone Number (Secondary)</label>
                            <input type="text" name="company_phone_number_second"
                                value="{{ old('company_phone_number_second', $settings->company_phone_number_second) }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#D7B259] focus:border-transparent"
                                placeholder="+855 XX XXX XXX">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">About Company</label>
                            <textarea name="about_company" rows="4"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#D7B259] focus:border-transparent"
                                placeholder="Tell customers about your company...">{{ old('about_company', $settings->about_company) }}</textarea>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Company Logo</label>
                            @if ($settings->company_logo)
                                <div class="mb-3">
                                    <img src="{{ asset('storage/' . $settings->company_logo) }}"
                                        class="w-24 h-24 object-cover rounded-lg border">
                                </div>
                            @endif
                            <input type="file" name="company_logo" accept="image/*"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#D7B259] focus:border-transparent">
                            <p class="text-xs text-gray-500 mt-1">PNG, JPG up to 2MB. Recommended size: 200x200px</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- NEW: Popup Banner & Favicon Section -->
            <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-[#D7B259]/10 rounded-xl flex items-center justify-center">
                            <i class="fas fa-image text-[#D7B259] text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800">Popup Banner & Favicon</h3>
                            <p class="text-sm text-gray-500">Configure popup banner and website favicon</p>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Popup Banner Image -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Popup Banner Image</label>
                            @if ($settings->popup_banner_image)
                                <div class="mb-3">
                                    <img src="{{ asset('storage/' . $settings->popup_banner_image) }}"
                                        class="w-full max-w-md h-32 object-cover rounded-lg border">
                                    <p class="text-xs text-gray-500 mt-1">Current popup banner</p>
                                </div>
                            @endif
                            <input type="file" name="popup_banner_image" accept="image/*"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#D7B259] focus:border-transparent">
                            <p class="text-xs text-gray-500 mt-1">Recommended size: 600x400px. Formats: JPEG, PNG, JPG, WEBP (Max 2MB)</p>
                        </div>

                        <!-- Favicon -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Favicon</label>
                            @if ($settings->favicon)
                                <div class="mb-3">
                                    <img src="{{ asset('storage/' . $settings->favicon) }}"
                                        class="w-16 h-16 object-cover rounded-lg border">
                                    <p class="text-xs text-gray-500 mt-1">Current favicon</p>
                                </div>
                            @endif
                            <input type="file" name="favicon" accept="image/*"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#D7B259] focus:border-transparent">
                            <p class="text-xs text-gray-500 mt-1">Recommended size: 32x32px or 16x16px. Formats: ICO, PNG, JPG, SVG, WEBP (Max 1MB)</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Store Settings Section -->
            <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-[#D7B259]/10 rounded-xl flex items-center justify-center">
                            <i class="fas fa-store text-[#D7B259] text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800">Store Settings</h3>
                            <p class="text-sm text-gray-500">Configure shipping, tax, and order notifications</p>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Shipping Fee ($)</label>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500">$</span>
                                <input type="number" name="shipping_fee"
                                    value="{{ old('shipping_fee', $settings->shipping_fee) }}" step="0.01" required
                                    class="w-full pl-8 pr-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#D7B259] focus:border-transparent">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tax Percentage (%)</label>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500">%</span>
                                <input type="number" name="tax_percent"
                                    value="{{ old('tax_percent', $settings->tax_percent) }}" step="0.01" required
                                    class="w-full pl-8 pr-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#D7B259] focus:border-transparent">
                            </div>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Seller Telegram (for order notifications)</label>
                            <div class="relative">
                                <i class="fab fa-telegram absolute left-3 top-1/2 -translate-y-1/2 text-[#0088cc]"></i>
                                <input type="text" name="seller_telegram"
                                    value="{{ old('seller_telegram', $settings->seller_telegram) }}"
                                    class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#D7B259] focus:border-transparent"
                                    placeholder="@username or phone number">
                            </div>
                            <p class="text-xs text-gray-500 mt-1">Orders will be sent to this Telegram account</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Social Media Links Section -->
            <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-[#D7B259]/10 rounded-xl flex items-center justify-center">
                            <i class="fas fa-share-alt text-[#D7B259] text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800">Social Media Links</h3>
                            <p class="text-sm text-gray-500">Connect your social media accounts</p>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2"><i
                                    class="fab fa-facebook text-blue-600 mr-2"></i> Facebook</label>
                            <input type="url" name="facebook_link"
                                value="{{ old('facebook_link', $settings->facebook_link) }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#D7B259] focus:border-transparent"
                                placeholder="https://facebook.com/yourpage">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2"><i
                                    class="fab fa-telegram text-[#0088cc] mr-2"></i> Telegram</label>
                            <input type="url" name="telegram_link"
                                value="{{ old('telegram_link', $settings->telegram_link) }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#D7B259] focus:border-transparent"
                                placeholder="https://t.me/yourchannel">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2"><i
                                    class="fab fa-tiktok text-black mr-2"></i> TikTok</label>
                            <input type="url" name="tiktok_link"
                                value="{{ old('tiktok_link', $settings->tiktok_link) }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#D7B259] focus:border-transparent"
                                placeholder="https://tiktok.com/@yourpage">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2"><i
                                    class="fab fa-instagram text-pink-600 mr-2"></i> Instagram</label>
                            <input type="url" name="instagram_link"
                                value="{{ old('instagram_link', $settings->instagram_link) }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#D7B259] focus:border-transparent"
                                placeholder="https://instagram.com/yourpage">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Banner Images Section -->
            <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-[#D7B259]/10 rounded-xl flex items-center justify-center">
                            <i class="fas fa-image text-[#D7B259] text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800">Banner Images</h3>
                            <p class="text-sm text-gray-500">Main banners displayed on the homepage</p>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Hero Banner Image</label>
                            @if ($settings->hero_banner_image)
                                <div class="mb-3">
                                    <img src="{{ asset('storage/' . $settings->hero_banner_image) }}"
                                        class="w-full max-w-md h-32 object-cover rounded-lg border">
                                </div>
                            @endif
                            <input type="file" name="hero_banner_image" accept="image/*"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#D7B259] focus:border-transparent">
                            <p class="text-xs text-gray-500 mt-1">Recommended size: 1920x600px</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Promotion Banner Image</label>
                            @if ($settings->promotion_banner_image)
                                <div class="mb-3">
                                    <img src="{{ asset('storage/' . $settings->promotion_banner_image) }}"
                                        class="w-full max-w-md h-32 object-cover rounded-lg border">
                                </div>
                            @endif
                            <input type="file" name="promotion_banner_image" accept="image/*"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#D7B259] focus:border-transparent">
                            <p class="text-xs text-gray-500 mt-1">Recommended size: 1200x400px</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end">
                <button type="submit"
                    class="px-6 py-2.5 bg-[#D7B259] hover:bg-[#c4a145] text-gray-900 rounded-lg transition font-medium">
                    <i class="fas fa-save mr-2"></i> Save All Settings
                </button>
            </div>
        </div>
    </form>
@endsection
