(function () {
    'use strict';

    var FALLBACK_COUNTRY = 'us';
    var booted = false;

    function normalizeCountry(code) {
        if (!code || typeof code !== 'string') {
            return '';
        }

        var normalized = code.trim().toLowerCase();

        return /^[a-z]{2}$/.test(normalized) && normalized !== 'xx' ? normalized : '';
    }

    function lookupCountry(geoUrl) {
        return function () {
            var chain = Promise.resolve(null);

            if (geoUrl) {
                chain = fetch(geoUrl, {
                    headers: { Accept: 'application/json' },
                    credentials: 'same-origin',
                })
                    .then(function (response) {
                        return response.ok ? response.json() : null;
                    })
                    .then(function (data) {
                        return normalizeCountry(data && data.country);
                    })
                    .catch(function () {
                        return null;
                    });
            }

            return chain.then(function (localCountry) {
                if (localCountry) {
                    return localCountry;
                }

                return fetch('https://ipapi.co/json/')
                    .then(function (response) {
                        return response.ok ? response.json() : null;
                    })
                    .then(function (data) {
                        return normalizeCountry(data && data.country_code) || FALLBACK_COUNTRY;
                    })
                    .catch(function () {
                        return FALLBACK_COUNTRY;
                    });
            });
        };
    }

    function syncRoot(root) {
        var input = root.querySelector('[data-phone-field-input]');
        var hidden = root.querySelector('[data-phone-field-value]');
        if (!input || !hidden) {
            return;
        }

        var iti = root._suaveIti;
        if (!iti && window.intlTelInput && typeof window.intlTelInput.getInstance === 'function') {
            iti = window.intlTelInput.getInstance(input);
            root._suaveIti = iti;
        }

        if (!input.value.trim()) {
            hidden.value = '';
            return;
        }

        if (iti && typeof iti.getNumber === 'function') {
            var full = iti.getNumber();
            hidden.value = full || '';
            return;
        }

        hidden.value = input.value.replace(/[^\d+]/g, '');
    }

    function markInvalid(root, isInvalid) {
        var input = root.querySelector('[data-phone-field-input]');
        var itiWrap = root.querySelector('.iti');
        if (input) {
            input.classList.toggle('is-invalid', !!isInvalid);
        }
        if (itiWrap) {
            itiWrap.classList.toggle('is-invalid', !!isInvalid);
        }
    }

    function initRoot(root) {
        if (!root || root.getAttribute('data-phone-field-ready') === '1') {
            return;
        }

        var input = root.querySelector('[data-phone-field-input]');
        if (!input || !window.intlTelInput) {
            return;
        }

        var initialCountry = normalizeCountry(root.getAttribute('data-initial-country') || '');
        var geoUrl = root.getAttribute('data-geo-country-url') || '';
        var options = {
            separateDialCode: true,
            strictMode: true,
            formatAsYouType: true,
            countrySearch: true,
            containerClass: 'suave-phone-field__iti',
        };

        if (initialCountry) {
            options.initialCountry = initialCountry;
        } else {
            options.initialCountryLookup = lookupCountry(geoUrl);
        }

        var iti = window.intlTelInput(input, options);
        root._suaveIti = iti;
        root.setAttribute('data-phone-field-ready', '1');

        function onChange() {
            syncRoot(root);
            markInvalid(root, false);
            var error = root.querySelector('[data-error-for]');
            if (error) {
                error.hidden = true;
                error.textContent = '';
            }
            input.dispatchEvent(new CustomEvent('suave-phone:change', { bubbles: true }));
        }

        input.addEventListener('input', onChange);
        input.addEventListener('change', onChange);
        input.addEventListener('countrychange', onChange);

        if (iti && iti.promise && typeof iti.promise.then === 'function') {
            iti.promise.then(function () {
                syncRoot(root);
            }).catch(function () {
                syncRoot(root);
            });
        } else {
            syncRoot(root);
        }
    }

    function resetRoot(root) {
        var input = root.querySelector('[data-phone-field-input]');
        var hidden = root.querySelector('[data-phone-field-value]');
        var iti = root._suaveIti;

        if (input) {
            input.value = '';
        }
        if (hidden) {
            hidden.value = '';
        }
        if (iti && typeof iti.setNumber === 'function') {
            iti.setNumber('');
        }
        markInvalid(root, false);
    }

    function phoneValue(form) {
        syncAll(form);
        var hidden = (form || document).querySelector('[data-phone-field-value]');
        return (hidden && hidden.value ? hidden.value : '').trim();
    }

    function hasLetters(value) {
        return /[A-Za-z]/.test(value || '');
    }

    function initAll(scope) {
        (scope || document).querySelectorAll('[data-phone-field]').forEach(initRoot);
    }

    function syncAll(scope) {
        (scope || document).querySelectorAll('[data-phone-field]').forEach(syncRoot);
    }

    function resetAll(scope) {
        (scope || document).querySelectorAll('[data-phone-field]').forEach(resetRoot);
    }

    function setInvalid(form, isInvalid) {
        var root = (form || document).querySelector('[data-phone-field]');
        if (root) {
            markInvalid(root, isInvalid);
        }
    }

    window.SuavePhoneField = {
        initAll: initAll,
        syncAll: syncAll,
        resetAll: resetAll,
        phoneValue: phoneValue,
        hasLetters: hasLetters,
        setInvalid: setInvalid,
    };

    function boot() {
        if (booted) {
            return;
        }
        if (!window.intlTelInput) {
            window.setTimeout(boot, 40);
            return;
        }
        booted = true;
        initAll();
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', boot);
    } else {
        boot();
    }
})();
