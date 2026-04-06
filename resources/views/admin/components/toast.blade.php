{{-- resources/views/admin/components/toast.blade.php --}}
<script>
    window.showToast = function(message, type = 'success') {
        const container = document.getElementById('toastContainer');
        if (!container) return;

        const toastId = 'toast_' + Date.now();
        const icons = {
            success: 'fa-check-circle',
            error: 'fa-exclamation-circle',
            warning: 'fa-exclamation-triangle',
            info: 'fa-info-circle'
        };

        const bgColors = {
            success: 'bg-emerald-50 border-emerald-200 text-emerald-800',
            error: 'bg-red-50 border-red-200 text-red-800',
            warning: 'bg-amber-50 border-amber-200 text-amber-800',
            info: 'bg-blue-50 border-blue-200 text-blue-800'
        };

        const progressColors = {
            success: 'bg-emerald-500',
            error: 'bg-red-500',
            warning: 'bg-amber-500',
            info: 'bg-blue-500'
        };

        const toastHtml = `
            <div id="${toastId}" class="toast-notification w-80 shadow-lg rounded-lg overflow-hidden transform transition-all duration-300 translate-x-0"
                 x-data="{ show: true, progress: 100 }"
                 x-init="setTimeout(() => { show = false; setTimeout(() => document.getElementById('${toastId}')?.remove(), 300) }, 5000);
                         let interval = setInterval(() => { if (progress > 0) progress -= 2; else clearInterval(interval) }, 100)"
                 x-show="show"
                 x-transition:enter="transform ease-out duration-300"
                 x-transition:enter-start="translate-x-full opacity-0"
                 x-transition:enter-end="translate-x-0 opacity-100"
                 x-transition:leave="transform ease-in duration-300"
                 x-transition:leave-start="translate-x-0 opacity-100"
                 x-transition:leave-end="translate-x-full opacity-0">
                <div class="${bgColors[type]} border rounded-lg">
                    <div class="p-4 flex items-start gap-3">
                        <i class="fas ${icons[type]} text-lg mt-0.5 flex-shrink-0"></i>
                        <div class="flex-1 text-sm font-medium">${message}</div>
                        <button @click="show = false" class="text-gray-400 hover:text-gray-600 flex-shrink-0">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <div class="h-1 bg-gray-100">
                        <div class="h-full ${progressColors[type]} transition-all duration-100" :style="{ width: progress + '%' }"></div>
                    </div>
                </div>
            </div>
        `;

        container.insertAdjacentHTML('beforeend', toastHtml);

        // Initialize Alpine component
        if (window.Alpine && window.Alpine.initTree) {
            const toastElement = document.getElementById(toastId);
            if (toastElement) {
                window.Alpine.initTree(toastElement);
            }
        }
    };
</script>
