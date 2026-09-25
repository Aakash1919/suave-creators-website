@props([
    'id' => 'contact-modal',
    'services' => null,
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
@endphp

<div id="{{ $id }}"
    class="contact-modal-root fixed inset-0 z-[12000] hidden flex items-center justify-center p-3 sm:p-4 md:p-6 opacity-0 transition-opacity duration-300 pointer-events-none overflow-x-hidden"
    role="dialog" aria-modal="true" aria-labelledby="{{ $id }}-heading" data-contact-modal-root>

    {{-- Backdrop --}}
    <div class="contact-modal__backdrop fixed inset-0 bg-[#00002A]/60 backdrop-blur-md transition-opacity duration-300"
        data-contact-modal-backdrop tabindex="-1" aria-hidden="true"></div>

    {{-- Modal Card Container --}}
    <div
        class="contact-modal__card relative z-10 w-full max-w-[560px] lg:max-w-[960px] m-auto overflow-hidden rounded-[24px] sm:rounded-[32px] bg-white shadow-[0_25px_80px_rgba(0,0,50,0.3)] ring-1 ring-black/5 transform transition-all duration-300 scale-95 opacity-0 max-h-[92vh] flex flex-col">

        {{-- Close Button --}}
        <button type="button"
            class="contact-modal__close absolute top-3.5 right-3.5 sm:top-5 sm:right-5 z-30 inline-flex h-9 w-9 items-center justify-center rounded-full bg-slate-100/90 text-slate-500 hover:bg-slate-200 hover:text-slate-800 transition duration-200 focus:outline-none focus:ring-2 focus:ring-[#2A4DFB]/30"
            data-contact-modal-close aria-label="Close consultation modal">
            <i class="fa-solid fa-xmark text-base" aria-hidden="true"></i>
        </button>

        {{-- Two-Column Modal Body --}}
        <div class="grid grid-cols-1 lg:grid-cols-[1.2fr_0.8fr] overflow-y-auto overflow-x-hidden w-full min-w-0">

            {{-- LEFT COLUMN: White Form Area --}}
            <div class="p-5 sm:p-8 lg:p-9 bg-white flex flex-col justify-between relative min-w-0 max-w-full overflow-x-hidden">

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
                    <input type="hidden" name="_redirect" value="{{ route('thank-you') }}">
                    <input type="hidden" name="draft_token" value="" data-modal-draft-token>
                    <input type="hidden" name="form_started_at" value="{{ time() }}" data-modal-started>

                    {{-- Honeypot bot protection --}}
                    <div class="sr-only" aria-hidden="true" tabindex="-1">
                        <label for="{{ $id }}-website">Website</label>
                        <input id="{{ $id }}-website" type="text" name="website" tabindex="-1" autocomplete="off">
                    </div>

                    {{-- Row 1: Name & Email --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        {{-- Name --}}
                        <div class="min-w-0">
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
                        <div class="min-w-0">
                            <label for="{{ $id }}-email" class="block text-[12px] font-semibold text-[#1E293B] mb-1.5">
                                Email <span class="text-red-500">*</span>
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

                    {{-- Row 2: Service & Phone Number --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        {{-- Service Dropdown --}}
                        <div class="min-w-0">
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

                        {{-- Phone Number with intl-tel-input --}}
                        <div class="min-w-0">
                            <label for="{{ $id }}-phone" class="block text-[12px] font-semibold text-[#1E293B] mb-1.5">
                                Phone Number <span class="text-red-500">*</span>
                            </label>
                            <x-frontend.phone-field
                                id="{{ $id }}-phone"
                                name="phone"
                                label="Phone Number"
                                placeholder="98765 43210"
                                :show-label="false"
                            />
                        </div>
                    </div>

                    {{-- Row 4: Project Details / Message --}}
                    <div>
                        <label for="{{ $id }}-message" class="block text-[12px] font-semibold text-[#1E293B] mb-1.5">
                            Project Details / Message <span class="text-slate-400 font-normal text-[11px]">(Optional)</span>
                        </label>
                        <div class="relative">
                            <textarea id="{{ $id }}-message" name="message" rows="2"
                                placeholder="Tell us briefly about your project or what you want to build..."
                                class="w-full rounded-xl border border-[#CBD5E1] bg-white py-2 px-3 text-[13px] sm:text-sm text-[#0F172A] placeholder-[#94A3B8] transition duration-150 focus:border-[#2A4DFB] focus:outline-none focus:ring-4 focus:ring-[#2A4DFB]/10 resize-none"></textarea>
                        </div>
                        <span class="block text-[11px] text-red-500 font-medium mt-1" data-error-for="message" hidden></span>
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
                    <p class="text-center text-[11px] sm:text-xs text-[#64748B] flex flex-wrap items-center justify-center gap-1.5 pt-1">
                        <i class="fa-solid fa-lock text-[10px] text-[#64748B]" aria-hidden="true"></i>
                        <span>Your information is secure and will never be shared.</span>
                    </p>
                </form>

                {{-- Success Screen Overlay --}}
                <div class="absolute inset-0 bg-white/98 backdrop-blur-sm rounded-[24px] sm:rounded-l-[32px] p-6 sm:p-8 flex flex-col items-center justify-center text-center z-40 hidden opacity-0 transition-opacity duration-300 overflow-hidden"
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

            {{-- RIGHT COLUMN: Soft Blue Feature Card (hidden on mobile, visible on desktop) --}}
            <div class="hidden lg:flex flex-col justify-between p-6 sm:p-8 lg:p-9 bg-gradient-to-br from-[#EEF4FF] via-[#F3F6FF] to-[#E8F0FE] border-t lg:border-t-0 lg:border-l border-[#E2E8F0]/70 relative overflow-hidden">
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

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@29.5.2/dist/css/intlTelInput.min.css">

<style>
/* Center modal in the middle of page horizontally & vertically */
.contact-modal-root {
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    overflow-x: hidden !important;
}
.contact-modal-root.hidden {
    display: none !important;
}
.contact-modal-root .contact-modal__card {
    margin: auto !important;
    overflow-x: hidden !important;
}

/* Scoped intl-tel-input styling inside Contact Modal */
.contact-modal-root .suave-phone-field {
    display: block;
    width: 100%;
    max-width: 100%;
    min-width: 0;
    position: relative;
}
.contact-modal-root .suave-phone-field .iti {
    width: 100%;
    max-width: 100%;
    min-width: 0;
    display: flex;
    align-items: stretch;
    background: #ffffff;
    border: 1px solid #CBD5E1;
    border-radius: 0.75rem; /* rounded-xl */
    transition: border-color 0.15s ease, box-shadow 0.15s ease;
    position: relative;
    box-sizing: border-box;
    overflow: visible;
}
.contact-modal-root .suave-phone-field .iti:hover {
    border-color: #94A3B8;
}
.contact-modal-root .suave-phone-field .iti:has(.iti__tel-input:focus),
.contact-modal-root .suave-phone-field .iti.iti--focus {
    border-color: #2A4DFB;
    box-shadow: 0 0 0 4px rgba(42, 77, 251, 0.1);
}
.contact-modal-root .suave-phone-field .iti.is-invalid {
    border-color: #EF4444 !important;
    box-shadow: 0 0 0 4px rgba(239, 68, 68, 0.15) !important;
}
.contact-modal-root .suave-phone-field .iti__country-container {
    display: flex;
    align-items: stretch;
    position: relative;
    flex-shrink: 0;
}
.contact-modal-root .suave-phone-field .iti__selected-country {
    background: #F8FAFC;
    border: none;
    border-right: 1px solid #CBD5E1;
    border-radius: 0.75rem 0 0 0.75rem;
    padding: 0 8px 0 10px;
    height: 100%;
    display: flex;
    align-items: center;
    gap: 6px;
    cursor: pointer;
    transition: background-color 0.15s ease;
    flex-shrink: 0;
}
.contact-modal-root .suave-phone-field .iti__selected-country:hover {
    background: #F1F5F9;
}
.contact-modal-root .suave-phone-field .iti__selected-country-primary {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 0 !important;
    margin: 0 !important;
    height: 100%;
}
.contact-modal-root .suave-phone-field .iti__selected-country-primary .iti__flag {
    margin: 0 !important;
    flex-shrink: 0;
}
.contact-modal-root .suave-phone-field .iti__arrow {
    margin: 0 !important;
    border-right: 1.5px solid #64748B !important;
    border-bottom: 1.5px solid #64748B !important;
    width: 5px !important;
    height: 5px !important;
    box-sizing: border-box;
    transform: rotate(45deg);
    transition: transform 0.15s ease;
    margin-top: -2px !important;
}
.contact-modal-root .suave-phone-field .iti__arrow--up,
.contact-modal-root .suave-phone-field .iti__selected-country[aria-expanded="true"] .iti__arrow {
    margin-top: 2px !important;
    transform: rotate(-135deg) !important;
}
.contact-modal-root .suave-phone-field .iti__selected-dial-code {
    font-size: 13px;
    font-weight: 600;
    color: #1E293B;
    margin: 0 !important;
    white-space: nowrap;
}
.contact-modal-root .suave-phone-field .iti__tel-input {
    flex: 1 1 0% !important;
    min-width: 0 !important;
    width: 0 !important;
    background: transparent !important;
    border: none !important;
    outline: none !important;
    box-shadow: none !important;
    padding: 0.625rem 0.75rem !important; /* py-2.5 px-3 */
    font-size: 13px !important;
    line-height: 1.25rem !important;
    color: #0F172A !important;
    border-radius: 0 0.75rem 0.75rem 0 !important;
    box-sizing: border-box !important;
}
@media (min-width: 640px) {
    .contact-modal-root .suave-phone-field .iti__tel-input {
        font-size: 14px !important;
    }
}
.contact-modal-root .suave-phone-field .iti__tel-input::placeholder {
    color: #94A3B8;
}
.contact-modal-root .suave-phone-field .iti__country-selector {
    position: absolute;
    top: calc(100% + 6px) !important;
    left: 0 !important;
    z-index: 100 !important;
    width: 290px;
    max-width: calc(100vw - 48px) !important;
    background: #ffffff;
    border: 1px solid #CBD5E1;
    border-radius: 0.75rem;
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.15), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
    max-height: 250px;
    overflow: hidden;
}
@media (max-width: 640px) {
    .contact-modal-root .suave-phone-field .iti__country-selector {
        width: min(280px, calc(100vw - 48px)) !important;
        max-width: calc(100vw - 48px) !important;
    }
}
.contact-modal-root .suave-phone-field .iti__search-input-wrapper {
    position: relative;
    padding: 8px 10px;
    border-bottom: 1px solid #F1F5F9;
    box-sizing: border-box;
    display: flex;
    align-items: center;
}
.contact-modal-root .suave-phone-field .iti__search-icon {
    position: absolute !important;
    left: 20px !important;
    top: 50% !important;
    transform: translateY(-50%) !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    pointer-events: none !important;
    z-index: 5 !important;
}
.contact-modal-root .suave-phone-field .iti__search-icon-svg {
    width: 14px !important;
    height: 14px !important;
    stroke: #64748B !important;
    display: block !important;
}
.contact-modal-root .suave-phone-field .iti__search-input {
    width: 100% !important;
    height: 36px !important;
    border: 1px solid #CBD5E1 !important;
    border-radius: 0.5rem !important;
    padding: 0 12px 0 34px !important;
    font-size: 13px !important;
    outline: none !important;
    box-sizing: border-box !important;
    background: #F8FAFC !important;
    color: #0F172A !important;
    transition: all 0.15s ease;
}
.contact-modal-root .suave-phone-field .iti__search-input:focus {
    border-color: #2A4DFB !important;
    background: #ffffff !important;
    box-shadow: 0 0 0 3px rgba(42, 77, 251, 0.12) !important;
}
.contact-modal-root .suave-phone-field .iti__country-list {
    max-height: 190px;
    overflow-y: auto;
    margin: 0;
    padding: 4px 0;
    list-style: none;
}
.contact-modal-root .suave-phone-field .iti__country {
    padding: 8px 12px;
    font-size: 13px;
    display: flex;
    align-items: center;
    gap: 10px;
    cursor: pointer;
    color: #1E293B;
    transition: background-color 0.15s ease;
    min-width: 0;
}
.contact-modal-root .suave-phone-field .iti__country:hover,
.contact-modal-root .suave-phone-field .iti__country.iti__highlight {
    background: #EEF4FF;
    color: #2A4DFB;
}
.contact-modal-root .suave-phone-field .iti__country .iti__flag {
    margin-right: 2px !important;
    flex-shrink: 0;
}
.contact-modal-root .suave-phone-field .iti__country-name {
    font-size: 13px;
    color: #1E293B;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    min-width: 0;
}
.contact-modal-root .suave-phone-field .iti__dial-code {
    font-size: 12px;
    font-weight: 500;
    color: #64748B;
    margin-left: 4px;
    white-space: nowrap;
}
.contact-modal-root .suave-phone-field .contact-form-panel__field-error,
.contact-modal-root [data-error-for="phone"] {
    display: block;
    font-size: 11px;
    font-weight: 500;
    color: #EF4444;
    margin-top: 0.25rem;
}
</style>

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

        // Phone field elements
        var phoneInput = modalRoot.querySelector('[data-phone-field-input]');
        var phoneHiddenInput = modalRoot.querySelector('[data-phone-field-value]');

        var draftTokenInput = modalRoot.querySelector('[data-modal-draft-token]');
        var draftUrl = form ? form.getAttribute('data-draft-url') : '';
        var csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
        var DRAFT_STORAGE_KEY = 'suave_contact_modal_draft_v1';
        var draftTimer = null;
        var draftAbort = null;
        var isSubmitting = false;

        function getPhoneValue() {
            if (window.SuavePhoneField) {
                return window.SuavePhoneField.phoneValue(form);
            }
            return ((phoneHiddenInput && phoneHiddenInput.value) || (phoneInput && phoneInput.value) || '').trim();
        }

        function initPhoneField() {
            if (window.SuavePhoneField) {
                window.SuavePhoneField.initAll(modalRoot);
            }
        }

        function openModal(defaultService) {
            modalRoot.classList.remove('hidden');
            modalRoot.classList.add('flex');
            document.body.style.overflow = 'hidden';

            // Reset modal internal scroll position to top
            if (modalCard) {
                modalCard.scrollTop = 0;
                var scrollers = modalCard.querySelectorAll('.overflow-y-auto');
                scrollers.forEach(function (el) { el.scrollTop = 0; });
            }

            // Ensure phone field is initialized
            initPhoneField();
            if (!window.SuavePhoneField) {
                var checkIti = setInterval(function () {
                    if (window.SuavePhoneField) {
                        clearInterval(checkIti);
                        window.SuavePhoneField.initAll(modalRoot);
                    }
                }, 50);
                setTimeout(function () { clearInterval(checkIti); }, 3000);
            }

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
                modalRoot.classList.remove('flex');
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

        // Close dropdown menus when clicking outside them
        document.addEventListener('click', function (e) {
            if (serviceDropdownWrapper && !serviceDropdownWrapper.contains(e.target)) {
                toggleServiceMenu(false);
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
            if (field === 'phone') {
                if (window.SuavePhoneField) {
                    window.SuavePhoneField.setInvalid(form, false);
                }
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
            if (field === 'phone') {
                if (window.SuavePhoneField) {
                    window.SuavePhoneField.setInvalid(form, true);
                }
            }
            var el = form ? form.querySelector('[name="' + field + '"]') : null;
            if (el) {
                el.classList.add('border-red-500', 'focus:border-red-500', 'focus:ring-red-500/20');
            }
        }

        function clearAllErrors() {
            ['name', 'email', 'company', 'phone', 'service', 'message'].forEach(clearFieldError);
            if (generalError) {
                generalError.hidden = true;
                generalError.textContent = '';
            }
        }

        function saveDraft() {
            if (isSubmitting || !draftUrl || !form) return;
            if (window.SuavePhoneField) {
                window.SuavePhoneField.syncAll(form);
            }

            var token = ensureDraftToken();
            var body = new FormData();
            body.append('draft_token', token);
            body.append('name', (form.querySelector('[name="name"]')?.value || '').trim());
            body.append('email', (form.querySelector('[name="email"]')?.value || '').trim());
            body.append('phone', getPhoneValue());
            body.append('service', serviceInput ? serviceInput.value.trim() : '');
            body.append('message', (form.querySelector('[name="message"]')?.value || '').trim());

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
            ['name', 'email', 'message'].forEach(function (name) {
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
                    if (window.SuavePhoneField) {
                        window.SuavePhoneField.syncAll(form);
                        window.SuavePhoneField.setInvalid(form, false);
                    }
                    scheduleDraftSave();
                });
                phoneInput.addEventListener('blur', function () {
                    if (window.SuavePhoneField) {
                        window.SuavePhoneField.syncAll(form);
                    }
                    saveDraft();
                });
            }

            form.addEventListener('suave-phone:change', function () {
                clearFieldError('phone');
                scheduleDraftSave();
            });
        }

        // Form Submit
        if (form) {
            form.addEventListener('submit', function (e) {
                e.preventDefault();
                clearAllErrors();
                if (window.SuavePhoneField) {
                    window.SuavePhoneField.syncAll(form);
                }

                var nameVal = (form.querySelector('[name="name"]')?.value || '').trim();
                var emailVal = (form.querySelector('[name="email"]')?.value || '').trim();
                var phoneVal = getPhoneValue();
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

                var digitsOnly = phoneVal.replace(/\D/g, '');
                if (!phoneVal || digitsOnly.length < 5) {
                    showFieldError('phone', 'Please enter a valid phone number.');
                    if (window.SuavePhoneField) {
                        window.SuavePhoneField.setInvalid(form, true);
                    }
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
                    if (window.SuavePhoneField) {
                        window.SuavePhoneField.resetAll(form);
                    }
                    if (serviceInput) serviceInput.value = '';
                    if (serviceLabel) {
                        serviceLabel.textContent = 'Select a service';
                        serviceLabel.classList.add('text-[#94A3B8]');
                        serviceLabel.classList.remove('text-[#0F172A]', 'font-medium');
                    }
                    if (serviceIcon) {
                        serviceIcon.innerHTML = '<i class="fa-solid fa-shapes text-sm" aria-hidden="true"></i>';
                    }
                    try {
                        sessionStorage.removeItem(DRAFT_STORAGE_KEY);
                    } catch (e) {}
                    if (draftTokenInput) draftTokenInput.value = '';

                    // Redirect to Thank You page
                    var redirectUrl = data.redirect || '{{ route('thank-you') }}';
                    window.location.href = redirectUrl;
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
