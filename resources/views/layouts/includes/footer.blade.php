<footer class="border-t border-gray-200 bg-gray-50">
    <div class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">
        <div class="flex flex-col items-center justify-between gap-6 md:flex-row">
            <a href="{{ url('/') }}" class="text-lg font-semibold tracking-tight">
                {{ config('app.name', 'Suave Creators') }}
            </a>

            <nav class="flex flex-wrap items-center justify-center gap-6">
                <a href="{{ url('/') }}" class="text-sm text-gray-600 transition hover:text-gray-900">Home</a>
                <a href="#" class="text-sm text-gray-600 transition hover:text-gray-900">Privacy Policy</a>
                <a href="#" class="text-sm text-gray-600 transition hover:text-gray-900">Terms of Service</a>
                <a href="#" class="text-sm text-gray-600 transition hover:text-gray-900">Contact</a>
            </nav>
        </div>

        <p class="mt-8 text-center text-sm text-gray-500">
            &copy; {{ date('Y') }} {{ config('app.name', 'Suave Creators') }}. All rights reserved.
        </p>
    </div>
</footer>
