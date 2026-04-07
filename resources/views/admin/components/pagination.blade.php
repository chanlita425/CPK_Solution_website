@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-between mt-8">
        <!-- Mobile Pagination -->
        <div class="flex justify-between flex-1 sm:hidden">
            @if ($paginator->onFirstPage())
                <span
                    class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-400 bg-gray-100 border border-gray-200 rounded-lg cursor-default">
                    <i class="fas fa-chevron-left mr-1 text-xs"></i> Previous
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}"
                    class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 hover:border-[#D7B259] transition-all duration-200">
                    <i class="fas fa-chevron-left mr-1 text-xs"></i> Previous
                </a>
            @endif

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}"
                    class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 hover:border-[#D7B259] transition-all duration-200">
                    Next <i class="fas fa-chevron-right ml-1 text-xs"></i>
                </a>
            @else
                <span
                    class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-400 bg-gray-100 border border-gray-200 rounded-lg cursor-default">
                    Next <i class="fas fa-chevron-right ml-1 text-xs"></i>
                </span>
            @endif
        </div>

        <!-- Desktop Pagination -->
        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
            <div>
                <p class="text-sm text-gray-600">
                    Showing
                    <span class="font-medium text-gray-900">{{ $paginator->firstItem() }}</span>
                    to
                    <span class="font-medium text-gray-900">{{ $paginator->lastItem() }}</span>
                    of
                    <span class="font-medium text-gray-900">{{ $paginator->total() }}</span>
                    results
                </p>
            </div>

            <div>
                <ul class="flex items-center gap-1.5">
                    {{-- Previous Page Link --}}
                    @if ($paginator->onFirstPage())
                        <li>
                            <span
                                class="flex items-center justify-center w-9 h-9 text-gray-400 bg-gray-100 border border-gray-200 rounded-lg cursor-default">
                                <i class="fas fa-chevron-left text-xs"></i>
                            </span>
                        </li>
                    @else
                        <li>
                            <a href="{{ $paginator->previousPageUrl() }}"
                                class="flex items-center justify-center w-9 h-9 text-gray-600 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 hover:border-[#D7B259] hover:text-[#D7B259] transition-all duration-200">
                                <i class="fas fa-chevron-left text-xs"></i>
                            </a>
                        </li>
                    @endif

                    {{-- Pagination Elements --}}
                    @php
                        // Get the pagination elements
                        $elements = $paginator->getUrlRange(1, $paginator->lastPage());
                        $currentPage = $paginator->currentPage();
                        $lastPage = $paginator->lastPage();

                        // Calculate window of pages to show
                        $start = max(1, $currentPage - 2);
                        $end = min($lastPage, $currentPage + 2);

                        // Adjust if at the beginning
                        if ($start <= 3) {
                            $start = 1;
                            $end = min(5, $lastPage);
                        }

                        // Adjust if at the end
                        if ($end >= $lastPage - 2) {
                            $end = $lastPage;
                            $start = max(1, $lastPage - 4);
                        }
                    @endphp

                    {{-- First page link if not in range --}}
                    @if ($start > 1)
                        <li>
                            <a href="{{ $paginator->url(1) }}"
                                class="flex items-center justify-center w-9 h-9 text-gray-600 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 hover:border-[#D7B259] hover:text-[#D7B259] transition-all duration-200">
                                1
                            </a>
                        </li>
                        @if ($start > 2)
                            <li>
                                <span
                                    class="flex items-center justify-center w-9 h-9 text-gray-400 bg-white border border-gray-200 rounded-lg cursor-default">
                                    ...
                                </span>
                            </li>
                        @endif
                    @endif

                    {{-- Page numbers --}}
                    @for ($i = $start; $i <= $end; $i++)
                        @if ($i == $currentPage)
                            <li>
                                <span
                                    class="flex items-center justify-center w-9 h-9 text-white bg-[#D7B259] border border-[#D7B259] rounded-lg shadow-sm cursor-default">
                                    {{ $i }}
                                </span>
                            </li>
                        @else
                            <li>
                                <a href="{{ $paginator->url($i) }}"
                                    class="flex items-center justify-center w-9 h-9 text-gray-600 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 hover:border-[#D7B259] hover:text-[#D7B259] transition-all duration-200">
                                    {{ $i }}
                                </a>
                            </li>
                        @endif
                    @endfor

                    {{-- Last page link if not in range --}}
                    @if ($end < $lastPage)
                        @if ($end < $lastPage - 1)
                            <li>
                                <span
                                    class="flex items-center justify-center w-9 h-9 text-gray-400 bg-white border border-gray-200 rounded-lg cursor-default">
                                    ...
                                </span>
                            </li>
                        @endif
                        <li>
                            <a href="{{ $paginator->url($lastPage) }}"
                                class="flex items-center justify-center w-9 h-9 text-gray-600 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 hover:border-[#D7B259] hover:text-[#D7B259] transition-all duration-200">
                                {{ $lastPage }}
                            </a>
                        </li>
                    @endif

                    {{-- Next Page Link --}}
                    @if ($paginator->hasMorePages())
                        <li>
                            <a href="{{ $paginator->nextPageUrl() }}"
                                class="flex items-center justify-center w-9 h-9 text-gray-600 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 hover:border-[#D7B259] hover:text-[#D7B259] transition-all duration-200">
                                <i class="fas fa-chevron-right text-xs"></i>
                            </a>
                        </li>
                    @else
                        <li>
                            <span
                                class="flex items-center justify-center w-9 h-9 text-gray-400 bg-gray-100 border border-gray-200 rounded-lg cursor-default">
                                <i class="fas fa-chevron-right text-xs"></i>
                            </span>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>
@endif
