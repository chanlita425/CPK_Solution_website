@props([
    'name',
    'value' => null,
    'placeholder' => 'Select date',
    'label' => null,
    'required' => false,
    'error' => null,
    'minDate' => null,
    'maxDate' => null,
    'enableTime' => false,
    'dateFormat' => 'Y-m-d',
])

@php
    $dateValue = old($name, $value);
    $displayValue = '';
    if ($dateValue && $dateValue != '') {
        try {
            // Parse the date and format for display in local time
            $date = \Carbon\Carbon::parse($dateValue);
            $displayValue = $date->format('m/d/Y');
        } catch (\Exception $e) {
            $displayValue = $dateValue;
        }
    }
@endphp

<div class="date-picker-wrapper w-full">
    @if ($label)
        <label class="block text-sm font-medium text-gray-700 mb-2">
            {{ $label }} @if ($required)
                <span class="text-red-500">*</span>
            @endif
        </label>
    @endif

    <div class="relative">
        <i
            class="fas fa-calendar-alt absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 z-10 text-sm sm:text-base"></i>
        <input type="text" id="date_{{ $name }}_input" value="{{ $displayValue }}"
            placeholder="{{ $placeholder }}"
            class="w-full bg-white border border-gray-300 rounded-lg py-2.5 sm:py-2.5 pl-10 pr-4 text-left focus:outline-none focus:ring-2 focus:ring-[#D7B259] focus:border-transparent hover:border-[#D7B259] transition-all text-sm sm:text-base min-h-[42px]"
            autocomplete="off">
        <input type="hidden" name="{{ $name }}" id="date_{{ $name }}" value="{{ $dateValue }}">
    </div>

    @if ($error)
        <p class="text-red-500 text-xs mt-1">{{ $error }}</p>
    @endif
</div>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const inputElement = document.getElementById('date_{{ $name }}_input');
            const hiddenInput = document.getElementById('date_{{ $name }}');

            if (inputElement && typeof flatpickr !== 'undefined') {
                flatpickr(inputElement, {
                    dateFormat: "m/d/Y",
                    altFormat: "m/d/Y",
                    altInput: false,
                    allowInput: false,
                    disableMobile: false,
                    // Fix timezone issue - use local time
                    utc: false,
                    defaultDate: inputElement.value || null,
                    @if ($minDate)
                        minDate: "{{ $minDate }}",
                    @endif
                    @if ($maxDate)
                        maxDate: "{{ $maxDate }}",
                    @endif
                    onChange: function(selectedDates, dateStr, instance) {
                        if (selectedDates.length > 0) {
                            // Get the local date without timezone conversion
                            const selectedDate = selectedDates[0];
                            const year = selectedDate.getFullYear();
                            const month = String(selectedDate.getMonth() + 1).padStart(2, '0');
                            const day = String(selectedDate.getDate()).padStart(2, '0');
                            const localDateStr = `${year}-${month}-${day}`;
                            hiddenInput.value = localDateStr;
                        } else {
                            hiddenInput.value = '';
                        }
                    },
                    onReady: function(selectedDates, dateStr, instance) {
                        // Set the initial value correctly
                        if (hiddenInput.value) {
                            const parts = hiddenInput.value.split('-');
                            if (parts.length === 3) {
                                const localDate = new Date(parts[0], parts[1] - 1, parts[2]);
                                instance.setDate(localDate, false);
                            }
                        }
                        // Style the calendar
                        if (instance.calendarContainer) {
                            instance.calendarContainer.style.zIndex = '9999';
                        }
                    }
                });
            }
        });
    </script>
@endpush
