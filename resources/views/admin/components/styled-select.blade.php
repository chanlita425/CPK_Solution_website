@props([
    'name',
    'options' => [],
    'selected' => null,
    'placeholder' => 'Select option...',
    'label' => null,
    'required' => false,
    'error' => null,
    'icon' => null,
])

@php
    $selectedValue = old($name, $selected);
    $selectedLabel = '';
    foreach ($options as $option) {
        if ($option['value'] == $selectedValue) {
            $selectedLabel = $option['label'];
            break;
        }
    }
@endphp

<div class="styled-select-wrapper w-full">
    @if ($label)
        <label class="block text-sm font-medium text-gray-700 mb-2">
            {{ $label }} @if ($required)
                <span class="text-red-500">*</span>
            @endif
        </label>
    @endif

    <div class="relative" x-data="{ open: false, selected: '{{ $selectedValue }}', selectedLabel: '{{ addslashes($selectedLabel) }}' }">
        <div class="relative">
            @if ($icon)
                <i class="{{ $icon }} absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 z-10"></i>
            @endif
            <button type="button" @click="open = !open"
                class="relative w-full bg-white border border-gray-300 rounded-lg h-[42px] px-4 text-left cursor-pointer focus:outline-none focus:ring-2 focus:ring-[#D7B259] focus:border-transparent hover:border-[#D7B259]"
                :class="{ 'pl-10': '{{ $icon }}' }">
                <div class="flex items-center justify-between h-full">
                    <span class="block truncate flex-1" x-show="!selectedLabel"
                        :class="{ 'text-gray-400': !selectedLabel }">
                        {{ $placeholder }}
                    </span>
                    <span class="block truncate flex-1" x-show="selectedLabel" x-text="selectedLabel"></span>
                    <i class="fas fa-chevron-down text-gray-400 text-xs transition-transform ml-2"
                        :class="{ 'rotate-180': open }"></i>
                </div>
            </button>
        </div>

        <!-- Dropdown Options -->
        <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 transform -translate-y-2"
            x-transition:enter-end="opacity-100 transform translate-y-0"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 transform translate-y-0"
            x-transition:leave-end="opacity-0 transform -translate-y-2"
            class="absolute z-[100] mt-1 w-full bg-white border border-gray-200 rounded-lg shadow-xl max-h-60 overflow-auto">
            <div class="py-1">
                @foreach ($options as $option)
                    <div @click="selected = '{{ $option['value'] }}'; selectedLabel = '{{ addslashes($option['label']) }}'; open = false; document.getElementById('select_{{ $name }}').value = '{{ $option['value'] }}'"
                        class="px-4 py-2.5 cursor-pointer hover:bg-gray-50 transition-colors flex items-center justify-between"
                        :class="{ 'bg-[#D7B259]/10 text-[#D7B259]': selected == '{{ $option['value'] }}' }">
                        <span class="text-sm">{{ $option['label'] }}</span>
                        <i x-show="selected == '{{ $option['value'] }}'"
                            class="fas fa-check text-[#D7B259] text-xs"></i>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <input type="hidden" name="{{ $name }}" id="select_{{ $name }}" value="{{ $selectedValue }}">

    @if ($error)
        <p class="text-red-500 text-xs mt-1">{{ $error }}</p>
    @endif
</div>
