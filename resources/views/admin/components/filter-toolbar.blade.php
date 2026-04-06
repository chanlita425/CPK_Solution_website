@props([
    'searchPlaceholder' => 'Search...',
    'searchValue' => '',
    'filters' => [],
    'showReset' => true,
])

@php
    $currentSearch = request('search', $searchValue);
@endphp

<div class="filter-toolbar bg-white rounded-2xl border border-gray-200 p-4 mb-6">
    <div class="flex flex-col sm:flex-row gap-3 items-start sm:items-center">
        <!-- Search Input -->
        <div class="flex-1 w-full">
            <div class="relative">
                <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                <input type="text" id="globalSearch" value="{{ $currentSearch }}" placeholder="{{ $searchPlaceholder }}"
                    class="w-full pl-10 pr-4 h-[42px] border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#D7B259] focus:border-transparent text-sm">
            </div>
        </div>

        <!-- Dynamic Filters using Styled Select Component -->
        @foreach ($filters as $filter)
            <div class="w-full sm:w-48">
                @if ($filter['type'] === 'select' && isset($filter['options']))
                    @php
                        $selectOptions = [];
                        foreach ($filter['options'] as $option) {
                            $selectOptions[] = ['value' => $option['value'], 'label' => $option['label']];
                        }
                    @endphp
                    @include('admin.components.styled-select', [
                        'name' => 'filter_' . $filter['name'],
                        'options' => $selectOptions,
                        'selected' => request($filter['name']),
                        'placeholder' => $filter['placeholder'],
                        'required' => false,
                    ])
                @elseif($filter['type'] === 'status')
                    @php
                        $statusOptions = [
                            ['value' => 'active', 'label' => 'Active'],
                            ['value' => 'inactive', 'label' => 'Inactive'],
                        ];
                    @endphp
                    @include('admin.components.styled-select', [
                        'name' => 'filter_status',
                        'options' => $statusOptions,
                        'selected' => request('status'),
                        'placeholder' => 'All Status',
                        'required' => false,
                    ])
                @endif
            </div>
        @endforeach

        <!-- Action Buttons -->
        <div class="flex gap-2 w-full sm:w-auto">
            <button id="applyFiltersBtn"
                class="flex-1 sm:flex-none bg-[#D7B259] hover:bg-[#c4a145] text-gray-900 px-5 h-[42px] rounded-lg transition font-medium text-sm focus:outline-none focus:ring-2 focus:ring-[#D7B259] focus:ring-offset-1">
                <i class="fas fa-filter mr-1"></i> Filter
            </button>
            @if ($showReset)
                <button id="resetFiltersBtn"
                    class="flex-1 sm:flex-none border border-gray-300 hover:bg-gray-50 text-gray-700 px-5 h-[42px] rounded-lg transition font-medium text-sm focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-offset-1">
                    <i class="fas fa-undo-alt mr-1"></i> Reset
                </button>
            @endif
        </div>
    </div>
</div>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('globalSearch');
            const applyBtn = document.getElementById('applyFiltersBtn');
            const resetBtn = document.getElementById('resetFiltersBtn');

            function getFilterValues() {
                const filters = {};

                document.querySelectorAll('.styled-select-wrapper').forEach(wrapper => {
                    const hiddenInput = wrapper.querySelector('input[type="hidden"]');
                    if (hiddenInput && hiddenInput.name) {
                        const name = hiddenInput.name.replace('filter_', '');
                        const value = hiddenInput.value;
                        if (value && value !== '') {
                            filters[name] = value;
                        }
                    }
                });

                return filters;
            }

            function applyFilters() {
                const params = new URLSearchParams(window.location.search);

                if (searchInput?.value) {
                    params.set('search', searchInput.value);
                } else {
                    params.delete('search');
                }

                const filterValues = getFilterValues();
                Object.keys(filterValues).forEach(name => {
                    params.set(name, filterValues[name]);
                });

                const existingParams = ['search', 'category', 'brand', 'status'];
                existingParams.forEach(param => {
                    if (!filterValues[param] && param !== 'search') {
                        params.delete(param);
                    }
                });

                window.location.href = window.location.pathname + '?' + params.toString();
            }

            function resetFilters() {
                window.location.href = window.location.pathname;
            }

            if (applyBtn) applyBtn.addEventListener('click', applyFilters);
            if (resetBtn) resetBtn.addEventListener('click', resetFilters);

            if (searchInput) {
                searchInput.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') applyFilters();
                });
            }
        });
    </script>
@endpush
