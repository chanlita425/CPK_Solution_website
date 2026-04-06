@props([
    'name',
    'options' => [],
    'selected' => null,
    'placeholder' => 'Select option...',
    'label' => null,
    'required' => false,
    'error' => null,
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

<div class="searchable-select-wrapper w-full" x-data="{
    open: false,
    search: '',
    selected: '{{ $selectedValue }}',
    selectedLabel: '{{ addslashes($selectedLabel) }}',
    options: {{ json_encode($options) }},

    get filteredOptions() {
        if (!this.search) return this.options;
        return this.options.filter(opt =>
            opt.label.toLowerCase().includes(this.search.toLowerCase())
        );
    },

    selectOption(value, label) {
        this.selected = value;
        this.selectedLabel = label;
        this.open = false;
        this.search = '';
        const hiddenInput = document.getElementById('select_{{ $name }}');
        if (hiddenInput) hiddenInput.value = value;
    },

    clearSelection() {
        this.selected = '';
        this.selectedLabel = '';
        const hiddenInput = document.getElementById('select_{{ $name }}');
        if (hiddenInput) hiddenInput.value = '';
    }
}" @click.away="open = false">
    @if ($label)
        <label class="form-label">{{ $label }} @if ($required)
                <span class="text-red-500">*</span>
            @endif
        </label>
    @endif

    <div class="relative">
        <!-- Select Trigger -->
        <button type="button" @click="open = !open"
            class="relative w-full bg-white border border-gray-300 rounded-lg py-2.5 px-4 text-left cursor-pointer focus:outline-none focus:ring-2 focus:ring-[#D7B259] focus:border-transparent transition-all">
            <span class="block truncate" x-show="!selectedLabel" :class="{ 'text-gray-400': !selectedLabel }">
                {{ $placeholder }}
            </span>
            <span class="block truncate" x-show="selectedLabel" x-text="selectedLabel"></span>
            <span class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                <i class="fas fa-chevron-down text-gray-400 text-xs transition-transform"
                    :class="{ 'rotate-180': open }"></i>
            </span>
        </button>

        <!-- Dropdown Menu -->
        <div x-show="open" x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 transform -translate-y-2"
            x-transition:enter-end="opacity-100 transform translate-y-0"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 transform translate-y-0"
            x-transition:leave-end="opacity-0 transform -translate-y-2"
            class="absolute z-50 mt-1 w-full bg-white border border-gray-200 rounded-lg shadow-lg max-h-60 overflow-auto"
            style="display: none;">

            <!-- Search Input -->
            <div class="sticky top-0 bg-white p-2 border-b border-gray-200">
                <div class="relative">
                    <i class="fas fa-search absolute left-3 top-2.5 text-gray-400 text-sm"></i>
                    <input type="text" x-model="search" @click.stop
                        class="w-full pl-9 pr-3 py-1.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#D7B259] focus:border-transparent"
                        placeholder="Search...">
                    <button x-show="search" @click="search = ''" type="button"
                        class="absolute right-2 top-2 text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times text-xs"></i>
                    </button>
                </div>
            </div>

            <!-- Options -->
            <div class="py-1">
                <template x-for="option in filteredOptions" :key="option.value">
                    <div @click="selectOption(option.value, option.label)"
                        class="px-4 py-2 cursor-pointer hover:bg-gray-50 transition-colors"
                        :class="{ 'bg-[#D7B259]/10 text-[#D7B259]': selected == option.value }">
                        <span x-text="option.label" class="text-sm"></span>
                        <i x-show="selected == option.value"
                            class="fas fa-check text-[#D7B259] text-xs float-right mt-1"></i>
                    </div>
                </template>
                <div x-show="filteredOptions.length === 0" class="px-4 py-3 text-sm text-gray-500 text-center">
                    No results found
                </div>
            </div>
        </div>
    </div>

    <input type="hidden" name="{{ $name }}" id="select_{{ $name }}" value="{{ $selectedValue }}">

    @if ($error)
        <p class="text-red-500 text-xs mt-1">{{ $error }}</p>
    @endif
</div>
