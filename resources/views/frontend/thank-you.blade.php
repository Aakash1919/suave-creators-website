@extends('layouts.frontend')

@section('content')
    <!-- Thank You Section Start -->
    <section
        class="relative z-10 w-full flex flex-col items-center justify-center text-center site-container py-16 sm:py-24 lg:py-32"
        aria-labelledby="thank-you-heading"
    >
        <div class="inline-flex items-center justify-center mb-6 sm:mb-8" aria-hidden="true">
            <span class="flex h-16 w-16 sm:h-20 sm:w-20 items-center justify-center rounded-full bg-emerald-50 text-emerald-600 text-2xl sm:text-3xl ring-8 ring-emerald-50/60">
                <i class="fa-solid fa-check"></i>
            </span>
        </div>

        <h1
            id="thank-you-heading"
            class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-[#0B132B] tracking-tight max-w-3xl leading-tight"
        >
            Thank You! Your Request Has Been Received
        </h1>

        <p class="text-base sm:text-lg text-[#64748B] max-w-xl mt-4 sm:mt-5 leading-relaxed">
            We appreciate you reaching out to Suave Creators. One of our technical leads will review your details and get back to you within 24 hours.
        </p>

        <div class="mt-8 sm:mt-10">
            <x-frontend.cta-button :href="route('home')">
                Back to Home
            </x-frontend.cta-button>
        </div>
    </section>
    <!-- Thank You Section End -->
@endsection
