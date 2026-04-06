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
    <div class="flex flex-col sm:flex-row gap-3">
        <!-- Search Input -->
        <div class="flex-1">
            <div class="relative">
                <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                <input type="text" id="globalSearch" value="{{ $currentSearch }}" placeholder="{{ $searchPlaceholder }}"
                    class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#D7B259] focus:border-transparent">
            </div>
        </div>

        <!-- Dynamic Filters -->
        @foreach ($filters as $filter)
            <div class="w-full sm:w-48">
                @if ($filter['type'] === 'select')
                    <select id="filter_{{ $filter['name'] }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#D7B259]  focus:border-transparent">
                        <option value="">{{ $filter['placeholder'] }}</option>
                        @foreach ($filter['options'] as $option)
                            <option value="{{ $option['value'] }}"
                                {{ request($filter['name']) == $option['value'] ? 'selected' : '' }}>
                                {{ $option['label'] }}
                            </option>
                        @endforeach
                    </select>
                @elseif($filter['type'] === 'status')
                    <select id="filter_status"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#D7B259] focus:border-transparent">
                        <option value="">All Status</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive
                        </option>
                    </select>
                @endif
            </div>
        @endforeach

        <!-- Action Buttons -->
        <div class="flex gap-2">
            <button id="applyFiltersBtn" class="btn-primary px-5 py-2 whitespace-nowrap">
                <i class="fas fa-filter mr-1"></i> Filter
            </button>
            @if ($showReset)
                <button id="resetFiltersBtn" class="btn-secondary px-5 py-2 whitespace-nowrap">
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

            function applyFilters() {
                const params = new URLSearchParams(window.location.search);

                if (searchInput?.value) {
                    params.set('search', searchInput.value);
                } else {
                    params.delete('search');
                }

                document.querySelectorAll('[id^="filter_"]').forEach(select => {
                    const name = select.id.replace('filter_', '');
                    const value = select.value;
                    if (value && value !== '') {
                        params.set(name, value);
                    } else {
                        params.delete(name);
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
