@props([
    'id' => 'contact-modal',
    'services' => null,
    'countries' => null,
])

@php
    $servicesList = $services ?? [
        [
            'value' => 'custom-software',
            'label' => 'Custom Software Development',
            'icon' => 'fa-solid fa-desktop',
            'color' => '#2563EB',
        ],
        [
            'value' => 'custom-crm',
            'label' => 'Custom CRM Development',
            'icon' => 'fa-solid fa-terminal',
            'color' => '#059669',
        ],
        [
            'value' => 'ai-solutions',
            'label' => 'AI Solutions & Development',
            'icon' => 'fa-solid fa-brain',
            'color' => '#16A34A',
        ],
        [
            'value' => 'web-development',
            'label' => 'Web Development',
            'icon' => 'fa-solid fa-laptop-code',
            'color' => '#7C3AED',
        ],
        [
            'value' => 'ecommerce',
            'label' => 'E-commerce Development',
            'icon' => 'fa-solid fa-cart-shopping',
            'color' => '#EA580C',
        ],
        [
            'value' => 'enterprise-software',
            'label' => 'Enterprise Software Solutions',
            'icon' => 'fa-solid fa-layer-group',
            'color' => '#0D9488',
        ],
        [
            'value' => 'ui-ux-design',
            'label' => 'UI/UX Design',
            'icon' => 'fa-solid fa-pen-ruler',
            'color' => '#C026D3',
        ],
        [
            'value' => 'mobile-app',
            'label' => 'Mobile App Development',
            'icon' => 'fa-solid fa-mobile-screen-button',
            'color' => '#D97706',
        ],
        [
            'value' => 'cloud-devops',
            'label' => 'Cloud & DevOps',
            'icon' => 'fa-solid fa-cloud',
            'color' => '#0284C7',
        ],
        [
            'value' => 'digital-marketing',
            'label' => 'Digital Marketing',
            'icon' => 'fa-solid fa-bullhorn',
            'color' => '#4F46E5',
        ],
        [
            'value' => 'seo-aeo-geo',
            'label' => 'SEO (AEO & GEO)',
            'icon' => 'fa-solid fa-magnifying-glass-chart',
            'color' => '#E11D48',
        ],
    ];

    $countriesList = $countries ?? [
        ['code' => '+91', 'flag' => '🇮🇳', 'name' => 'India (+91)'],
        ['code' => '+1', 'flag' => '🇺🇸', 'name' => 'United States (+1)'],
        ['code' => '+44', 'flag' => '🇬🇧', 'name' => 'United Kingdom (+44)'],
        ['code' => '+61', 'flag' => '🇦🇺', 'name' => 'Australia (+61)'],
        ['code' => '+1', 'flag' => '🇨🇦', 'name' => 'Canada (+1)'],
        ['code' => '+971', 'flag' => '🇦🇪', 'name' => 'UAE (+971)'],
        ['code' => '+49', 'flag' => '🇩🇪', 'name' => 'Germany (+49)'],
        ['code' => '+65', 'flag' => '🇸🇬', 'name' => 'Singapore (+65)'],
    ];
@endphp

<div id="{{ $id }}"
    class="contact-modal-root fixed inset-0 z-[12000] hidden items-center justify-center p-3 sm:p-4 md:p-6 opacity-0 transition-opacity duration-300 pointer-events-none"
    role="dialog" aria-modal="true" aria-labelledby="{{ $id }}-heading" data-contact-modal-root>

    {{-- Backdrop --}}
    <div class="contact-modal__backdrop fixed inset-0 bg-[#00002A]/60 backdrop-blur-md transition-opacity duration-300"
        data-contact-modal-backdrop tabindex="-1" aria-hidden="true"></div>

    {{-- Modal Card Container --}}
    <div
        class="contact-modal__card relative z-10 w-full max-w-[960px] overflow-hidden rounded-[24px] sm:rounded-[32px] bg-white shadow-[0_25px_80px_rgba(0,0,50,0.3)] ring-1 ring-black/5 transform transition-all duration-300 scale-95 opacity-0 max-h-[92vh] flex flex-col">

        {{-- Close Button --}}
        <button type="button"
            class="contact-modal__close absolute top-3.5 right-3.5 sm:top-5 sm:right-5 z-30 inline-flex h-9 w-9 items-center justify-center rounded-full bg-slate-100/90 text-slate-500 hover:bg-slate-200 hover:text-slate-800 transition duration-200 focus:outline-none focus:ring-2 focus:ring-[#2A4DFB]/30"
            data-contact-modal-close aria-label="Close consultation modal">
            <i class="fa-solid fa-xmark text-base" aria-hidden="true"></i>
        </button>

        {{-- Two-Column Modal Body --}}
        <div class="grid grid-cols-1 lg:grid-cols-[1.2fr_0.8fr] overflow-y-auto">

            {{-- LEFT COLUMN: White Form Area --}}
            <div class="p-6 sm:p-8 lg:p-9 bg-white flex flex-col justify-between relative">

                {{-- Header info --}}
                <div>
                    <p class="text-[11px] sm:text-xs font-bold tracking-[0.16em] uppercase text-[#2A4DFB] mb-1.5 pragati-narrow-regular">
                        Let&rsquo;s Build Together
                    </p>
                    <h2 id="{{ $id }}-heading" class="text-2xl sm:text-3xl font-extrabold text-[#0B132B] tracking-tight">
                        Get a Free Consultation
                    </h2>
                    <p class="text-[13px] sm:text-sm text-[#64748B] mt-1.5 mb-6 leading-relaxed">
                        Tell us about your project and our experts will get back to you within 24 hours with the next steps.
                    </p>
                </div>

                {{-- Form element --}}
                <form action="{{ route('contact-us.store') }}" method="POST"
                    class="space-y-4" data-contact-modal-form
                    data-draft-url="{{ route('contact-us.draft') }}" novalidate>
                    @csrf
                    <input type="hidden" name="_ajax" value="1">
                    <input type="hidden" name="draft_token" value="" data-modal-draft-token>
                    <input type="hidden" name="form_started_at" value="{{ time() }}" data-modal-started>

                    {{-- Honeypot bot protection --}}
                    <div style="position: absolute; left: -9999px; opacity: 0; pointer-events: none;" aria-hidden="true">
                        <label for="{{ $id }}-website">Website</label>
                        <input id="{{ $id }}-website" type="text" name="website" tabindex="-1" autocomplete="off">
                    </div>

                    {{-- Hidden phone value combining country code & phone number --}}
                    <input type="hidden" name="phone" data-modal-phone-combined value="">

                    {{-- Row 1: Name & Email --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        {{-- Name --}}
                        <div>
                            <label for="{{ $id }}-name" class="block text-[12px] font-semibold text-[#1E293B] mb-1.5">
                                Your Name <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-[#94A3B8]">
                                    <i class="fa-regular fa-user text-xs" aria-hidden="true"></i>
                                </span>
                                <input id="{{ $id }}-name" name="name" type="text" autocomplete="name" required
                                    placeholder="Enter your name"
                                    class="w-full rounded-xl border border-[#CBD5E1] bg-white py-2.5 pl-9 pr-3 text-[13px] sm:text-sm text-[#0F172A] placeholder-[#94A3B8] transition duration-150 focus:border-[#2A4DFB] focus:outline-none focus:ring-4 focus:ring-[#2A4DFB]/10">
                            </div>
                            <span class="block text-[11px] text-red-500 font-medium mt-1" data-error-for="name" hidden></span>
                        </div>

                        {{-- Email --}}
                        <div>
                            <label for="{{ $id }}-email" class="block text-[12px] font-semibold text-[#1E293B] mb-1.5">
                                Business Email <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-[#94A3B8]">
                                    <i class="fa-regular fa-envelope text-xs" aria-hidden="true"></i>
                                </span>
                                <input id="{{ $id }}-email" name="email" type="email" inputmode="email" autocomplete="email" required
                                    placeholder="you@company.com"
                                    class="w-full rounded-xl border border-[#CBD5E1] bg-white py-2.5 pl-9 pr-3 text-[13px] sm:text-sm text-[#0F172A] placeholder-[#94A3B8] transition duration-150 focus:border-[#2A4DFB] focus:outline-none focus:ring-4 focus:ring-[#2A4DFB]/10">
                            </div>
                            <span class="block text-[11px] text-red-500 font-medium mt-1" data-error-for="email" hidden></span>
                        </div>
                    </div>

                    {{-- Row 2: Company Name & Phone Number --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        {{-- Company Name --}}
                        <div>
                            <label for="{{ $id }}-company" class="block text-[12px] font-semibold text-[#1E293B] mb-1.5">
                                Company Name
                            </label>
                            <div class="relative">
                                <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-[#94A3B8]">
                                    <i class="fa-regular fa-building text-xs" aria-hidden="true"></i>
                                </span>
                                <input id="{{ $id }}-company" name="company" type="text" autocomplete="organization"
                                    placeholder="Enter company name"
                                    class="w-full rounded-xl border border-[#CBD5E1] bg-white py-2.5 pl-9 pr-3 text-[13px] sm:text-sm text-[#0F172A] placeholder-[#94A3B8] transition duration-150 focus:border-[#2A4DFB] focus:outline-none focus:ring-4 focus:ring-[#2A4DFB]/10">
                            </div>
                            <span class="block text-[11px] text-red-500 font-medium mt-1" data-error-for="company" hidden></span>
                        </div>

                        {{-- Phone Number with Country Dropdown --}}
                        <div>
                            <label for="{{ $id }}-phone-input" class="block text-[12px] font-semibold text-[#1E293B] mb-1.5">
                                Phone Number <span class="text-red-500">*</span>
                            </label>
                            <div class="relative flex items-stretch">
                                {{-- Country Selector Trigger --}}
                                <div class="relative" data-country-dropdown-wrapper>
                                    <button type="button"
                                        class="h-full inline-flex items-center gap-1.5 rounded-l-xl border border-r-0 border-[#CBD5E1] bg-[#F8FAFC] px-2.5 sm:px-3 text-[13px] font-medium text-[#1E293B] hover:bg-[#F1F5F9] focus:outline-none focus:ring-2 focus:ring-[#2A4DFB]/20 transition"
                                        data-country-trigger aria-haspopup="listbox" aria-expanded="false" aria-label="Select country code">
                                        <span data-selected-flag>{{ $countriesList[0]['flag'] }}</span>
                                        <span data-selected-code class="text-xs font-semibold text-[#334155]">{{ $countriesList[0]['code'] }}</span>
                                        <i class="fa-solid fa-chevron-down text-[9px] text-[#64748B] transition-transform duration-200" aria-hidden="true"></i>
                                    </button>

                                    {{-- Country List Menu --}}
                                    <div class="absolute left-0 top-full mt-1.5 w-52 rounded-xl border border-[#E2E8F0] bg-white p-1.5 shadow-xl z-50 hidden max-h-48 overflow-y-auto"
                                        data-country-menu role="listbox">
                                        @foreach ($countriesList as $c)
                                            <button type="button"
                                                class="w-full flex items-center justify-between px-2.5 py-1.5 rounded-lg text-left text-xs text-[#1E293B] hover:bg-[#EEF4FF] hover:text-[#2A4DFB] transition"
                                                data-country-option data-code="{{ $c['code'] }}" data-flag="{{ $c['flag'] }}" role="option">
                                                <span class="flex items-center gap-2">
                                                    <span>{{ $c['flag'] }}</span>
                                                    <span>{{ $c['name'] }}</span>
                                                </span>
                                                <span class="font-semibold text-slate-400">{{ $c['code'] }}</span>
                                            </button>
                                        @endforeach
                                    </div>
                                </div>

                                {{-- Number Input --}}
                                <input id="{{ $id }}-phone-input" type="tel" inputmode="tel" autocomplete="tel-national" required
                                    placeholder="98765 43210" data-modal-phone-input
                                    class="w-full rounded-r-xl border border-[#CBD5E1] bg-white py-2.5 px-3 text-[13px] sm:text-sm text-[#0F172A] placeholder-[#94A3B8] transition duration-150 focus:border-[#2A4DFB] focus:outline-none focus:ring-4 focus:ring-[#2A4DFB]/10">
                            </div>
                            <span class="block text-[11px] text-red-500 font-medium mt-1" data-error-for="phone" hidden></span>
                        </div>
                    </div>

                    {{-- Row 3: Service Dropdown --}}
                    <div>
                        <label id="{{ $id }}-service-label" class="block text-[12px] font-semibold text-[#1E293B] mb-1.5">
                            Service You&rsquo;re Interested In <span class="text-red-500">*</span>
                        </label>
                        <div class="relative" data-service-dropdown-wrapper>
                            {{-- Real Hidden Service Input --}}
                            <input type="hidden" name="service" value="" data-service-value required>

                            {{-- Dropdown Trigger Button --}}
                            <button type="button"
                                class="w-full rounded-xl border border-[#CBD5E1] bg-white py-2.5 px-3.5 text-left text-[13px] sm:text-sm flex items-center justify-between text-[#94A3B8] hover:border-[#94A3B8] focus:border-[#2A4DFB] focus:outline-none focus:ring-4 focus:ring-[#2A4DFB]/10 transition duration-150"
                                data-service-trigger aria-haspopup="listbox" aria-expanded="false" aria-labelledby="{{ $id }}-service-label">
                                <span class="flex items-center gap-2.5 min-w-0">
                                    <span class="inline-flex h-5 w-5 shrink-0 items-center justify-center text-[#2A4DFB]" data-service-icon>
                                        <i class="fa-solid fa-shapes text-sm" aria-hidden="true"></i>
                                    </span>
                                    <span class="truncate text-[#94A3B8]" data-service-label>Select a service</span>
                                </span>
                                <i class="fa-solid fa-chevron-down text-[11px] text-[#64748B] shrink-0 transition-transform duration-200" aria-hidden="true" data-service-chevron></i>
                            </button>

                            {{-- Dropdown Options Menu --}}
                            <div class="absolute left-0 top-full mt-1.5 w-full rounded-xl border border-[#E2E8F0] bg-white p-1.5 shadow-2xl z-50 hidden max-h-60 overflow-y-auto"
                                data-service-menu role="listbox">
                                @foreach ($servicesList as $s)
                                    <div class="flex items-center gap-2.5 px-3 py-2 rounded-lg cursor-pointer text-[13px] text-[#1E293B] hover:bg-[#EEF4FF] hover:text-[#2A4DFB] transition group"
                                        data-service-option data-value="{{ $s['value'] }}" data-label="{{ $s['label'] }}" data-icon="{{ $s['icon'] }}" data-color="{{ $s['color'] }}" role="option">
                                        <span class="inline-flex h-6 w-6 shrink-0 items-center justify-center rounded-md" style="color: {{ $s['color'] }};">
                                            <i class="{{ $s['icon'] }} text-xs" aria-hidden="true"></i>
                                        </span>
                                        <span class="font-medium text-[#1E293B] group-hover:text-[#2A4DFB] transition-colors leading-snug">
                                            {{ $s['label'] }}
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <span class="block text-[11px] text-red-500 font-medium mt-1" data-error-for="service" hidden></span>
                    </div>

                    {{-- Form error banner --}}
                    <div class="rounded-lg bg-red-50 p-2.5 text-xs text-red-600 font-medium" data-modal-general-error hidden></div>

                    {{-- Submit Button --}}
                    <div class="pt-1">
                        <button type="submit"
                            class="w-full inline-flex items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-[#2A4DFB] to-[#0026E3] hover:from-[#1E3ECC] hover:to-[#001EC2] py-3.5 px-5 text-sm sm:text-base font-bold text-white shadow-lg shadow-indigo-950/20 transition duration-200 focus:outline-none focus:ring-4 focus:ring-[#2A4DFB]/30 disabled:opacity-75 disabled:cursor-not-allowed group cursor-pointer"
                            data-modal-submit>
                            <span data-modal-btn-text>Submit Request</span>
                            <i class="fa-solid fa-arrow-right text-xs transition-transform duration-200 group-hover:translate-x-1" aria-hidden="true"></i>
                        </button>
                    </div>

                    {{-- Trust Badge --}}
                    <p class="text-center text-[11px] sm:text-xs text-[#64748B] flex items-center justify-center gap-1.5 pt-1">
                        <i class="fa-solid fa-lock text-[10px] text-[#64748B]" aria-hidden="true"></i>
                        <span>Your information is secure and will never be shared.</span>
                    </p>
                </form>

                {{-- Success Screen Overlay --}}
                <div class="absolute inset-0 bg-white/98 backdrop-blur-sm rounded-l-[24px] sm:rounded-l-[32px] p-8 flex flex-col items-center justify-center text-center z-40 hidden opacity-0 transition-opacity duration-300"
                    data-modal-success-screen>
                    <div class="h-16 w-16 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center text-2xl mb-4 shadow-md shadow-emerald-500/10">
                        <i class="fa-solid fa-check" aria-hidden="true"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-[#0F172A] tracking-tight">
                        Thank You!
                    </h3>
                    <p class="text-sm text-[#64748B] max-w-sm mt-2 mb-6 leading-relaxed" data-modal-success-message>
                        Your consultation request has been sent successfully. One of our solution architects will contact you within 24 hours.
                    </p>
                    <button type="button"
                        class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#0F172A] hover:bg-[#1E293B] text-white font-semibold py-2.5 px-6 text-sm transition"
                        data-contact-modal-close>
                        Done
                    </button>
                </div>
            </div>

            {{-- RIGHT COLUMN: Soft Blue Feature Card --}}
            <div class="p-6 sm:p-8 lg:p-9 bg-gradient-to-br from-[#EEF4FF] via-[#F3F6FF] to-[#E8F0FE] flex flex-col justify-between border-t lg:border-t-0 lg:border-l border-[#E2E8F0]/70 relative overflow-hidden">
                <div class="pointer-events-none absolute -right-20 -top-20 h-56 w-56 rounded-full bg-[#2A4DFB]/10 blur-2xl" aria-hidden="true"></div>

                <div>
                    {{-- Pill Badge --}}
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-[#DBEAFE] text-[#1D4ED8] text-[11px] font-bold tracking-wider uppercase">
                        <i class="fa-solid fa-bolt text-[10px]" aria-hidden="true"></i>
                        <span>Free Consultation</span>
                    </span>

                    {{-- Right Heading --}}
                    <h3 class="text-xl sm:text-2xl font-extrabold text-[#0B132B] mt-4 mb-6 leading-tight">
                        Turn Your Ideas<br>
                        Into Real Solutions
                    </h3>

                    {{-- Feature List --}}
                    <div class="space-y-4">
                        {{-- Feature 1 --}}
                        <div class="flex items-start gap-3.5">
                            <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-[#EEF2FF] text-[#4F46E5] shadow-sm">
                                <i class="fa-solid fa-rocket text-sm" aria-hidden="true"></i>
                            </span>
                            <div>
                                <h4 class="text-[13px] sm:text-sm font-bold text-[#0F172A]">Expert Guidance</h4>
                                <p class="text-[12px] text-[#64748B] mt-0.5 leading-snug">Discuss your requirements with our technical experts</p>
                            </div>
                        </div>

                        {{-- Feature 2 --}}
                        <div class="flex items-start gap-3.5">
                            <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-[#DBEAFE] text-[#2563EB] shadow-sm">
                                <i class="fa-regular fa-clock text-sm" aria-hidden="true"></i>
                            </span>
                            <div>
                                <h4 class="text-[13px] sm:text-sm font-bold text-[#0F172A]">Quick Response</h4>
                                <p class="text-[12px] text-[#64748B] mt-0.5 leading-snug">Get a reply within 24 hours</p>
                            </div>
                        </div>

                        {{-- Feature 3 --}}
                        <div class="flex items-start gap-3.5">
                            <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-[#E0E7FF] text-[#3B82F6] shadow-sm">
                                <i class="fa-solid fa-gear text-sm" aria-hidden="true"></i>
                            </span>
                            <div>
                                <h4 class="text-[13px] sm:text-sm font-bold text-[#0F172A]">Tailored Solutions</h4>
                                <p class="text-[12px] text-[#64748B] mt-0.5 leading-snug">Recommendations aligned with your business goals</p>
                            </div>
                        </div>

                        {{-- Feature 4 --}}
                        <div class="flex items-start gap-3.5">
                            <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-[#D1FAE5] text-[#059669] shadow-sm">
                                <i class="fa-solid fa-shield-halved text-sm" aria-hidden="true"></i>
                            </span>
                            <div>
                                <h4 class="text-[13px] sm:text-sm font-bold text-[#0F172A]">Complete Confidentiality</h4>
                                <p class="text-[12px] text-[#64748B] mt-0.5 leading-snug">Your ideas and data are always safe with us</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Bottom Handwritten Text with Arrow --}}
                <div class="pt-8 pb-2 flex items-center justify-end gap-2 text-[#4361EE]">
                    {{-- Curving SVG Arrow --}}
                    <svg class="w-10 h-10 text-[#4361EE] -rotate-6 shrink-0 opacity-80" viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M10 38 C 12 24, 22 14, 38 18" />
                        <path d="M38 18 L 30 14" />
                        <path d="M38 18 L 34 26" />
                    </svg>
                    <p class="font-serif italic font-medium text-sm sm:text-base leading-tight tracking-wide text-[#3B82F6]">
                        Let&rsquo;s create<br>
                        something amazing<br>
                        together!
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

@once
@push('scripts')
<script>
    (function () {
        var modalRoot = document.querySelector('[data-contact-modal-root]');
        if (!modalRoot) return;

        var modalBackdrop = modalRoot.querySelector('[data-contact-modal-backdrop]');
        var modalCard = modalRoot.querySelector('.contact-modal__card');
        var form = modalRoot.querySelector('[data-contact-modal-form]');
        var closeButtons = modalRoot.querySelectorAll('[data-contact-modal-close]');
        var successScreen = modalRoot.querySelector('[data-modal-success-screen]');
        var successMessageEl = modalRoot.querySelector('[data-modal-success-message]');
        var submitBtn = modalRoot.querySelector('[data-modal-submit]');
        var btnTextEl = modalRoot.querySelector('[data-modal-btn-text]');
        var generalError = modalRoot.querySelector('[data-modal-general-error]');
        var originalBtnText = btnTextEl ? btnTextEl.textContent : 'Submit Request';

        // Service dropdown elements
        var serviceDropdownWrapper = modalRoot.querySelector('[data-service-dropdown-wrapper]');
        var serviceTrigger = modalRoot.querySelector('[data-service-trigger]');
        var serviceMenu = modalRoot.querySelector('[data-service-menu]');
        var serviceLabel = modalRoot.querySelector('[data-service-label]');
        var serviceIcon = modalRoot.querySelector('[data-service-icon]');
        var serviceInput = modalRoot.querySelector('[data-service-value]');
        var serviceChevron = modalRoot.querySelector('[data-service-chevron]');

        // Country dropdown elements
        var countryDropdownWrapper = modalRoot.querySelector('[data-country-dropdown-wrapper]');
        var countryTrigger = modalRoot.querySelector('[data-country-trigger]');
        var countryMenu = modalRoot.querySelector('[data-country-menu]');
        var selectedFlagEl = modalRoot.querySelector('[data-selected-flag]');
        var selectedCodeEl = modalRoot.querySelector('[data-selected-code]');
        var phoneInput = modalRoot.querySelector('[data-modal-phone-input]');
        var phoneCombinedInput = modalRoot.querySelector('[data-modal-phone-combined]');

        var currentCountryCode = '+91';
        var draftTokenInput = modalRoot.querySelector('[data-modal-draft-token]');
        var draftUrl = form ? form.getAttribute('data-draft-url') : '';
        var csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
        var DRAFT_STORAGE_KEY = 'suave_contact_modal_draft_v1';
        var draftTimer = null;
        var draftAbort = null;
        var isSubmitting = false;

        function updateCombinedPhone() {
            var raw = phoneInput ? phoneInput.value.trim() : '';
            if (phoneCombinedInput) {
                phoneCombinedInput.value = raw ? (currentCountryCode + ' ' + raw) : '';
            }
        }

        function openModal(defaultService) {
            modalRoot.classList.remove('hidden');
            document.body.style.overflow = 'hidden';

            // Pre-select service if requested
            if (defaultService) {
                var matchOption = modalRoot.querySelector('[data-service-option][data-value="' + defaultService + '"]');
                if (matchOption) {
                    selectServiceOption(matchOption);
                }
            }

            requestAnimationFrame(function () {
                modalRoot.classList.remove('opacity-0', 'pointer-events-none');
                if (modalCard) {
                    modalCard.classList.remove('scale-95', 'opacity-0');
                    modalCard.classList.add('scale-100', 'opacity-100');
                }
            });
        }

        function closeModal() {
            if (modalCard) {
                modalCard.classList.remove('scale-100', 'opacity-100');
                modalCard.classList.add('scale-95', 'opacity-0');
            }
            modalRoot.classList.add('opacity-0', 'pointer-events-none');

            setTimeout(function () {
                modalRoot.classList.add('hidden');
                document.body.style.overflow = '';
                if (successScreen) {
                    successScreen.classList.add('hidden', 'opacity-0');
                }
            }, 300);
        }

        // Global functions for anywhere in site
        window.openContactModal = openModal;
        window.closeContactModal = closeModal;

        // Auto wire up trigger links/buttons: [data-open-contact-modal], a[href="#contact-modal"]
        document.addEventListener('click', function (e) {
            var trigger = e.target.closest('[data-open-contact-modal], a[href="#contact-modal"]');
            if (trigger) {
                e.preventDefault();
                var svc = trigger.getAttribute('data-service') || '';
                openModal(svc);
            }
        });

        window.addEventListener('suave:open-contact-modal', function (e) {
            var svc = (e.detail && e.detail.service) || '';
            openModal(svc);
        });

        // Close listeners
        closeButtons.forEach(function (btn) {
            btn.addEventListener('click', closeModal);
        });

        if (modalBackdrop) {
            modalBackdrop.addEventListener('click', closeModal);
        }

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && !modalRoot.classList.contains('hidden')) {
                closeModal();
            }
        });

        // Service dropdown toggle
        function toggleServiceMenu(open) {
            var isOpen = open !== undefined ? open : serviceMenu.classList.contains('hidden');
            if (isOpen) {
                serviceMenu.classList.remove('hidden');
                serviceTrigger.setAttribute('aria-expanded', 'true');
                if (serviceChevron) serviceChevron.classList.add('rotate-180');
            } else {
                serviceMenu.classList.add('hidden');
                serviceTrigger.setAttribute('aria-expanded', 'false');
                if (serviceChevron) serviceChevron.classList.remove('rotate-180');
            }
        }

        if (serviceTrigger) {
            serviceTrigger.addEventListener('click', function (e) {
                e.stopPropagation();
                toggleCountryMenu(false);
                toggleServiceMenu();
            });
        }

        function selectServiceOption(opt) {
            var val = opt.getAttribute('data-value') || '';
            var label = opt.getAttribute('data-label') || '';
            var iconClass = opt.getAttribute('data-icon') || 'fa-solid fa-shapes';
            var color = opt.getAttribute('data-color') || '#2A4DFB';

            if (serviceInput) serviceInput.value = val;
            if (serviceLabel) {
                serviceLabel.textContent = label;
                serviceLabel.classList.remove('text-[#94A3B8]');
                serviceLabel.classList.add('text-[#0F172A]', 'font-medium');
            }
            if (serviceIcon) {
                serviceIcon.innerHTML = '<i class="' + iconClass + ' text-sm" style="color: ' + color + ';"></i>';
            }

            clearFieldError('service');
            toggleServiceMenu(false);
            scheduleDraftSave();
        }

        modalRoot.querySelectorAll('[data-service-option]').forEach(function (opt) {
            opt.addEventListener('click', function (e) {
                e.stopPropagation();
                selectServiceOption(opt);
            });
        });

        // Country dropdown toggle
        function toggleCountryMenu(open) {
            if (!countryMenu) return;
            var isOpen = open !== undefined ? open : countryMenu.classList.contains('hidden');
            if (isOpen) {
                countryMenu.classList.remove('hidden');
                countryTrigger.setAttribute('aria-expanded', 'true');
            } else {
                countryMenu.classList.add('hidden');
                countryTrigger.setAttribute('aria-expanded', 'false');
            }
        }

        if (countryTrigger) {
            countryTrigger.addEventListener('click', function (e) {
                e.stopPropagation();
                toggleServiceMenu(false);
                toggleCountryMenu();
            });
        }

        modalRoot.querySelectorAll('[data-country-option]').forEach(function (opt) {
            opt.addEventListener('click', function (e) {
                e.stopPropagation();
                var code = opt.getAttribute('data-code') || '+91';
                var flag = opt.getAttribute('data-flag') || '🇮🇳';
                currentCountryCode = code;
                if (selectedFlagEl) selectedFlagEl.textContent = flag;
                if (selectedCodeEl) selectedCodeEl.textContent = code;
                updateCombinedPhone();
                toggleCountryMenu(false);
                if (phoneInput) phoneInput.focus();
                scheduleDraftSave();
            });
        });

        // Close dropdown menus when clicking outside them
        document.addEventListener('click', function (e) {
            if (serviceDropdownWrapper && !serviceDropdownWrapper.contains(e.target)) {
                toggleServiceMenu(false);
            }
            if (countryDropdownWrapper && !countryDropdownWrapper.contains(e.target)) {
                toggleCountryMenu(false);
            }
        });

        // Draft token helper
        function createDraftToken() {
            if (window.crypto && typeof window.crypto.randomUUID === 'function') {
                return window.crypto.randomUUID();
            }
            return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function (char) {
                var rand = Math.random() * 16 | 0;
                var value = char === 'x' ? rand : (rand & 0x3 | 0x8);
                return value.toString(16);
            });
        }

        function ensureDraftToken() {
            var token = (draftTokenInput && draftTokenInput.value.trim()) || '';
            if (!token) {
                try {
                    token = sessionStorage.getItem(DRAFT_STORAGE_KEY) || '';
                } catch (e) {}
            }
            if (!token) {
                token = createDraftToken();
            }
            if (draftTokenInput) {
                draftTokenInput.value = token;
            }
            try {
                sessionStorage.setItem(DRAFT_STORAGE_KEY, token);
            } catch (e) {}
            return token;
        }

        function clearFieldError(field) {
            var err = modalRoot.querySelector('[data-error-for="' + field + '"]');
            if (err) {
                err.hidden = true;
                err.textContent = '';
            }
            var el = form ? form.querySelector('[name="' + field + '"]') : null;
            if (el) {
                el.classList.remove('border-red-500', 'focus:border-red-500', 'focus:ring-red-500/20');
            }
            if (generalError) {
                generalError.hidden = true;
                generalError.textContent = '';
            }
        }

        function showFieldError(field, msg) {
            var err = modalRoot.querySelector('[data-error-for="' + field + '"]');
            if (err) {
                err.textContent = msg;
                err.hidden = false;
            }
            var el = form ? form.querySelector('[name="' + field + '"]') : null;
            if (el) {
                el.classList.add('border-red-500', 'focus:border-red-500', 'focus:ring-red-500/20');
            }
        }

        function clearAllErrors() {
            ['name', 'email', 'company', 'phone', 'service'].forEach(clearFieldError);
            if (generalError) {
                generalError.hidden = true;
                generalError.textContent = '';
            }
        }

        function saveDraft() {
            if (isSubmitting || !draftUrl || !form) return;
            updateCombinedPhone();

            var token = ensureDraftToken();
            var body = new FormData();
            body.append('draft_token', token);
            body.append('name', (form.querySelector('[name="name"]')?.value || '').trim());
            body.append('email', (form.querySelector('[name="email"]')?.value || '').trim());
            body.append('company', (form.querySelector('[name="company"]')?.value || '').trim());
            body.append('phone', phoneCombinedInput ? phoneCombinedInput.value.trim() : '');
            body.append('service', serviceInput ? serviceInput.value.trim() : '');

            if (draftAbort) draftAbort.abort();
            draftAbort = new AbortController();

            fetch(draftUrl, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': csrf,
                },
                body: body,
                credentials: 'same-origin',
                signal: draftAbort.signal,
            }).catch(function () {});
        }

        function scheduleDraftSave() {
            if (draftTimer) clearTimeout(draftTimer);
            draftTimer = setTimeout(saveDraft, 800);
        }

        // Field change listeners
        if (form) {
            ['name', 'email', 'company'].forEach(function (name) {
                var input = form.querySelector('[name="' + name + '"]');
                if (input) {
                    input.addEventListener('input', function () {
                        clearFieldError(name);
                        scheduleDraftSave();
                    });
                    input.addEventListener('blur', function () {
                        saveDraft();
                    });
                }
            });

            if (phoneInput) {
                phoneInput.addEventListener('input', function () {
                    clearFieldError('phone');
                    updateCombinedPhone();
                    scheduleDraftSave();
                });
                phoneInput.addEventListener('blur', function () {
                    updateCombinedPhone();
                    saveDraft();
                });
            }
        }

        // Form Submit
        if (form) {
            form.addEventListener('submit', function (e) {
                e.preventDefault();
                clearAllErrors();
                updateCombinedPhone();

                var nameVal = (form.querySelector('[name="name"]')?.value || '').trim();
                var emailVal = (form.querySelector('[name="email"]')?.value || '').trim();
                var phoneVal = phoneInput ? phoneInput.value.trim() : '';
                var serviceVal = serviceInput ? serviceInput.value.trim() : '';

                var hasError = false;

                if (!nameVal) {
                    showFieldError('name', 'Please enter your name.');
                    hasError = true;
                }

                var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailVal) {
                    showFieldError('email', 'Please enter your business email.');
                    hasError = true;
                } else if (!emailPattern.test(emailVal)) {
                    showFieldError('email', 'Please enter a valid email address.');
                    hasError = true;
                }

                if (!phoneVal) {
                    showFieldError('phone', 'Please enter your phone number.');
                    hasError = true;
                } else if (phoneVal.length < 5) {
                    showFieldError('phone', 'Please enter a valid phone number.');
                    hasError = true;
                }

                if (!serviceVal) {
                    showFieldError('service', 'Please select a service.');
                    hasError = true;
                }

                if (hasError) return;

                isSubmitting = true;
                if (submitBtn) {
                    submitBtn.disabled = true;
                }
                if (btnTextEl) {
                    btnTextEl.textContent = 'Submitting Request…';
                }

                ensureDraftToken();
                var body = new FormData(form);

                fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': csrf,
                    },
                    body: body,
                    credentials: 'same-origin',
                })
                .then(async function (response) {
                    var data = await response.json().catch(function () { return {}; });

                    if (response.status === 422) {
                        isSubmitting = false;
                        if (data.errors) {
                            Object.keys(data.errors).forEach(function (key) {
                                var msg = data.errors[key][0] || 'Invalid field';
                                showFieldError(key, msg);
                            });
                        } else if (generalError) {
                            generalError.textContent = data.message || 'Please verify your inputs.';
                            generalError.hidden = false;
                        }
                        return;
                    }

                    if (!response.ok || data.success === false) {
                        isSubmitting = false;
                        if (generalError) {
                            generalError.textContent = data.message || 'Unable to submit request. Please try again.';
                            generalError.hidden = false;
                        }
                        return;
                    }

                    // Lead tracking
                    if (data.lead_tracked !== false && typeof window.suaveTrackEvent === 'function') {
                        window.suaveTrackEvent('generate_lead', {
                            lead_type: 'consultation_modal',
                            service: serviceVal,
                            form_name: 'contact_modal',
                        });
                    }

                    // Reset form & token
                    form.reset();
                    if (serviceInput) serviceInput.value = '';
                    if (serviceLabel) {
                        serviceLabel.textContent = 'Select a service';
                        serviceLabel.classList.add('text-[#94A3B8]');
                        serviceLabel.classList.remove('text-[#0F172A]', 'font-medium');
                    }
                    if (serviceIcon) {
                        serviceIcon.innerHTML = '<i class="fa-solid fa-shapes text-sm" aria-hidden="true"></i>';
                    }
                    if (phoneCombinedInput) phoneCombinedInput.value = '';
                    try {
                        sessionStorage.removeItem(DRAFT_STORAGE_KEY);
                    } catch (e) {}
                    if (draftTokenInput) draftTokenInput.value = '';

                    // Display success screen inside modal
                    if (successScreen) {
                        if (data.message && successMessageEl) {
                            successMessageEl.textContent = data.message;
                        }
                        successScreen.classList.remove('hidden');
                        requestAnimationFrame(function () {
                            successScreen.classList.remove('opacity-0');
                        });
                    }
                })
                .catch(function () {
                    if (generalError) {
                        generalError.textContent = 'A network error occurred. Please try again.';
                        generalError.hidden = false;
                    }
                })
                .finally(function () {
                    isSubmitting = false;
                    if (submitBtn) {
                        submitBtn.disabled = false;
                    }
                    if (btnTextEl) {
                        btnTextEl.textContent = originalBtnText;
                    }
                });
            });
        }
    })();
</script>
@endpush
@endonce
