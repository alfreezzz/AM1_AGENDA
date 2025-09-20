@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Navigasi Halaman" class="flex flex-col space-y-4 sm:space-y-0 sm:flex-row sm:items-center sm:justify-between">
        <!-- Mobile Pagination -->
        <div class="flex flex-col space-y-3 sm:hidden">
            <!-- Mobile Info & Per Page -->
            <div class="flex items-center justify-between">
                <p class="text-sm text-gray-700">
                    Menampilkan
                    @if ($paginator->firstItem())
                        <span class="font-medium">{{ $paginator->firstItem() }}</span>
                        sampai
                        <span class="font-medium">{{ $paginator->lastItem() }}</span>
                    @else
                        {{ $paginator->count() }}
                    @endif
                    dari
                    <span class="font-medium">{{ $paginator->total() }}</span>
                    data
                </p>
                
                <form method="GET" action="{{ url()->current() }}" class="flex items-center">
                    <input type="hidden" name="search" value="{{ request('search') }}">
                    <select name="per_page" onchange="this.form.submit()" 
                            class="px-2 py-1 text-sm bg-white border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="10" {{ request('per_page', 25) == 10 ? 'selected' : '' }}>10</option>
                        <option value="25" {{ request('per_page', 25) == 25 ? 'selected' : '' }}>25</option>
                        <option value="50" {{ request('per_page', 25) == 50 ? 'selected' : '' }}>50</option>
                        <option value="100" {{ request('per_page', 25) == 100 ? 'selected' : '' }}>100</option>
                    </select>
                </form>
            </div>

            <!-- Mobile Navigation -->
            <div class="flex justify-between">
                @if ($paginator->onFirstPage())
                    <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium leading-5 text-gray-500 bg-white border border-gray-300 rounded-md cursor-default">
                        Sebelumnya
                    </span>
                @else
                    <a href="{{ $paginator->previousPageUrl() }}" class="relative inline-flex items-center px-4 py-2 text-sm font-medium leading-5 text-gray-700 transition duration-150 ease-in-out bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700">
                        Sebelumnya
                    </a>
                @endif

                @if ($paginator->hasMorePages())
                    <a href="{{ $paginator->nextPageUrl() }}" class="relative inline-flex items-center px-4 py-2 text-sm font-medium leading-5 text-gray-700 transition duration-150 ease-in-out bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700">
                        Selanjutnya
                    </a>
                @else
                    <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium leading-5 text-gray-500 bg-white border border-gray-300 rounded-md cursor-default">
                        Selanjutnya
                    </span>
                @endif
            </div>

            <!-- Mobile Page Links -->
            <div class="flex flex-wrap justify-center gap-1">
                @php
                    $currentPage = $paginator->currentPage();
                    $lastPage = $paginator->lastPage();
                    $start = max(1, $currentPage - 2);
                    $end = min($lastPage, $currentPage + 2);
                @endphp

                @if ($start > 1)
                    <a href="{{ $paginator->url(1) }}" class="px-3 py-1 text-sm text-gray-700 bg-white border border-gray-300 rounded hover:bg-gray-50">1</a>
                    @if ($start > 2)
                        <span class="px-2 py-1 text-sm text-gray-500">...</span>
                    @endif
                @endif

                @for ($i = $start; $i <= $end; $i++)
                    @if ($i == $currentPage)
                        <span class="px-3 py-1 text-sm font-medium text-white bg-blue-600 border border-blue-600 rounded">{{ $i }}</span>
                    @else
                        <a href="{{ $paginator->url($i) }}" class="px-3 py-1 text-sm text-gray-700 bg-white border border-gray-300 rounded hover:bg-gray-50">{{ $i }}</a>
                    @endif
                @endfor

                @if ($end < $lastPage)
                    @if ($end < $lastPage - 1)
                        <span class="px-2 py-1 text-sm text-gray-500">...</span>
                    @endif
                    <a href="{{ $paginator->url($lastPage) }}" class="px-3 py-1 text-sm text-gray-700 bg-white border border-gray-300 rounded hover:bg-gray-50">{{ $lastPage }}</a>
                @endif
            </div>
        </div>

        <!-- Desktop Pagination -->
        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
            <div class="flex items-center space-x-4">
                <p class="text-sm leading-5 text-gray-700">
                    Menampilkan
                    @if ($paginator->firstItem())
                        <span class="font-medium">{{ $paginator->firstItem() }}</span>
                        sampai
                        <span class="font-medium">{{ $paginator->lastItem() }}</span>
                    @else
                        {{ $paginator->count() }}
                    @endif
                    dari
                    <span class="font-medium">{{ $paginator->total() }}</span>
                    data
                </p>
                
            </div>
            
            <!-- Per Page Dropdown -->
            <form method="GET" action="{{ url()->current() }}" class="flex items-center">
                <input type="hidden" name="search" value="{{ request('search') }}">
                <label class="mr-2 text-sm text-gray-700">Tampilkan:</label>
                <select name="per_page" onchange="this.form.submit()" 
                        class="px-3 py-1 text-sm bg-white border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="10" {{ request('per_page', 25) == 10 ? 'selected' : '' }}>10</option>
                    <option value="25" {{ request('per_page', 25) == 25 ? 'selected' : '' }}>25</option>
                    <option value="50" {{ request('per_page', 25) == 50 ? 'selected' : '' }}>50</option>
                    <option value="100" {{ request('per_page', 25) == 100 ? 'selected' : '' }}>100</option>
                </select>
            </form>

            <div>
                <span class="relative z-0 inline-flex rounded-md shadow-sm rtl:flex-row-reverse">
                    {{-- Previous Page Link --}}
                    @if ($paginator->onFirstPage())
                        <span aria-disabled="true" aria-label="Halaman sebelumnya">
                            <span class="relative inline-flex items-center px-2 py-2 text-sm font-medium leading-5 text-gray-500 bg-white border border-gray-300 cursor-default rounded-l-md" aria-hidden="true">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                            </span>
                        </span>
                    @else
                        <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="relative inline-flex items-center px-2 py-2 text-sm font-medium leading-5 text-gray-500 transition duration-150 ease-in-out bg-white border border-gray-300 rounded-l-md hover:bg-gray-50 focus:z-10 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-500" aria-label="Halaman sebelumnya">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    @endif

                    {{-- Pagination Elements with 5 Page Limit --}}
                    @php
                        $currentPage = $paginator->currentPage();
                        $lastPage = $paginator->lastPage();
                        $start = max(1, $currentPage - 2);
                        $end = min($lastPage, $currentPage + 2);
                        
                        // Adjust if we're near the beginning or end
                        if ($currentPage <= 3) {
                            $end = min($lastPage, 5);
                        }
                        if ($currentPage > $lastPage - 2) {
                            $start = max(1, $lastPage - 4);
                        }
                    @endphp

                    {{-- First page and dots --}}
                    @if ($start > 1)
                        <a href="{{ $paginator->url(1) }}" class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium leading-5 text-gray-700 transition duration-150 ease-in-out bg-white border border-gray-300 hover:bg-gray-50 focus:z-10 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700" aria-label="Ke halaman 1">1</a>
                        @if ($start > 2)
                            <span aria-disabled="true">
                                <span class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium leading-5 text-gray-700 bg-white border border-gray-300 cursor-default">...</span>
                            </span>
                        @endif
                    @endif

                    {{-- Page Numbers --}}
                    @for ($i = $start; $i <= $end; $i++)
                        @if ($i == $currentPage)
                            <span aria-current="page">
                                <span class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium leading-5 text-white bg-blue-600 border border-blue-600 cursor-default">{{ $i }}</span>
                            </span>
                        @else
                            <a href="{{ $paginator->url($i) }}" class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium leading-5 text-gray-700 transition duration-150 ease-in-out bg-white border border-gray-300 hover:bg-gray-50 focus:z-10 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700" aria-label="Ke halaman {{ $i }}">{{ $i }}</a>
                        @endif
                    @endfor

                    {{-- Last page and dots --}}
                    @if ($end < $lastPage)
                        @if ($end < $lastPage - 1)
                            <span aria-disabled="true">
                                <span class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium leading-5 text-gray-700 bg-white border border-gray-300 cursor-default">...</span>
                            </span>
                        @endif
                        <a href="{{ $paginator->url($lastPage) }}" class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium leading-5 text-gray-700 transition duration-150 ease-in-out bg-white border border-gray-300 hover:bg-gray-50 focus:z-10 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700" aria-label="Ke halaman {{ $lastPage }}">{{ $lastPage }}</a>
                    @endif

                    {{-- Next Page Link --}}
                    @if ($paginator->hasMorePages())
                        <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="relative inline-flex items-center px-2 py-2 -ml-px text-sm font-medium leading-5 text-gray-500 transition duration-150 ease-in-out bg-white border border-gray-300 rounded-r-md hover:bg-gray-50 focus:z-10 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-500" aria-label="Halaman selanjutnya">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    @else
                        <span aria-disabled="true" aria-label="Halaman selanjutnya">
                            <span class="relative inline-flex items-center px-2 py-2 -ml-px text-sm font-medium leading-5 text-gray-500 bg-white border border-gray-300 cursor-default rounded-r-md" aria-hidden="true">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                </svg>
                            </span>
                        </span>
                    @endif
                </span>
            </div>
        </div>
    </nav>
@endif