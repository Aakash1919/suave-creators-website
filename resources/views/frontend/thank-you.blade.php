@extends('layouts.frontend')

@php
    $siteUrl = rtrim((string) config('app.url'), '/');
@endphp

@section('content')
    <!-- Thank You Hero Start -->
    <section class="relative z-10 w-full pt-8 pb-12 sm:pt-12 sm:pb-16 lg:pt-16 lg:pb-20 site-container overflow-hidden">
        {{-- Breadcrumb --}}
        <nav class="blog-breadcrumb mb-6" aria-label="Breadcrumb">
            <a href="{{ route('home') }}" class="hover:text-[#2A4DFB] transition-colors">Home</a>
            <span aria-hidden="true" class="mx-2 text-slate-400">/</span>
            <span aria-current="page" class="text-slate-700 font-medium">Thank You</span>
        </nav>

        {{-- Hero Header Card --}}
        <div class="relative rounded-3xl bg-gradient-to-b from-[#F8FAFF] via-white to-[#F0F5FF] border border-[#E2E8F0]/80 p-8 sm:p-12 lg:p-16 text-center shadow-[0_20px_60px_-15px_rgba(42,77,251,0.08)] overflow-hidden">
            {{-- Background ambient glows --}}
            <div class="pointer-events-none absolute -left-20 -top-20 h-64 w-64 rounded-full bg-[#2A4DFB]/10 blur-3xl" aria-hidden="true"></div>
            <div class="pointer-events-none absolute -right-20 -bottom-20 h-64 w-64 rounded-full bg-emerald-500/10 blur-3xl" aria-hidden="true"></div>

            {{-- Celebratory Icon Badge --}}
            <div class="inline-flex items-center justify-center mb-6">
                <div class="relative">
                    <div class="absolute inset-0 rounded-full bg-emerald-500/20 blur-xl animate-pulse"></div>
                    <div class="relative flex h-20 w-20 sm:h-24 sm:w-24 items-center justify-center rounded-full bg-gradient-to-tr from-emerald-600 to-emerald-400 text-white text-3xl sm:text-4xl shadow-xl shadow-emerald-600/30 ring-8 ring-emerald-50">
                        <i class="fa-solid fa-check" aria-hidden="true"></i>
                    </div>
                </div>
            </div>

            {{-- Eyebrow --}}
            <p class="text-xs sm:text-sm font-bold tracking-[0.2em] uppercase text-[#2A4DFB] mb-3 pragati-narrow-regular">
                Inquiry Received &bull; Let&rsquo;s Build Together
            </p>

            {{-- Main Title --}}
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-[#0B132B] tracking-tight max-w-3xl mx-auto leading-tight">
                Thank You! Your Request Has Been Received
            </h1>

            {{-- Lead Description --}}
            <p class="text-base sm:text-lg text-[#64748B] max-w-2xl mx-auto mt-4 mb-8 leading-relaxed">
                We appreciate you reaching out to Suave Creators. One of our technical leads or solution architects will carefully review your project details and reach out within 24 hours.
            </p>

            {{-- Assurance Badges --}}
            <div class="flex flex-wrap items-center justify-center gap-3 sm:gap-6 pt-2 pb-2">
                <span class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white border border-[#CBD5E1]/60 text-xs sm:text-sm font-medium text-[#1E293B] shadow-sm">
                    <i class="fa-solid fa-clock text-emerald-600 text-xs" aria-hidden="true"></i>
                    <span>&lt; 24 Hour Response</span>
                </span>
                <span class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white border border-[#CBD5E1]/60 text-xs sm:text-sm font-medium text-[#1E293B] shadow-sm">
                    <i class="fa-solid fa-shield-halved text-[#2A4DFB] text-xs" aria-hidden="true"></i>
                    <span>Complete Confidentiality</span>
                </span>
                <span class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white border border-[#CBD5E1]/60 text-xs sm:text-sm font-medium text-[#1E293B] shadow-sm">
                    <i class="fa-solid fa-bolt text-amber-500 text-xs" aria-hidden="true"></i>
                    <span>Tailored Solution Roadmap</span>
                </span>
            </div>
        </div>
    </section>
    <!-- Thank You Hero End -->

    <!-- What to Expect Section Start -->
    <section class="full-bleed bg-cover bg-top bg-no-repeat py-12 sm:py-16 lg:py-20 border-t border-[#E2E8F0]/70"
        style="background-image: url('{{ asset('assets/background/technology-section-bg.png') }}');"
        aria-labelledby="next-steps-heading">
        <div class="section-inner max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <header class="text-center max-w-2xl mx-auto mb-12 sm:mb-16">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-[#DBEAFE] text-[#1D4ED8] text-[11px] font-bold tracking-wider uppercase mb-3">
                    <i class="fa-solid fa-route text-[10px]" aria-hidden="true"></i>
                    <span>Process</span>
                </span>
                <h2 id="next-steps-heading" class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-[#0B132B] tracking-tight">
                    What Happens Next?
                </h2>
                <p class="text-sm sm:text-base text-[#64748B] mt-2 leading-relaxed">
                    Here is our clear, transparent process for turning your ideas into scalable real-world solutions.
                </p>
            </header>

            {{-- 3 Process Steps --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 lg:gap-8">
                {{-- Step 1 --}}
                <div class="relative rounded-2xl bg-white p-7 sm:p-8 border border-[#E2E8F0] shadow-sm hover:shadow-md hover:border-[#2A4DFB]/40 transition duration-200 flex flex-col justify-between group">
                    <div>
                        <div class="flex items-center justify-between mb-5">
                            <span class="flex h-12 w-12 items-center justify-center rounded-xl bg-[#EEF2FF] text-[#4F46E5] text-lg font-extrabold shadow-sm group-hover:scale-105 transition-transform">
                                01
                            </span>
                            <span class="text-xs font-semibold px-2.5 py-1 rounded-full bg-slate-100 text-slate-600">Initial Phase</span>
                        </div>
                        <h3 class="text-lg font-bold text-[#0F172A] mb-2 group-hover:text-[#2A4DFB] transition-colors">
                            Requirement Assessment
                        </h3>
                        <p class="text-sm text-[#64748B] leading-relaxed">
                            Our technical leads review your project requirements, scope, target goals, and existing stack compatibility to identify key opportunities.
                        </p>
                    </div>
                    <div class="mt-6 pt-4 border-t border-slate-100 text-xs font-medium text-[#4F46E5] flex items-center gap-1.5">
                        <i class="fa-solid fa-clock text-[11px]" aria-hidden="true"></i>
                        <span>Within 24 Hours</span>
                    </div>
                </div>

                {{-- Step 2 --}}
                <div class="relative rounded-2xl bg-white p-7 sm:p-8 border border-[#E2E8F0] shadow-sm hover:shadow-md hover:border-[#2A4DFB]/40 transition duration-200 flex flex-col justify-between group">
                    <div>
                        <div class="flex items-center justify-between mb-5">
                            <span class="flex h-12 w-12 items-center justify-center rounded-xl bg-[#DBEAFE] text-[#2563EB] text-lg font-extrabold shadow-sm group-hover:scale-105 transition-transform">
                                02
                            </span>
                            <span class="text-xs font-semibold px-2.5 py-1 rounded-full bg-slate-100 text-slate-600">Strategy</span>
                        </div>
                        <h3 class="text-lg font-bold text-[#0F172A] mb-2 group-hover:text-[#2A4DFB] transition-colors">
                            Tailored Solution Roadmap
                        </h3>
                        <p class="text-sm text-[#64748B] leading-relaxed">
                            We map out high-level technical architecture options, recommended milestones, and realistic timelines aligned directly with your business budget.
                        </p>
                    </div>
                    <div class="mt-6 pt-4 border-t border-slate-100 text-xs font-medium text-[#2563EB] flex items-center gap-1.5">
                        <i class="fa-solid fa-layer-group text-[11px]" aria-hidden="true"></i>
                        <span>Architecture &amp; Scope</span>
                    </div>
                </div>

                {{-- Step 3 --}}
                <div class="relative rounded-2xl bg-white p-7 sm:p-8 border border-[#E2E8F0] shadow-sm hover:shadow-md hover:border-[#2A4DFB]/40 transition duration-200 flex flex-col justify-between group">
                    <div>
                        <div class="flex items-center justify-between mb-5">
                            <span class="flex h-12 w-12 items-center justify-center rounded-xl bg-[#D1FAE5] text-[#059669] text-lg font-extrabold shadow-sm group-hover:scale-105 transition-transform">
                                03
                            </span>
                            <span class="text-xs font-semibold px-2.5 py-1 rounded-full bg-slate-100 text-slate-600">Alignment</span>
                        </div>
                        <h3 class="text-lg font-bold text-[#0F172A] mb-2 group-hover:text-[#2A4DFB] transition-colors">
                            Discovery Strategy Call
                        </h3>
                        <p class="text-sm text-[#64748B] leading-relaxed">
                            A focused 30-minute consultation call with our senior architects to discuss technical trade-offs, answer questions, and finalize kickoff details.
                        </p>
                    </div>
                    <div class="mt-6 pt-4 border-t border-slate-100 text-xs font-medium text-[#059669] flex items-center gap-1.5">
                        <i class="fa-solid fa-phone text-[11px]" aria-hidden="true"></i>
                        <span>Interactive 1-on-1 Call</span>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- What to Expect Section End -->

    <!-- While You Wait / Resources Start -->
    <section class="site-container py-12 sm:py-16 lg:py-20" aria-labelledby="explore-more-heading">
        <header class="text-center max-w-2xl mx-auto mb-10 sm:mb-12">
            <h2 id="explore-more-heading" class="text-2xl sm:text-3xl font-extrabold text-[#0B132B] tracking-tight">
                Explore While You Wait
            </h2>
            <p class="text-sm sm:text-base text-[#64748B] mt-1.5 leading-relaxed">
                Discover how our clients achieve rapid product growth and technological leverage.
            </p>
        </header>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8 max-w-4xl mx-auto">
            {{-- Case Studies Card --}}
            <div class="rounded-2xl bg-white p-7 sm:p-8 border border-[#CBD5E1]/70 shadow-sm hover:shadow-lg hover:border-[#2A4DFB]/40 transition duration-200 flex flex-col justify-between">
                <div>
                    <span class="inline-flex h-11 w-11 items-center justify-center rounded-xl bg-[#EEF2FF] text-[#2A4DFB] text-lg mb-4">
                        <i class="fa-solid fa-rocket" aria-hidden="true"></i>
                    </span>
                    <h3 class="text-xl font-bold text-[#0F172A] mb-2">Proven Client Results</h3>
                    <p class="text-sm text-[#64748B] leading-relaxed mb-6">
                        Explore in-depth case studies showcasing AI automation, custom CRM software, and high-performance digital platforms built for scale.
                    </p>
                </div>
                <a href="{{ route('case-studies') }}" class="inline-flex items-center gap-2 text-sm font-bold text-[#2A4DFB] hover:text-[#0026E3] group">
                    <span>View Case Studies</span>
                    <i class="fa-solid fa-arrow-right text-xs transition-transform duration-200 group-hover:translate-x-1" aria-hidden="true"></i>
                </a>
            </div>

            {{-- Tech Blog Card --}}
            <div class="rounded-2xl bg-white p-7 sm:p-8 border border-[#CBD5E1]/70 shadow-sm hover:shadow-lg hover:border-[#2A4DFB]/40 transition duration-200 flex flex-col justify-between">
                <div>
                    <span class="inline-flex h-11 w-11 items-center justify-center rounded-xl bg-[#F0FDF4] text-[#16A34A] text-lg mb-4">
                        <i class="fa-solid fa-magnifying-glass-chart" aria-hidden="true"></i>
                    </span>
                    <h3 class="text-xl font-bold text-[#0F172A] mb-2">Engineering &amp; AI Insights</h3>
                    <p class="text-sm text-[#64748B] leading-relaxed mb-6">
                        Read our technical deep-dives into modern software architecture, generative AI systems, and enterprise engineering best practices.
                    </p>
                </div>
                <a href="{{ route('blogs') }}" class="inline-flex items-center gap-2 text-sm font-bold text-[#2A4DFB] hover:text-[#0026E3] group">
                    <span>Read Our Articles</span>
                    <i class="fa-solid fa-arrow-right text-xs transition-transform duration-200 group-hover:translate-x-1" aria-hidden="true"></i>
                </a>
            </div>
        </div>

        {{-- Urgent Contact & Return Home Strip --}}
        <div class="mt-12 rounded-2xl bg-slate-900 text-white p-6 sm:p-8 max-w-4xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-6 shadow-xl">
            <div class="text-center sm:text-left">
                <h3 class="text-lg font-bold text-white mb-1">Have an Urgent Timeline?</h3>
                <p class="text-xs sm:text-sm text-slate-300">
                    Feel free to reach out to us directly or return to exploring our main website.
                </p>
            </div>
            <div class="flex flex-wrap items-center justify-center gap-3">
                <a href="mailto:info@suavecreators.com" class="inline-flex items-center gap-2 rounded-xl bg-slate-800 hover:bg-slate-700 px-4 py-2.5 text-xs sm:text-sm font-medium text-white transition">
                    <i class="fa-solid fa-envelope text-slate-300" aria-hidden="true"></i>
                    <span>info@suavecreators.com</span>
                </a>
                <a href="{{ route('home') }}" class="inline-flex items-center gap-2 rounded-xl bg-[#2A4DFB] hover:bg-[#1E3ECC] px-5 py-2.5 text-xs sm:text-sm font-bold text-white shadow-md transition">
                    <i class="fa-solid fa-house text-xs" aria-hidden="true"></i>
                    <span>Back to Home</span>
                </a>
            </div>
        </div>
    </section>
    <!-- While You Wait / Resources End -->
@endsection
