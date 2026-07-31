@extends('layouts.frontend')

@section('content')
    <!-- Contact Hero Start -->
    <section
        class="relative z-10 w-full overflow-hidden pb-12 pt-8 sm:pb-16 sm:pt-10 lg:min-h-[580px] lg:pb-20 lg:pt-[52px] site-container">
        <div class="pointer-events-none absolute -right-24 top-10 h-72 w-72 rounded-full bg-[#7A5FF8]/20 blur-3xl"
            aria-hidden="true"></div>
        <div class="pointer-events-none absolute -bottom-32 left-1/3 h-72 w-72 rounded-full bg-[#2A4DFB]/20 blur-3xl"
            aria-hidden="true"></div>

        <div class="relative grid items-center gap-12 lg:grid-cols-[1.08fr_0.92fr] lg:gap-16">
            <div class="max-w-[670px]">
                <p
                    class="mb-2 inline-block bg-gradient-to-r from-[#2A4DFB] to-[#7A5FF8] bg-clip-text text-sm font-bold uppercase tracking-wide text-transparent pragati-narrow-regular">
                    Let’s create something remarkable
                </p>

                <h1
                    class="mb-2 mt-2 text-[36px] font-semibold leading-[100%] text-white min-[375px]:text-[42px] sm:text-5xl lg:text-[60px]">
                    Have a project<br>
                    in mind?
                    <span
                        class="inline-block bg-[linear-gradient(180deg,_#2F69FB_15%,_#C56BFF_100%)] bg-clip-text font-extrabold text-transparent">
                        Let’s discuss.
                    </span>
                </h1>

                <p class="mb-2 mt-2 max-w-[610px] text-[12px] leading-5 text-[#B1B9DF] md:text-sm md:leading-6">
                    We always love to hear from you! Whether you’re looking to develop a business website, app, or custom
                    digital
                    solution, our professional team is here to help you turn your ideas into reality.
                </p>

                <div class="mt-8 flex flex-wrap items-center gap-4 sm:gap-7">
                    <a href="#contact-id"
                        class="group inline-flex items-center gap-2 whitespace-nowrap rounded-full bg-gradient-to-r from-[#2A4DFB] to-[#0026E3] px-4 py-2 text-[13px] font-bold text-white shadow-lg shadow-indigo-950/30 transition hover:brightness-110 sm:text-sm">
                        Send a Message
                        <svg xmlns="https://www.w3.org/2000/svg" width="18" height="14" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="transition-transform duration-300 group-hover:translate-x-1"
                            aria-hidden="true">
                            <path d="M18 8L22 12L18 16"></path>
                            <path d="M2 12H22"></path>
                        </svg>
                    </a>
                    <a href="tel:+918894900142"
                        class="inline-flex items-center gap-2 whitespace-nowrap border-b border-white/70 text-[13px] font-semibold text-white sm:text-sm">
                        <i class="fa-solid fa-phone text-xs" aria-hidden="true"></i>
                        +91 88949 00142
                    </a>
                </div>
            </div>

            <div class="relative mx-auto w-full max-w-[510px]" aria-label="How our consultation works">
                <div class="absolute -inset-5 rounded-[40px] border border-white/[0.06]"></div>
                <div
                    class="relative overflow-hidden rounded-[30px] border border-white/10 bg-white/[0.07] p-6 shadow-[0_30px_80px_rgba(0,0,0,0.3)] backdrop-blur-xl sm:p-8">
                    <div class="flex items-center justify-between gap-4 border-b border-white/10 pb-6">
                        <div>
                            <p class="text-sm font-bold uppercase tracking-wide text-[#8598F8] pragati-narrow-regular">What
                                happens next</p>
                            <h2 class="mt-2 text-xl font-semibold text-white sm:text-2xl">A clear path from idea to plan
                            </h2>
                        </div>
                        <span
                            class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-gradient-to-br from-[#2A4DFB] to-[#8B5CF6] text-white shadow-lg">
                            <i class="fa-regular fa-message" aria-hidden="true"></i>
                        </span>
                    </div>

                    <ol class="mt-2">
                        <li class="group flex gap-4 border-b border-white/10 py-5">
                            <span
                                class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-white/10 text-xs font-bold text-white">01</span>
                            <div>
                                <h3 class="text-sm font-semibold text-white">Share your project</h3>
                                <p class="mt-1 text-[13px] leading-5 text-[#B1B9DF]">Tell us your goals, timeline, and
                                    current challenges.</p>
                            </div>
                        </li>
                        <li class="group flex gap-4 border-b border-white/10 py-5">
                            <span
                                class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-white/10 text-xs font-bold text-white">02</span>
                            <div>
                                <h3 class="text-sm font-semibold text-white">Hear from an expert</h3>
                                <p class="mt-1 text-[13px] leading-5 text-[#B1B9DF]">We usually respond within 12 hours on
                                    business days.</p>
                            </div>
                        </li>
                        <li class="group flex gap-4 pt-5">
                            <span
                                class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-white/10 text-xs font-bold text-white">03</span>
                            <div>
                                <h3 class="text-sm font-semibold text-white">Get your next steps</h3>
                                <p class="mt-1 text-[13px] leading-5 text-[#B1B9DF]">We’ll suggest a discovery call and a
                                    practical way forward.</p>
                            </div>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <!-- Contact Hero End -->

    <!-- Contact Form Start -->
    <section id="contact-id" class="full-bleed scroll-mt-6 overflow-hidden bg-cover bg-center py-12 sm:py-16 lg:py-20"
        style="background-image: url('{{ asset('assets/background/technology-section-bg.png') }}');"
        aria-labelledby="contact-form-heading">
        <div class="section-inner contact-form-section-inner">
            <div class="contact-form-panel">
                <aside class="contact-form-panel__info" aria-labelledby="contact-form-heading">
                    <p class="contact-form-panel__eyebrow">
                        <span class="contact-form-panel__eyebrow-bar" aria-hidden="true"></span>
                        Contact · 1-day reply
                    </p>
                    <h2 id="contact-form-heading" class="contact-form-panel__title">
                        Tell us what you&rsquo;re<br>
                        <span>trying to fix.</span>
                    </h2>
                    <p class="contact-form-panel__lead">
                        Prefer a call or email? We read every note ourselves and reply within one business day.
                    </p>

                    <div class="contact-form-panel__meta">
                        <a class="contact-form-panel__meta-card" href="tel:+918894900142">
                            <span class="contact-form-panel__meta-label">Phone</span>
                            <span class="contact-form-panel__meta-value">+91 88949 00142</span>
                            <span class="contact-form-panel__meta-note">Mon–Fri · 1:30PM–9:30PM</span>
                        </a>
                        <a class="contact-form-panel__meta-card" href="mailto:info@suavecreators.com">
                            <span class="contact-form-panel__meta-label">Email</span>
                            <span class="contact-form-panel__meta-value">info@suavecreators.com</span>
                            <span class="contact-form-panel__meta-note">Real person, not a queue</span>
                        </a>
                    </div>
                </aside>

                <div class="contact-form-panel__form-wrap">
                    <div class="contact-form-panel__form">
                        <header class="contact-form-panel__form-intro">
                            <p class="contact-form-panel__form-status">
                                <span aria-hidden="true"></span>
                                Live intake
                            </p>
                            <h3 class="contact-form-panel__form-title">Start the conversation</h3>
                        </header>

                        <p class="contact-form-panel__flash" data-contact-success role="status" hidden></p>

                        <form action="{{ route('contact-us.store') }}" method="post" class="contact-form-panel__fields"
                            data-contact-form novalidate>
                            @csrf
                            <input type="hidden" name="_ajax" value="1">
                            <input type="hidden" name="form_started_at" data-contact-started
                                value="{{ $formStartedAt ?? time() }}">
                            <div class="contact-form-honeypot" aria-hidden="true">
                                <label for="contact-website">Website</label>
                                <input id="contact-website" type="text" name="website" value="" tabindex="-1"
                                    autocomplete="off">
                            </div>

                            <div class="contact-form-panel__row">
                                <label for="contact-name">
                                    <span class="contact-form-panel__label-text">Full name</span>
                                    <input id="contact-name" name="name" type="text" autocomplete="name"
                                        placeholder="Jane Cooper">
                                    <span class="contact-form-panel__field-error" data-error-for="name" hidden></span>
                                </label>
                                <label for="contact-email">
                                    <span class="contact-form-panel__label-text">Email</span>
                                    <input id="contact-email" name="email" type="text" inputmode="email"
                                        autocomplete="email" placeholder="you@company.com">
                                    <span class="contact-form-panel__field-error" data-error-for="email" hidden></span>
                                </label>
                            </div>

                            <div class="contact-form-panel__row">
                                <label for="contact-phone">
                                    <span class="contact-form-panel__label-text">Phone</span>
                                    <input id="contact-phone" name="phone" type="text" inputmode="tel"
                                        autocomplete="tel" placeholder="+91 90000 00000">
                                    <span class="contact-form-panel__field-error" data-error-for="phone" hidden></span>
                                </label>
                                <label for="contact-service">
                                    <span class="contact-form-panel__label-text">Service</span>
                                    <select id="contact-service" name="service">
                                        <option value="" disabled selected>Select a service</option>
                                        @foreach ($formServices as $value => $label)
                                            <option value="{{ $value }}">{{ $label }}</option>
                                        @endforeach
                                    </select>
                                    <span class="contact-form-panel__field-error" data-error-for="service" hidden></span>
                                </label>
                            </div>

                            <label for="contact-message" class="contact-form-panel__message">
                                <span class="contact-form-panel__label-text">What are you trying to fix?</span>
                                <textarea id="contact-message" name="message" rows="3"
                                    placeholder="A sentence or two about the problem is enough."></textarea>
                                <span class="contact-form-panel__field-error" data-error-for="message" hidden></span>
                            </label>

                            <div class="contact-form-panel__actions">
                                <button type="submit"
                                    class=" contact-form-panel__submit group inline-flex items-center gap-2 whitespace-nowrap rounded-full bg-gradient-to-r from-[#2A4DFB] to-[#0026E3] px-4 py-2 text-[13px] font-bold text-white shadow-lg shadow-indigo-950/30 transition hover:brightness-110 sm:text-sm"
                                    data-contact-submit>
                                    Send inquiry
                                    <svg xmlns="https://www.w3.org/2000/svg" width="18" height="14"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                        <path d="M18 8L22 12L18 16"></path>
                                        <path d="M2 12H22"></path>
                                    </svg>
                                </button>
                            </div>

                            <p class="contact-form-panel__disclaimer">
                                Reply within 1 business day.
                                <a href="{{ route('privacy-policy') }}">Privacy policy</a>
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Contact Form End -->

    <!-- Technologies & Partnerships Marquee Start -->
    <x-frontend.tech-partnerships-section :items="$techStack"
        section-class="full-bleed full-bleed--edge bg-white py-10 lg:py-14"
        background-image="assets/background/technology-section-bg.png" />
    <!-- Technologies & Partnerships Marquee End -->

    <!-- Contact Information Start -->
    @php
        $mapOffices = $offices ?? [];
        $activeOffice = $mapOffices[0] ?? null;
    @endphp
    <section class="full-bleed contact-reach-section py-16 sm:py-20 lg:py-24"
        style="background-image: url('{{ asset('assets/background/about-section-bg.png') }}');"
        aria-labelledby="contact-details-heading" data-contact-reach>
        <div class="section-inner">
            <header class="contact-reach__header">
                <p class="contact-reach__eyebrow">
                    <span class="contact-reach__eyebrow-bar" aria-hidden="true"></span>
                    Prefer another way to reach us?
                </p>
                <h2 id="contact-details-heading" class="contact-reach__title">
                    We’re always within reach
                </h2>
                <p class="contact-reach__lead">
                    Visit, email, or call us. Choose whichever way works best for you.
                </p>
            </header>

            <div class="contact-reach">
                <div class="contact-reach__map">
                    <iframe data-contact-map title="{{ ($activeOffice['display'] ?? 'Office location') . ' map' }}"
                        src="{{ $activeOffice['map_embed'] ?? '' }}" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade" allowfullscreen></iframe>
                </div>

                <div class="contact-reach__details" role="list">
                    <div class="contact-reach__panel-head">
                        <h3 class="contact-reach__panel-title">Contact</h3>
                    </div>

                    @foreach ($contactCards as $card)
                        <div class="contact-reach__item" role="listitem">
                            <span class="contact-reach__item-icon" aria-hidden="true">
                                <i class="{{ $card['icon'] }}"></i>
                            </span>

                            <div class="contact-reach__item-content">
                                <p class="contact-reach__item-label">{{ $card['label'] }}</p>
                                <h3 class="contact-reach__item-title">{{ $card['title'] }}</h3>

                                <div class="contact-reach__item-body">
                                    @if (!empty($card['offices']))
                                        @foreach ($card['offices'] as $officeIndex => $office)
                                            <button type="button"
                                                class="contact-reach__office{{ $officeIndex === 0 ? ' is-active' : '' }}"
                                                data-contact-office data-map-src="{{ $office['map_embed'] }}"
                                                data-map-title="{{ $office['display'] }} map"
                                                data-country="{{ $office['country'] }}"
                                                aria-pressed="{{ $officeIndex === 0 ? 'true' : 'false' }}">
                                                <span class="contact-reach__flag" aria-hidden="true">
                                                    @php
                                                        $flagUrl = "assets/flags/{$office['flag']}.svg";
                                                    @endphp
                                                    <img src="{{ asset($flagUrl) }}" /> </span>
                                                <span class="contact-reach__office-lines">
                                                    @foreach ($office['lines'] as $line)
                                                        <span
                                                            class="contact-reach__office-line">{{ $line }}</span>
                                                    @endforeach
                                                </span>
                                            </button>
                                        @endforeach
                                    @endif

                                    @if (!empty($card['links']))
                                        <div class="contact-reach__links flex">
                                            @foreach ($card['links'] as $link)
                                                @php
                                                    $hasFlag = isset($link['flag']);
                                                    if ($hasFlag) {
                                                        $flagUrl = "assets/flags/{$link['flag']}.svg";
                                                    }
                                                @endphp
                                                <div
                                                    class='flex gap-4  @if ($hasFlag)country-contact-number country-{{ $link['flag'] }} @endif @if ($hasFlag && $link['flag'] != 'us') hidden @endif'>
                                                    @if ($hasFlag)
                                                        <img src='{{ $flagUrl }}' style='width:20px' />
                                                    @endif
                                                    <a href="{{ $link['href'] }}" class="contact-reach__link">
                                                        {{ $link['text'] }}
                                                    </a>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    <!-- Contact Information End -->

    <x-frontend.faq-section class="faq-section--align faq-section--contact bg-cover bg-center"
        style="background-image: url('{{ asset('assets/background/technology-section-bg.png') }}');"
        heading-id="contact-faq-heading" eyebrow="Questions before you get started?" title="Frequently Ask Question"
        description="Here are the most asked questions based on feedback from our users." :qa="$faqs"
        :media="$faqMedia" media-type="image" :media-alt="$faqMediaAlt" :cta-href="$faqCtaHref" :cta-label="$faqCtaLabel" />
@endsection

@push('scripts')
    <script>
        (function() {
            const root = document.querySelector('[data-contact-reach]');
            if (!root) {
                return;
            }

            const map = root.querySelector('[data-contact-map]');
            const offices = root.querySelectorAll('[data-contact-office]');
            if (!map || !offices.length) {
                return;
            }

            offices.forEach(function(button) {
                button.addEventListener('click', function() {
                    const src = button.getAttribute('data-map-src');
                    const country = button.getAttribute('data-country');
                    const title = button.getAttribute('data-map-title') || 'Office location map';
                    if (!src || map.getAttribute('src') === src) {
                        offices.forEach(function(item) {
                            const active = item === button;
                            item.classList.toggle('is-active', active);
                            item.setAttribute('aria-pressed', active ? 'true' : 'false');
                        });
                        return;
                    }

                    map.setAttribute('src', src);
                    map.setAttribute('title', title);
                    toggleCountryContact(country)
                    offices.forEach(function(item) {
                        const active = item === button;
                        item.classList.toggle('is-active', active);
                        item.setAttribute('aria-pressed', active ? 'true' : 'false');
                    });
                });
            });
        })();

        function toggleCountryContact(country) {
            // Hide all country contact elements
            document.querySelectorAll('.country-contact-number').forEach(element => {
                element.classList.add('hidden');
            });

            // Show the selected country element
            const hasContact = document.querySelector('.country-' + country.toLowerCase());
            if (hasContact) {
                document.querySelectorAll('.country-' + country.toLowerCase()).forEach(element => {
                    element.classList.remove('hidden');
                })
            }
        }

        (function() {
            const form = document.querySelector('[data-contact-form]');
            if (!form) {
                return;
            }

            const successEl = document.querySelector('[data-contact-success]');
            const submitBtn = form.querySelector('[data-contact-submit]');
            const startedInput = form.querySelector('[data-contact-started]');
            const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            function field(name) {
                return form.querySelector('[name="' + name + '"]');
            }

            function clearErrors() {
                form.querySelectorAll('.is-invalid').forEach(function(el) {
                    el.classList.remove('is-invalid');
                });
                form.querySelectorAll('[data-error-for]').forEach(function(el) {
                    el.hidden = true;
                    el.textContent = '';
                });
            }

            function showError(name, message) {
                const input = field(name);
                const error = form.querySelector('[data-error-for="' + name + '"]');
                if (input) {
                    input.classList.add('is-invalid');
                }
                if (error) {
                    error.textContent = message;
                    error.hidden = false;
                }
            }

            function showServerErrors(errors) {
                clearErrors();
                Object.keys(errors || {}).forEach(function(name) {
                    const messages = errors[name];
                    const message = Array.isArray(messages) ? messages[0] : messages;
                    if (message) {
                        showError(name, message);
                    }
                });
            }

            function validate() {
                clearErrors();
                let ok = true;

                const name = (field('name')?.value || '').trim();
                const email = (field('email')?.value || '').trim();
                const phone = (field('phone')?.value || '').trim();
                const service = field('service')?.value || '';
                const message = (field('message')?.value || '').trim();

                if (!name) {
                    showError('name', 'Please enter your full name.');
                    ok = false;
                } else if (name.length > 120) {
                    showError('name', 'Full name may not be longer than 120 characters.');
                    ok = false;
                }

                if (!email) {
                    showError('email', 'Please enter your email address.');
                    ok = false;
                } else if (!emailPattern.test(email)) {
                    showError('email', 'Please enter a valid email address.');
                    ok = false;
                }

                if (!phone) {
                    showError('phone', 'Please enter your phone number.');
                    ok = false;
                }

                if (!service) {
                    showError('service', 'Please select a service.');
                    ok = false;
                }

                if (!message) {
                    showError('message', 'Please tell us what you are trying to fix.');
                    ok = false;
                } else if (message.length < 10) {
                    showError('message', 'Please write at least 10 characters about your request.');
                    ok = false;
                }

                return ok;
            }

            function setSubmitting(isSubmitting) {
                if (!submitBtn) {
                    return;
                }
                submitBtn.disabled = isSubmitting;
                submitBtn.classList.toggle('is-loading', isSubmitting);
            }

            function showSuccess(message) {
                if (!successEl) {
                    return;
                }
                successEl.textContent = message || 'The request has been sent successfully.';
                successEl.hidden = false;
                successEl.scrollIntoView({
                    behavior: 'smooth',
                    block: 'nearest'
                });
            }

            function resetForm() {
                form.reset();
                const service = field('service');
                if (service) {
                    service.selectedIndex = 0;
                }
                if (startedInput) {
                    startedInput.value = String(Math.floor(Date.now() / 1000));
                }
                clearErrors();
            }

            ['name', 'email', 'phone', 'service', 'message'].forEach(function(name) {
                const input = field(name);
                if (!input) {
                    return;
                }
                input.addEventListener('input', function() {
                    input.classList.remove('is-invalid');
                    const error = form.querySelector('[data-error-for="' + name + '"]');
                    if (error) {
                        error.hidden = true;
                        error.textContent = '';
                    }
                    if (successEl) {
                        successEl.hidden = true;
                    }
                });
                input.addEventListener('change', function() {
                    input.dispatchEvent(new Event('input'));
                });
            });

            form.addEventListener('submit', function(event) {
                event.preventDefault();

                if (successEl) {
                    successEl.hidden = true;
                }

                if (!validate()) {
                    const firstInvalid = form.querySelector('.is-invalid');
                    firstInvalid?.focus();
                    return;
                }

                setSubmitting(true);

                const body = new FormData(form);

                fetch(form.action, {
                        method: 'POST',
                        headers: {
                            Accept: 'application/json',
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': csrf,
                        },
                        body: body,
                        credentials: 'same-origin',
                    })
                    .then(async function(response) {
                        const data = await response.json().catch(function() {
                            return {};
                        });

                        if (response.status === 422) {
                            showServerErrors(data.errors || {});
                            return;
                        }

                        if (!response.ok || data.success === false) {
                            showError('message', data.message ||
                                'Unable to send your request. Please try again.');
                            return;
                        }

                        resetForm();
                        showSuccess(data.message || 'The request has been sent successfully.');
                    })
                    .catch(function() {
                        showError('message', 'Unable to send your request. Please try again.');
                    })
                    .finally(function() {
                        setSubmitting(false);
                    });
            });
        })();
    </script>
@endpush
