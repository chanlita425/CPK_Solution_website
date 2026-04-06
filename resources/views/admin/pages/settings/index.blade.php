{{-- resources/views/admin/settings/index.blade.php --}}
@extends('admin.layouts.app')

@section('title', 'Settings')
@section('header', 'System Settings')

@section('content')
    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-4">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data"
        class="bg-white rounded-xl shadow-sm overflow-hidden">
        @csrf
        @method('PUT')

        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Company Information -->
                <div class="md:col-span-2">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 pb-2 border-b">Company Information</h3>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Company Name</label>
                    <input type="text" name="company_name" value="{{ old('company_name', $settings->company_name) }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-yellow-500 focus:border-yellow-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Company URL</label>
                    <input type="url" name="company_url" value="{{ old('company_url', $settings->company_url) }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-yellow-500 focus:border-yellow-500"
                        placeholder="https://example.com">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Phone Number (Primary)</label>
                    <input type="text" name="company_phone_number_first"
                        value="{{ old('company_phone_number_first', $settings->company_phone_number_first) }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-yellow-500 focus:border-yellow-500"
                        placeholder="+855 XX XXX XXX">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Phone Number (Secondary)</label>
                    <input type="text" name="company_phone_number_second"
                        value="{{ old('company_phone_number_second', $settings->company_phone_number_second) }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-yellow-500 focus:border-yellow-500"
                        placeholder="+855 XX XXX XXX">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">About Company</label>
                    <textarea name="about_company" rows="4"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-yellow-500 focus:border-yellow-500">{{ old('about_company', $settings->about_company) }}</textarea>
                </div>

                <!-- Company Logo -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Company Logo</label>
                    @if ($settings->company_logo)
                        <div class="mb-3">
                            <img src="{{ asset('storage/' . $settings->company_logo) }}"
                                class="w-32 h-32 object-cover rounded-lg border">
                        </div>
                    @endif
                    <input type="file" name="company_logo" accept="image/*" class="w-full">
                    <p class="text-xs text-gray-500 mt-1">PNG, JPG up to 2MB</p>
                </div>

                <!-- Social Media Links -->
                <div class="md:col-span-2">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 pt-4 pb-2 border-b">Social Media Links</h3>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2"><i
                            class="fab fa-facebook text-blue-600 mr-2"></i> Facebook</label>
                    <input type="url" name="facebook_link" value="{{ old('facebook_link', $settings->facebook_link) }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-yellow-500 focus:border-yellow-500"
                        placeholder="https://facebook.com/yourpage">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2"><i
                            class="fab fa-telegram text-blue-500 mr-2"></i> Telegram</label>
                    <input type="url" name="telegram_link" value="{{ old('telegram_link', $settings->telegram_link) }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-yellow-500 focus:border-yellow-500"
                        placeholder="https://t.me/yourchannel">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2"><i
                            class="fab fa-tiktok text-black mr-2"></i> TikTok</label>
                    <input type="url" name="tiktok_link" value="{{ old('tiktok_link', $settings->tiktok_link) }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-yellow-500 focus:border-yellow-500"
                        placeholder="https://tiktok.com/@yourpage">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2"><i
                            class="fab fa-instagram text-pink-600 mr-2"></i> Instagram</label>
                    <input type="url" name="instagram_link"
                        value="{{ old('instagram_link', $settings->instagram_link) }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-yellow-500 focus:border-yellow-500"
                        placeholder="https://instagram.com/yourpage">
                </div>

                <!-- Store Settings -->
                <div class="md:col-span-2">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 pt-4 pb-2 border-b">Store Settings</h3>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Shipping Fee ($)</label>
                    <input type="number" name="shipping_fee" value="{{ old('shipping_fee', $settings->shipping_fee) }}"
                        step="0.01" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-yellow-500 focus:border-yellow-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tax Percentage (%)</label>
                    <input type="number" name="tax_percent" value="{{ old('tax_percent', $settings->tax_percent) }}"
                        step="0.01" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-yellow-500 focus:border-yellow-500">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Seller Telegram (for order
                        notifications)</label>
                    <input type="text" name="seller_telegram"
                        value="{{ old('seller_telegram', $settings->seller_telegram) }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-yellow-500 focus:border-yellow-500"
                        placeholder="@username or phone number">
                    <p class="text-xs text-gray-500 mt-1">Orders will be sent to this Telegram account</p>
                </div>

                <!-- Banner Images -->
                <div class="md:col-span-2">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 pt-4 pb-2 border-b">Banner Images</h3>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Hero Banner Image</label>
                    @if ($settings->hero_banner_image)
                        <div class="mb-3">
                            <img src="{{ asset('storage/' . $settings->hero_banner_image) }}"
                                class="w-full max-w-md h-32 object-cover rounded-lg border">
                        </div>
                    @endif
                    <input type="file" name="hero_banner_image" accept="image/*" class="w-full">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Promotion Banner Image</label>
                    @if ($settings->promotion_banner_image)
                        <div class="mb-3">
                            <img src="{{ asset('storage/' . $settings->promotion_banner_image) }}"
                                class="w-full max-w-md h-32 object-cover rounded-lg border">
                        </div>
                    @endif
                    <input type="file" name="promotion_banner_image" accept="image/*" class="w-full">
                </div>
            </div>
        </div>

        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-end">
            <button type="submit"
                class="px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-gray-900 rounded-lg transition">Save
                Settings</button>
        </div>
    </form>
@endsection
