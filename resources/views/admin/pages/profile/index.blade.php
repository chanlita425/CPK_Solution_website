{{-- resources/views/admin/pages/profile/index.blade.php --}}
@extends('admin.layouts.app')

@section('title', 'Profile Settings')
@section('header', 'Profile Settings')

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

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Update Profile Form -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                <h3 class="text-lg font-semibold text-gray-800">
                    <i class="fas fa-user-circle text-yellow-500 mr-2"></i> Update Profile
                </h3>
                <p class="text-sm text-gray-500 mt-1">Update your name and email address</p>
            </div>

            <form action="{{ route('admin.profile.update') }}" method="POST" class="p-6">
                @csrf
                @method('PUT')

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Full Name <span
                                class="text-red-500">*</span></label>
                        <input type="text" name="name" value="{{ old('name', $admin->name) }}" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-yellow-500 focus:border-yellow-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Email Address <span
                                class="text-red-500">*</span></label>
                        <input type="email" name="email" value="{{ old('email', $admin->email) }}" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-yellow-500 focus:border-yellow-500">
                    </div>
                </div>

                <div class="mt-6">
                    <button type="submit"
                        class="bg-yellow-500 hover:bg-yellow-600 text-gray-900 px-4 py-2 rounded-lg transition">
                        <i class="fas fa-save mr-2"></i> Update Profile
                    </button>
                </div>
            </form>
        </div>

        <!-- Change Password Form -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                <h3 class="text-lg font-semibold text-gray-800">
                    <i class="fas fa-lock text-yellow-500 mr-2"></i> Change Password
                </h3>
                <p class="text-sm text-gray-500 mt-1">Update your password (minimum 8 characters)</p>
            </div>

            <form action="{{ route('admin.password.update') }}" method="POST" class="p-6">
                @csrf
                @method('PUT')

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Current Password <span
                                class="text-red-500">*</span></label>
                        <input type="password" name="current_password" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-yellow-500 focus:border-yellow-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">New Password <span
                                class="text-red-500">*</span></label>
                        <input type="password" name="password" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-yellow-500 focus:border-yellow-500">
                        <p class="text-xs text-gray-500 mt-1">Minimum 8 characters</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Confirm New Password <span
                                class="text-red-500">*</span></label>
                        <input type="password" name="password_confirmation" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-yellow-500 focus:border-yellow-500">
                    </div>
                </div>

                <div class="mt-6">
                    <button type="submit"
                        class="bg-yellow-500 hover:bg-yellow-600 text-gray-900 px-4 py-2 rounded-lg transition">
                        <i class="fas fa-key mr-2"></i> Change Password
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Security Tips -->
    <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
        <div class="flex items-start gap-3">
            <i class="fas fa-shield-alt text-blue-500 text-xl mt-0.5"></i>
            <div>
                <h4 class="font-semibold text-blue-800">Security Tips</h4>
                <ul class="list-disc list-inside text-sm text-blue-700 mt-1 space-y-1">
                    <li>Use a strong password with at least 8 characters</li>
                    <li>Include numbers, uppercase, lowercase, and special characters</li>
                    <li>Never share your password with anyone</li>
                    <li>Change your password regularly</li>
                </ul>
            </div>
        </div>
    </div>
@endsection
