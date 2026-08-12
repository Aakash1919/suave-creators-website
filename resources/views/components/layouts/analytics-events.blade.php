@once
    @push('scripts')
        <script>
            (function() {
                function cleanText(value) {
                    return String(value || '').replace(/\s+/g, ' ').trim().slice(0, 100);
                }

                function linkLocation(link) {
                    if (link.closest('.site-header')) return 'header';
                    if (link.closest('.site-footer')) return 'footer';
                    if (link.closest('[data-contact-reach]')) return 'contact_details';
                    if (link.closest('[data-contact-form]')) return 'contact_form';
                    return 'page';
                }

                window.suaveTrackEvent = function(eventName, params) {
                    if (!eventName) return;

                    var payload = Object.assign({
                        page_path: window.location.pathname,
                        page_location: window.location.href,
                    }, params || {});

                    if (typeof window.gtag === 'function') {
                        window.gtag('event', eventName, payload);
                        return;
                    }

                    window.dataLayer = window.dataLayer || [];
                    window.dataLayer.push(Object.assign({ event: eventName }, payload));
                };

                document.addEventListener('click', function(event) {
                    var link = event.target.closest && event.target.closest('a[href]');
                    if (!link) return;

                    var href = link.getAttribute('href') || '';
                    var eventName = '';

                    if (href.indexOf('tel:') === 0) {
                        eventName = 'click_call';
                    } else if (href.indexOf('mailto:') === 0) {
                        eventName = 'click_email';
                    } else {
                        try {
                            var url = new URL(href, window.location.href);
                            if (
                                (url.origin === window.location.origin && url.pathname === '/contact-us')
                                || url.hostname === 'calendar.app.google'
                                || url.hostname === 'calendar.google.com'
                            ) {
                                eventName = 'cta_click';
                            }
                        } catch (e) {}
                    }

                    if (!eventName) return;

                    window.suaveTrackEvent(eventName, {
                        cta_text: cleanText(link.textContent || link.getAttribute('aria-label')),
                        cta_url: href,
                        cta_location: linkLocation(link),
                    });
                }, { passive: true });
            })();
        </script>
    @endpush
@endonce
