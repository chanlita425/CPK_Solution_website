@props(['name', 'checked' => false, 'label' => null, 'helper' => null])

@php
    $checkedValue = old($name, $checked) ? '1' : '0';
@endphp

<div class="toggle-switch-wrapper">
    <div class="flex items-center justify-between">
        @if ($label)
            <label class="text-sm font-medium text-gray-700">{{ $label }}</label>
        @endif
        <button type="button" role="switch" aria-checked="{{ $checkedValue === '1' ? 'true' : 'false' }}"
            class="toggle-switch relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-[#D7B259] focus:ring-offset-2
                    {{ $checkedValue === '1' ? 'bg-[#D7B259]' : 'bg-gray-200' }}">
            <span
                class="toggle-knob pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out
                {{ $checkedValue === '1' ? 'translate-x-5' : 'translate-x-0' }}"></span>
        </button>
    </div>
    <input type="hidden" name="{{ $name }}" value="{{ $checkedValue }}" id="toggle_{{ $name }}">

    @if ($helper)
        <p class="text-xs text-gray-500 mt-2">{{ $helper }}</p>
    @endif
</div>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.toggle-switch').forEach(toggle => {
                // Remove any existing event listeners to avoid duplicates
                const newToggle = toggle.cloneNode(true);
                toggle.parentNode.replaceChild(newToggle, toggle);

                newToggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    const isChecked = this.getAttribute('aria-checked') === 'true';
                    const wrapper = this.closest('.toggle-switch-wrapper');
                    const hiddenInput = wrapper ? wrapper.querySelector('input[type="hidden"]') :
                        document.getElementById(this.closest('.toggle-switch-wrapper')
                            ?.querySelector('input[type="hidden"]')?.id);
                    const targetId = this.closest('.toggle-switch-wrapper')?.querySelector(
                        'input[type="hidden"]')?.id;
                    const hiddenInputElem = document.getElementById(targetId);

                    if (isChecked) {
                        this.setAttribute('aria-checked', 'false');
                        this.classList.remove('bg-[#D7B259]');
                        this.classList.add('bg-gray-200');
                        this.querySelector('.toggle-knob').classList.remove('translate-x-5');
                        this.querySelector('.toggle-knob').classList.add('translate-x-0');
                        if (hiddenInputElem) hiddenInputElem.value = '0';
                    } else {
                        this.setAttribute('aria-checked', 'true');
                        this.classList.remove('bg-gray-200');
                        this.classList.add('bg-[#D7B259]');
                        this.querySelector('.toggle-knob').classList.remove('translate-x-0');
                        this.querySelector('.toggle-knob').classList.add('translate-x-5');
                        if (hiddenInputElem) hiddenInputElem.value = '1';
                    }
                });
            });
        });
    </script>
@endpush
