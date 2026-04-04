@extends('admin.layouts.app')

@section('title', 'System Settings')
@section('header', 'System Settings')

@section('content')
<div class="admin-card p-6">
    @if(session('success'))
        <div class="admin-alert-success mb-4">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('admin.settings.system.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="space-y-6">
            <!-- Website Settings -->
            <div>
                <h3 class="text-lg font-semibold mb-4 border-b pb-2">Website Settings</h3>
                <div class="grid grid-cols-1 gap-4">
                    <div>
                        <label class="admin-form-label">Website URL</label>
                        <input type="text" name="website_url" class="admin-form-input"
                               value="{{ old('website_url', $settings['website_url'] ?? 'www.cpksolution.com') }}"
                               placeholder="www.cpksolution.com">
                        <p class="text-xs text-gray-500 mt-1">Your website domain name</p>
                        @error('website_url') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="admin-form-label">Navbar Logo</label>
                        <input type="file" name="navbar_logo" class="admin-form-input" accept="image/*" onchange="previewLogo(this)">
                        @if(isset($settings['navbar_logo']) && $settings['navbar_logo'])
                            <div id="logoPreview" class="mt-3">
                                <img src="{{ asset('storage/' . $settings['navbar_logo']) }}" class="h-12 object-contain">
                                <p class="text-xs text-gray-500 mt-1">Current logo</p>
                            </div>
                        @else
                            <div id="logoPreview" class="mt-3 hidden"></div>
                        @endif
                        @error('navbar_logo') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <!-- Contact Phone Numbers -->
            <div>
                <h3 class="text-lg font-semibold mb-4 border-b pb-2">Contact Phone Numbers</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="admin-form-label">Phone Number 1</label>
                        <input type="text" name="phone_1" class="admin-form-input"
                               value="{{ old('phone_1', $settings['phone_1'] ?? '012 345 678') }}"
                               placeholder="012 345 678">
                        @error('phone_1') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="admin-form-label">Phone Number 2</label>
                        <input type="text" name="phone_2" class="admin-form-input"
                               value="{{ old('phone_2', $settings['phone_2'] ?? '010 234 567') }}"
                               placeholder="010 234 567">
                        @error('phone_2') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <!-- Social Media Links -->
            <div>
                <h3 class="text-lg font-semibold mb-4 border-b pb-2">Social Media Links</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="admin-form-label">
                            <i class="fab fa-facebook text-blue-600 mr-2"></i> Facebook
                        </label>
                        <input type="url" name="facebook_url" class="admin-form-input"
                               value="{{ old('facebook_url', $settings['facebook_url'] ?? '') }}"
                               placeholder="https://facebook.com/yourpage">
                        @error('facebook_url') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="admin-form-label">
                            <i class="fab fa-tiktok text-black mr-2"></i> TikTok
                        </label>
                        <input type="url" name="tiktok_url" class="admin-form-input"
                               value="{{ old('tiktok_url', $settings['tiktok_url'] ?? '') }}"
                               placeholder="https://tiktok.com/@yourusername">
                        @error('tiktok_url') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="admin-form-label">
                            <i class="fab fa-instagram text-pink-600 mr-2"></i> Instagram
                        </label>
                        <input type="url" name="instagram_url" class="admin-form-input"
                               value="{{ old('instagram_url', $settings['instagram_url'] ?? '') }}"
                               placeholder="https://instagram.com/yourprofile">
                        @error('instagram_url') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="admin-form-label">
                            <i class="fab fa-telegram text-blue-400 mr-2"></i> Telegram
                        </label>
                        <input type="url" name="telegram_url" class="admin-form-input"
                               value="{{ old('telegram_url', $settings['telegram_url'] ?? '') }}"
                               placeholder="https://t.me/yourusername">
                        @error('telegram_url') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-6 flex justify-end">
            <button type="submit" class="btn-admin-primary">
                <i class="fas fa-save mr-2"></i> Save Settings
            </button>
        </div>
    </form>
</div>

<script>
function previewLogo(input) {
    const preview = document.getElementById('logoPreview');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.innerHTML = `<img src="${e.target.result}" class="h-12 object-contain"><p class="text-xs text-gray-500 mt-1">New logo preview</p>`;
            preview.classList.remove('hidden');
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection
