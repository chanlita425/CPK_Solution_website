{{-- resources/views/admin/pages/profile/index.blade.php --}}
@extends('admin.layouts.app')

@section('title', 'Profile Settings')
@section('header', 'Profile Settings')
@section('subheader', 'Manage your account settings')

@section('content')
    <div class="max-w-4xl mx-auto">

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Update Profile Form -->
            <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-[#D7B259]/10 rounded-xl flex items-center justify-center">
                            <i class="fas fa-user-circle text-[#D7B259] text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800">Update Profile</h3>
                            <p class="text-sm text-gray-500">Update your account information</p>
                        </div>
                    </div>
                </div>

                <form action="{{ route('admin.profile.update') }}" method="POST" class="p-6">
                    @csrf
                    @method('PUT')

                    <div class="space-y-5">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Full Name <span
                                    class="text-red-500">*</span></label>
                            <div class="relative">
                                <i class="fas fa-user absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                                <input type="text" name="name" value="{{ old('name', $admin->name) }}" required
                                    class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#D7B259] focus:border-transparent">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Email Address <span
                                    class="text-red-500">*</span></label>
                            <div class="relative">
                                <i class="fas fa-envelope absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                                <input type="email" name="email" value="{{ old('email', $admin->email) }}" required
                                    class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#D7B259] focus:border-transparent">
                            </div>
                        </div>
                    </div>

                    <div class="mt-6">
                        <button type="submit"
                            class="px-4 py-2 bg-[#D7B259] hover:bg-[#c4a145] text-gray-900 rounded-lg transition font-medium">
                            <i class="fas fa-save mr-2"></i> Update Profile
                        </button>
                    </div>
                </form>
            </div>

            <!-- Change Password Form -->
            <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-[#D7B259]/10 rounded-xl flex items-center justify-center">
                            <i class="fas fa-lock text-[#D7B259] text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800">Change Password</h3>
                            <p class="text-sm text-gray-500">Update your password (minimum 8 characters)</p>
                        </div>
                    </div>
                </div>

                <form action="{{ route('admin.password.update') }}" method="POST" class="p-6">
                    @csrf
                    @method('PUT')

                    <div class="space-y-5">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Current Password <span
                                    class="text-red-500">*</span></label>
                            <div class="relative">
                                <i class="fas fa-key absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                                <input type="password" name="current_password" required
                                    class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#D7B259] focus:border-transparent">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">New Password <span
                                    class="text-red-500">*</span></label>
                            <div class="relative">
                                <i class="fas fa-lock absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                                <input type="password" name="password" required
                                    class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#D7B259] focus:border-transparent">
                            </div>
                            <p class="text-xs text-gray-500 mt-1">Minimum 8 characters with letters and numbers</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Confirm New Password <span
                                    class="text-red-500">*</span></label>
                            <div class="relative">
                                <i class="fas fa-check-circle absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                                <input type="password" name="password_confirmation" required
                                    class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#D7B259] focus:border-transparent">
                            </div>
                        </div>
                    </div>

                    <div class="mt-6">
                        <button type="submit"
                            class="px-4 py-2 bg-[#D7B259] hover:bg-[#c4a145] text-gray-900 rounded-lg transition font-medium">
                            <i class="fas fa-key mr-2"></i> Change Password
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Security Tips Card -->
        <div class="mt-6 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-2xl border border-blue-200 p-6">
            <div class="flex items-start gap-4">
                <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-shield-alt text-blue-600 text-xl"></i>
                </div>
                <div>
                    <h4 class="font-semibold text-blue-800 mb-2">Security Tips</h4>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-sm text-blue-700">
                        <div class="flex items-center gap-2">
                            <i class="fas fa-check-circle text-green-600 text-xs"></i>
                            <span>Use a strong password with at least 8 characters</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <i class="fas fa-check-circle text-green-600 text-xs"></i>
                            <span>Include numbers, uppercase, and special characters</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <i class="fas fa-check-circle text-green-600 text-xs"></i>
                            <span>Never share your password with anyone</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <i class="fas fa-check-circle text-green-600 text-xs"></i>
                            <span>Change your password regularly</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
