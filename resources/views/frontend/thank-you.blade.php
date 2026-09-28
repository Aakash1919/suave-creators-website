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

        <p class="thank-you-subtitle font-semibold text-[#1E293B] mt-2 sm:mt-3 tracking-tight leading-tight" style="font-size: 40px; line-height: 1.2;">
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
        .thank-you-subtitle {
            font-size: 40px !important;
            line-height: 1.2 !important;
        }

        @keyframes thankYouBadgeFloat {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-5px);
            }
        }

        @keyframes thankYouPulseRing {
            0% {
                transform: scale(0.95);
                opacity: 0.9;
                box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.4);
            }
            70% {
                transform: scale(1.35);
                opacity: 0;
                box-shadow: 0 0 0 14px rgba(16, 185, 129, 0);
            }
            100% {
                transform: scale(1.35);
                opacity: 0;
                box-shadow: 0 0 0 0 rgba(16, 185, 129, 0);
            }
        }

        @keyframes thankYouCheckmark {
            0%, 100% {
                transform: scale(1) rotate(0deg);
            }
            20% {
                transform: scale(1.22) rotate(4deg);
            }
            35% {
                transform: scale(0.95) rotate(-2deg);
            }
            50% {
                transform: scale(1.08) rotate(1deg);
            }
            65% {
                transform: scale(1) rotate(0deg);
            }
        }

        .thank-you-check-badge {
            position: relative;
            animation: thankYouBadgeFloat 3s ease-in-out infinite;
        }

        .thank-you-check-badge::before {
            content: "";
            position: absolute;
            inset: -4px;
            border-radius: 9999px;
            border: 2px solid rgba(16, 185, 129, 0.4);
            animation: thankYouPulseRing 2.2s cubic-bezier(0.2, 0.8, 0.2, 1) infinite;
            pointer-events: none;
        }

        .thank-you-check-icon {
            display: inline-block;
            transform-origin: center;
            animation: thankYouCheckmark 2.4s ease-in-out infinite;
        }
    </style>
@endsection

