<header class="border-b border-gray-200 bg-white">
    <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-4 sm:px-6 lg:px-8">
        <a href="{{ url('/') }}" class="text-xl font-semibold tracking-tight">
            {{ config('app.name', 'Suave Creators') }}
        </a>

        <nav class="hidden items-center gap-8 md:flex">
            <a href="{{ url('/') }}" class="text-sm font-medium text-gray-700 transition hover:text-gray-900">Home</a>
            <a href="#" class="text-sm font-medium text-gray-700 transition hover:text-gray-900">About</a>
            <a href="#" class="text-sm font-medium text-gray-700 transition hover:text-gray-900">Services</a>
            <a href="#" class="text-sm font-medium text-gray-700 transition hover:text-gray-900">Contact</a>
        </nav>

        {{-- Mobile menu toggle --}}
        <button type="button"
                class="inline-flex items-center justify-center rounded-md p-2 text-gray-700 hover:bg-gray-100 md:hidden"
                onclick="document.getElementById('mobile-menu').classList.toggle('hidden')"
                aria-label="Toggle navigation">
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/>
            </svg>
        </button>
    </div>

    {{-- Mobile menu --}}
    <div id="mobile-menu" class="hidden border-t border-gray-200 md:hidden">
        <nav class="flex flex-col gap-1 px-4 py-3">
            <a href="{{ url('/') }}" class="rounded-md px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100">Home</a>
            <a href="#" class="rounded-md px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100">About</a>
            <a href="#" class="rounded-md px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100">Services</a>
            <a href="#" class="rounded-md px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100">Contact</a>
        </nav>
    </div>
</header>
