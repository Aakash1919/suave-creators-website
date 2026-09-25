@extends('layouts.frontend')

@section('content')
    <!-- Thank You Section Start -->
    <section
        class="relative z-10 w-full flex flex-col items-center justify-center text-center site-container py-16 sm:py-24 lg:py-32"
        aria-labelledby="thank-you-heading"
    >
        <div class="inline-flex items-center justify-center mb-6 sm:mb-8" aria-hidden="true">
            <span class="thank-you-check-badge flex h-16 w-16 sm:h-20 sm:w-20 items-center justify-center rounded-full bg-emerald-50 text-emerald-600 text-2xl sm:text-3xl ring-8 ring-emerald-50/60 shadow-lg shadow-emerald-500/10">
                <i class="fa-solid fa-check thank-you-check-icon"></i>
            </span>
        </div>

        <h1
            id="thank-you-heading"
            class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-[#0B132B] tracking-tight max-w-3xl leading-tight"
        >
            Thank You!
        </h1>

        <p class="text-lg sm:text-xl md:text-2xl font-semibold text-[#1E293B] mt-2 sm:mt-3 tracking-tight">
            Your Request Has Been Received
        </p>

        <p class="text-base sm:text-lg text-[#64748B] max-w-xl mt-3 sm:mt-4 leading-relaxed">
            We appreciate you reaching out to Suave Creators. One of our technical leads will review your details and get back to you within 24 hours.
        </p>

        <div class="mt-8 sm:mt-10">
            <x-frontend.cta-button :href="route('home')">
                Back to Home
            </x-frontend.cta-button>
        </div>
    </section>
    <!-- Thank You Section End -->

    <style>
        @keyframes thankYouPop {
            0% {
                transform: scale(0.35);
                opacity: 0;
            }
            70% {
                transform: scale(1.12);
                opacity: 1;
            }
            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        @keyframes thankYouPulseRing {
            0%, 100% {
                box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.35);
            }
            50% {
                box-shadow: 0 0 0 14px rgba(16, 185, 129, 0);
            }
        }

        @keyframes thankYouCheckmark {
            0% {
                transform: scale(0) rotate(-45deg);
                opacity: 0;
            }
            60% {
                transform: scale(1.25) rotate(4deg);
                opacity: 1;
            }
            100% {
                transform: scale(1) rotate(0deg);
                opacity: 1;
            }
        }

        .thank-you-check-badge {
            animation: thankYouPop 0.6s cubic-bezier(0.34, 1.56, 0.64, 1) both,
                       thankYouPulseRing 2.4s ease-in-out 0.6s infinite;
        }

        .thank-you-check-icon {
            display: inline-block;
            animation: thankYouCheckmark 0.5s cubic-bezier(0.34, 1.56, 0.64, 1) 0.15s both;
        }
    </style>
@endsection

