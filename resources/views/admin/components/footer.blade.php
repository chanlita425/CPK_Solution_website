{{-- resources/views/admin/components/footer.blade.php --}}
<footer class="bg-white border-t border-gray-200 mt-8">
    <div class="px-4 md:px-6 py-4">
        <div class="flex flex-col md:flex-row justify-between items-center gap-3">
            <p class="text-sm text-gray-500">
                &copy; {{ date('Y') }} CPK Solution. All rights reserved.
            </p>
            <div class="flex items-center gap-4 text-xs text-gray-400">
                <span>Version 1.0.0</span>
                <span>•</span>
                <span>Powered by Laravel</span>
            </div>
        </div>
    </div>
</footer>
