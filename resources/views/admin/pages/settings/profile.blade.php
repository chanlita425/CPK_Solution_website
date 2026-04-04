@extends('admin.layouts.app')

@section('title', 'Profile Settings')
@section('header', 'Profile Settings')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Profile Information -->
    <div class="lg:col-span-2">
        <div class="admin-card p-6">
            <h3 class="text-lg font-semibold mb-4">Profile Information</h3>

            @if(session('success'))
                <div class="admin-alert-success mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('admin.settings.profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="space-y-4">
                    <div>
                        <label class="admin-form-label">Full Name *</label>
                        <input type="text" name="name" class="admin-form-input" value="{{ old('name', $admin->name) }}" required>
                        @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="admin-form-label">Email Address *</label>
                        <input type="email" name="email" class="admin-form-input" value="{{ old('email', $admin->email) }}" required>
                        @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="border-t pt-4 mt-4">
                        <h4 class="font-semibold mb-3">Change Password</h4>
                        <div class="space-y-3">
                            <div>
                                <label class="admin-form-label">Current Password</label>
                                <input type="password" name="current_password" class="admin-form-input">
                                @error('current_password') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="admin-form-label">New Password</label>
                                <input type="password" name="new_password" class="admin-form-input">
                                @error('new_password') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="admin-form-label">Confirm New Password</label>
                                <input type="password" name="new_password_confirmation" class="admin-form-input">
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="btn-admin-primary">
                            <i class="fas fa-save mr-2"></i> Update Profile
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Account Statistics Card -->
    <div class="lg:col-span-1">
        <div class="admin-card p-6">
            <h4 class="font-semibold mb-3 text-lg">Account Statistics</h4>
            <div class="space-y-3">
                <div class="flex justify-between items-center pb-2 border-b">
                    <span class="text-gray-600">Total Products</span>
                    <span class="font-semibold text-primary">{{ \App\Models\Product::count() }}</span>
                </div>
                <div class="flex justify-between items-center pb-2 border-b">
                    <span class="text-gray-600">Total Categories</span>
                    <span class="font-semibold text-primary">{{ \App\Models\Category::count() }}</span>
                </div>
                <div class="flex justify-between items-center pb-2 border-b">
                    <span class="text-gray-600">Total Brands</span>
                    <span class="font-semibold text-primary">{{ \App\Models\Brand::count() }}</span>
                </div>
                <div class="flex justify-between items-center pb-2 border-b">
                    <span class="text-gray-600">Active Coupons</span>
                    <span class="font-semibold text-primary">{{ \App\Models\Coupon::where('is_active', true)->count() }}</span>
                </div>
                <div class="flex justify-between items-center pt-2">
                    <span class="text-gray-600">Total Banners</span>
                    <span class="font-semibold text-primary">{{ \App\Models\Banner::count() }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
