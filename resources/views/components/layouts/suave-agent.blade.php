<div
  {{ $attributes->merge(['class' => 'suave-agent']) }}
  data-suave-agent
  data-start-url="{{ route('suave-agent.start') }}"
  data-chat-url="{{ route('suave-agent.chat') }}"
  data-history-url="{{ route('suave-agent.history') }}"
  data-csrf="{{ csrf_token() }}"
>
  <button
    type="button"
    class="floating-chat suave-agent__toggle"
    data-suave-agent-toggle
    aria-label="{{ $ariaLabel }}"
    aria-expanded="false"
    aria-controls="suave-agent-panel"
  >
    <x-layouts.chat-widget-icon :alt="$alt" :width="48" :height="48" />
  </button>

  <div
    id="suave-agent-panel"
    class="suave-agent__panel"
    data-suave-agent-panel
    hidden
    role="dialog"
    aria-modal="false"
    aria-labelledby="suave-agent-title"
  >
    <header class="suave-agent__header">
      <div class="suave-agent__brand">
        <x-layouts.chat-widget-icon
          class="suave-agent__brand-icon"
          :alt="$alt"
          :width="40"
          :height="40"
        />
        <div class="suave-agent__brand-text">
          <h2 id="suave-agent-title" class="suave-agent__title">Suave Creators</h2>
          <p class="suave-agent__online">
            <span class="suave-agent__online-dot" aria-hidden="true"></span>
            Online
          </p>
        </div>
      </div>
      <div class="suave-agent__actions">
        <button type="button" class="suave-agent__action-btn suave-agent__new-chat" data-suave-agent-new-chat title="New chat" aria-label="Start new chat">
          <i class="fa-solid fa-plus" aria-hidden="true"></i>
        </button>
        <button type="button" class="suave-agent__action-btn suave-agent__close" data-suave-agent-close title="Close chat" aria-label="Close chat">
          <i class="fa-solid fa-xmark" aria-hidden="true"></i>
        </button>
      </div>
    </header>

    <div class="suave-agent__body" data-suave-agent-body>
      <form class="suave-agent__lead" data-suave-agent-lead novalidate>
        <div class="suave-agent__fields">
          <p class="suave-agent__intro">Hi! Welcome to Suave Creators. Share your name and phone to chat about your project.</p>
          <div class="suave-agent__field">
            <label class="suave-agent__label" for="suave-agent-name">Name</label>
            <input id="suave-agent-name" name="name" type="text" autocomplete="name" maxlength="120" placeholder="Your name" aria-describedby="suave-agent-name-error">
            <p class="suave-agent__field-error" id="suave-agent-name-error" data-error-for="name" hidden></p>
          </div>
          <div class="suave-agent__field">
            <label class="suave-agent__label" for="suave-agent-phone">Phone</label>
            <x-frontend.phone-field
              id="suave-agent-phone"
              name="phone"
              placeholder="98765 43210"
              :show-label="false"
              dropdown-on-body
            />
          </div>
          <div class="suave-agent__field">
            <label class="suave-agent__label" for="suave-agent-email">Email</label>
            <input id="suave-agent-email" name="email" type="text" inputmode="email" autocomplete="email" maxlength="255" placeholder="you@company.com" aria-describedby="suave-agent-email-error">
            <p class="suave-agent__field-error" id="suave-agent-email-error" data-error-for="email" hidden></p>
          </div>
        </div>
        <p class="suave-agent__error" data-suave-agent-lead-error hidden></p>
        <button type="submit" class="suave-agent__primary">Start chat</button>
      </form>

      <div class="suave-agent__chat" data-suave-agent-chat hidden>
        <div class="suave-agent__messages" data-suave-agent-messages aria-live="polite"></div>
        <p class="suave-agent__status" data-suave-agent-status hidden></p>
        <form class="suave-agent__composer" data-suave-agent-composer>
          <label class="sr-only" for="suave-agent-message">Message</label>
          <textarea id="suave-agent-message" name="message" rows="1" maxlength="4000" placeholder="Tell me about your project you’re planning to discuss…" required></textarea>
          <button type="submit" class="suave-agent__send" aria-label="Send message">
            <i class="fa-solid fa-paper-plane" aria-hidden="true"></i>
          </button>
        </form>
      </div>
    </div>
  </div>
</div>

@once
  @push('scripts')
    <script>
      (function () {
        var root = document.querySelector('[data-suave-agent]');
        if (!root) return;

        // Escape footer overflow-x:clip / content-visibility so the toggle stays viewport-fixed.
        if (root.parentElement !== document.body) {
          document.body.appendChild(root);
        }

        var STORAGE_KEY = 'suave_agent_session_v1';
        var MARKED_SRC = 'https://cdn.jsdelivr.net/npm/marked@15.0.7/marked.min.js';
        var markedLoading = null;
        var toggle = root.querySelector('[data-suave-agent-toggle]');
        var panel = root.querySelector('[data-suave-agent-panel]');
        var closeBtn = root.querySelector('[data-suave-agent-close]');
        var leadForm = root.querySelector('[data-suave-agent-lead]');
        var leadError = root.querySelector('[data-suave-agent-lead-error]');
        var chatPane = root.querySelector('[data-suave-agent-chat]');
        var messagesEl = root.querySelector('[data-suave-agent-messages]');
        var statusEl = root.querySelector('[data-suave-agent-status]');
        var composer = root.querySelector('[data-suave-agent-composer]');
        var messageInput = composer.querySelector('textarea');
        var csrf = root.getAttribute('data-csrf');
        var startUrl = root.getAttribute('data-start-url');
        var chatUrl = root.getAttribute('data-chat-url');
        var historyUrl = root.getAttribute('data-history-url');
        var session = null;
        var streaming = false;
        var historyLoaded = false;

        function ensureMarked() {
          if (window.marked && typeof window.marked.parse === 'function') {
            if (typeof window.marked.setOptions === 'function') {
              window.marked.setOptions({ breaks: true, gfm: true });
            }
            return Promise.resolve();
          }
          if (markedLoading) return markedLoading;

          markedLoading = new Promise(function (resolve, reject) {
            var s = document.createElement('script');
            s.src = MARKED_SRC;
            s.async = true;
            s.onload = function () {
              if (window.marked && typeof window.marked.setOptions === 'function') {
                window.marked.setOptions({ breaks: true, gfm: true });
              }
              resolve();
            };
            s.onerror = function () {
              markedLoading = null;
              reject(new Error('Failed to load marked'));
            };
            document.head.appendChild(s);
          }).catch(function () {
            return null;
          });

          return markedLoading;
        }

        function renderMarkdown(text) {
          if (!text) return '';
          if (window.marked && typeof window.marked.parse === 'function') {
            return window.marked.parse(text);
          }
          return String(text).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
        }

        function setAssistantHtml(bubble, markdownText) {
          bubble.dataset.raw = markdownText || '';
          bubble.innerHTML = renderMarkdown(markdownText || '');
        }

        function saveSession() {
          if (!session) {
            localStorage.removeItem(STORAGE_KEY);
            return;
          }
          localStorage.setItem(STORAGE_KEY, JSON.stringify(session));
        }

        function loadSession() {
          try {
            var raw = localStorage.getItem(STORAGE_KEY);
            session = raw ? JSON.parse(raw) : null;
          } catch (e) {
            session = null;
          }
        }

        function clearSession() {
          session = null;
          historyLoaded = false;
          saveSession();
          messageInput.disabled = false;
          messageInput.value = '';
          resizeComposer();
          showLead();
        }

        function setOpen(open) {
          panel.hidden = !open;
          root.classList.toggle('is-open', open);
          toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
          if (open) {
            ensurePhoneField();
          }
        }

        function setStatus(text) {
          if (!text) {
            statusEl.hidden = true;
            statusEl.textContent = '';
            return;
          }
          statusEl.hidden = false;
          statusEl.textContent = text;
        }

        function appendMessage(role, content, asMarkdown) {
          var bubble = document.createElement('div');
          bubble.className = 'suave-agent__bubble suave-agent__bubble--' + role;
          if (role === 'assistant' && asMarkdown !== false) {
            setAssistantHtml(bubble, content || '');
          } else {
            bubble.textContent = content || '';
          }
          messagesEl.appendChild(bubble);
          messagesEl.scrollTop = messagesEl.scrollHeight;
          return bubble;
        }

        function showChat() {
          leadForm.hidden = true;
          chatPane.hidden = false;
        }

        function showLead() {
          leadForm.hidden = false;
          chatPane.hidden = true;
          messagesEl.innerHTML = '';
        }

        function renderHistory(data) {
          messagesEl.innerHTML = '';
          (data.messages || []).forEach(function (msg) {
            if (msg.role === 'user' || msg.role === 'assistant') {
              appendMessage(msg.role, msg.content, msg.role === 'assistant');
            }
          });
          messageInput.disabled = !!data.escalated;
          if (data.conversation_id) {
            session = session || {};
            session.conversation_id = data.conversation_id;
            saveSession();
          }
          historyLoaded = true;
        }

        async function resumeIfPossible(force) {
          loadSession();
          if (!session || !session.lead_uuid || !session.session_token) {
            showLead();
            return;
          }

          if (historyLoaded && !force && messagesEl.childNodes.length) {
            showChat();
            return;
          }

          showChat();
          setStatus('Loading previous chat…');

          try {
            await ensureMarked();
            var url = historyUrl + '?lead_uuid=' + encodeURIComponent(session.lead_uuid)
              + '&session_token=' + encodeURIComponent(session.session_token);
            if (session.conversation_id) {
              url += '&conversation_id=' + encodeURIComponent(session.conversation_id);
            }
            var res = await fetch(url, {
              headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': csrf },
              credentials: 'same-origin'
            });
            if (!res.ok) throw new Error('Could not resume chat');
            var data = await res.json();

            if (!data.conversation_id && (!data.messages || !data.messages.length)) {
              clearSession();
              setStatus('');
              return;
            }

            renderHistory(data);
            setStatus('');
          } catch (err) {
            clearSession();
            setStatus('');
          }
        }

        var autoOpenDismissed = false;

        toggle.addEventListener('click', function () {
          var open = panel.hidden;
          if (!open) autoOpenDismissed = true;
          setOpen(open);
          if (open) {
            ensureMarked();
            resumeIfPossible(false);
          }
        });

        var newChatBtn = root.querySelector('[data-suave-agent-new-chat]');
        if (newChatBtn) {
          newChatBtn.addEventListener('click', function () {
            clearSession();
          });
        }

        closeBtn.addEventListener('click', function () {
          autoOpenDismissed = true;
          setOpen(false);
        });

        function clearFieldError(field) {
          var input = leadForm.querySelector('[name="' + field + '"]');
          var error = leadForm.querySelector('[data-error-for="' + field + '"]');
          if (input) {
            input.classList.remove('is-invalid');
            input.removeAttribute('aria-invalid');
          }
          if (field === 'phone' && window.SuavePhoneField) {
            window.SuavePhoneField.setInvalid(leadForm, false);
          }
          if (error) {
            error.hidden = true;
            error.textContent = '';
          }
        }

        function setFieldError(field, message) {
          var input = leadForm.querySelector('[name="' + field + '"]');
          var error = leadForm.querySelector('[data-error-for="' + field + '"]');
          if (input) {
            input.classList.add('is-invalid');
            input.setAttribute('aria-invalid', 'true');
          }
          if (field === 'phone' && window.SuavePhoneField) {
            window.SuavePhoneField.setInvalid(leadForm, true);
          }
          if (error) {
            error.hidden = false;
            error.textContent = message;
          }
        }

        function clearFieldErrors() {
          ['name', 'phone', 'email'].forEach(clearFieldError);
          leadError.hidden = true;
          leadError.textContent = '';
        }

        function ensurePhoneField() {
          if (window.SuavePhoneField) {
            window.SuavePhoneField.initAll(leadForm);
          }
        }

        function fieldValue(field) {
          if (field === 'phone' && window.SuavePhoneField) {
            return window.SuavePhoneField.phoneValue(leadForm);
          }
          var input = leadForm.querySelector('[name="' + field + '"]');
          return input ? input.value.trim() : '';
        }

        function phoneLooksValid(value) {
          var phoneRoot = leadForm.querySelector('[data-phone-field]');
          var iti = phoneRoot && phoneRoot._suaveIti;
          if (iti && typeof iti.isValidNumber === 'function') {
            return iti.isValidNumber();
          }
          return /^[+]?[\d\s().\-\/]{7,40}$/.test(value);
        }

        function leadFieldErrors() {
          var errors = {};
          var name = fieldValue('name');
          var phone = fieldValue('phone');
          var email = fieldValue('email');

          if (!name) {
            errors.name = 'Please enter your name.';
          }
          if (!phone) {
            errors.phone = 'Please enter your phone number.';
          } else if (!phoneLooksValid(phone)) {
            errors.phone = 'Please enter a valid phone number.';
          }
          if (email && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
            errors.email = 'Please enter a valid email address.';
          }

          return errors;
        }

        function showFieldErrors(errors) {
          var firstField = '';
          ['name', 'phone', 'email'].forEach(function (field) {
            var message = errors[field];
            if (Array.isArray(message)) {
              message = message[0] || '';
            }
            if (!message) {
              clearFieldError(field);
              return;
            }
            setFieldError(field, message);
            if (!firstField) {
              firstField = field;
            }
          });

          if (firstField) {
            var firstInput = firstField === 'phone'
              ? leadForm.querySelector('[data-phone-field-input]')
              : leadForm.querySelector('[name="' + firstField + '"]');
            if (firstInput) {
              firstInput.focus();
            }
          }
        }

        ['name', 'email'].forEach(function (field) {
          var input = leadForm.querySelector('[name="' + field + '"]');
          if (!input) return;
          input.addEventListener('input', function () {
            clearFieldError(field);
          });
        });
        var phoneVisible = leadForm.querySelector('[data-phone-field-input]');
        if (phoneVisible) {
          phoneVisible.addEventListener('input', function () {
            clearFieldError('phone');
          });
        }

        leadForm.addEventListener('submit', async function (event) {
          event.preventDefault();
          clearFieldErrors();

          var errors = leadFieldErrors();
          if (Object.keys(errors).length) {
            showFieldErrors(errors);
            return;
          }

          var submitBtn = leadForm.querySelector('button[type="submit"]');
          submitBtn.disabled = true;
          setStatus('');

          try {
            var res = await fetch(startUrl, {
              method: 'POST',
              headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrf,
                'X-Requested-With': 'XMLHttpRequest'
              },
              credentials: 'same-origin',
              body: JSON.stringify({
                name: fieldValue('name'),
                phone: fieldValue('phone'),
                email: fieldValue('email')
              })
            });
            var data = await res.json();
            if (res.status === 422 && data.errors) {
              showFieldErrors(data.errors);
              return;
            }
            if (!res.ok) {
              throw new Error('Unable to start chat.');
            }
            if (!data.conversation_id) {
              throw new Error('Unable to start chat session.');
            }
            session = {
              lead_uuid: data.lead_uuid,
              session_token: data.session_token,
              conversation_id: data.conversation_id
            };
            if (typeof window.suaveTrackEvent === 'function') {
              window.suaveTrackEvent('chat_lead', {
                lead_type: 'suave_agent',
                form_name: 'suave_agent_start'
              });
            }
            saveSession();
            showChat();
            messagesEl.innerHTML = '';
            await ensureMarked();
            if (data.greeting) appendMessage('assistant', data.greeting, true);
            historyLoaded = true;
            messageInput.disabled = false;
            setStatus('');
          } catch (err) {
            leadError.textContent = err.message || 'Unable to start chat.';
            leadError.hidden = false;
            setStatus('');
          } finally {
            submitBtn.disabled = false;
          }
        });

        async function readSse(response, onEvent) {
          var reader = response.body.getReader();
          var decoder = new TextDecoder();
          var buffer = '';

          while (true) {
            var chunk = await reader.read();
            if (chunk.done) break;
            buffer += decoder.decode(chunk.value, { stream: true });
            var parts = buffer.split('\n\n');
            buffer = parts.pop();
            parts.forEach(function (part) {
              var lines = part.split('\n');
              lines.forEach(function (line) {
                if (!line.startsWith('data: ')) return;
                var payload = line.slice(6).trim();
                if (!payload || payload === '[DONE]') return;
                try {
                  onEvent(JSON.parse(payload));
                } catch (e) {}
              });
            });
          }
        }

        composer.addEventListener('submit', async function (event) {
          event.preventDefault();
          if (streaming || !session) return;
          var text = (messageInput.value || '').trim();
          if (!text) return;

          streaming = true;
          messageInput.value = '';
          resizeComposer();
          appendMessage('user', text, false);
          var assistantBubble = appendMessage('assistant', '', false);
          var rawAssistant = '';
          setStatus('Reviewing your request…');
          await ensureMarked();

          try {
            var res = await fetch(chatUrl, {
              method: 'POST',
              headers: {
                'Accept': 'text/event-stream',
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrf,
                'X-Requested-With': 'XMLHttpRequest'
              },
              credentials: 'same-origin',
              body: JSON.stringify({
                message: text,
                lead_uuid: session.lead_uuid,
                session_token: session.session_token,
                conversation_id: session.conversation_id
              })
            });

            if (!res.ok) {
              var errBody = await res.json().catch(function () { return {}; });
              throw new Error(errBody.message || 'Chat failed.');
            }

            await readSse(res, function (event) {
              if (event.type === 'tool_call' || event.type === 'tool_result') {
                setStatus('Processing your request…');
              }
              if (event.type === 'text_delta' && typeof event.delta === 'string') {
                setStatus('');
                rawAssistant += event.delta;
                assistantBubble.textContent = rawAssistant;
                messagesEl.scrollTop = messagesEl.scrollHeight;
              }
              if (event.tool_name === 'EscalateToSales' || (event.type === 'tool_call' && event.tool_name === 'EscalateToSales')) {
                messageInput.disabled = true;
              }
            });

            if (!rawAssistant.trim()) {
              rawAssistant = 'Thanks — a teammate will follow up shortly if needed.';
            }
            setAssistantHtml(assistantBubble, rawAssistant);
            setStatus('');
          } catch (err) {
            assistantBubble.textContent = err.message || 'Something went wrong. Please try again.';
            setStatus('');
          } finally {
            streaming = false;
          }
        });

        messageInput.addEventListener('keydown', function (event) {
          if (event.key === 'Enter' && !event.shiftKey) {
            event.preventDefault();
            composer.requestSubmit();
          }
        });

        function resizeComposer() {
          // field-sizing: content handles growth in supporting browsers — skip layout thrash.
          if (typeof CSS !== 'undefined' && CSS.supports && CSS.supports('field-sizing', 'content')) {
            messageInput.style.height = '';
            return;
          }

          var max = 12 + 12 + (1.45 * 16 * 3); // matches CSS max-height formula
          var previous = messageInput.style.height;
          messageInput.style.height = 'auto';
          var next = messageInput.scrollHeight;
          if (max > 0) {
            next = Math.min(next, max);
          }
          var nextPx = next + 'px';
          // Avoid a second style write when height did not change.
          if (previous === nextPx) {
            return;
          }
          messageInput.style.height = nextPx;
        }

        messageInput.addEventListener('input', resizeComposer);
        // Do not call resizeComposer() on load — chat starts hidden and it forced a reflow.

        async function startWithSession(data) {
          if (!data || !data.conversation_id) return;
          session = {
            lead_uuid: data.lead_uuid,
            session_token: data.session_token,
            conversation_id: data.conversation_id
          };
          saveSession();
          setOpen(true);
          showChat();
          messagesEl.innerHTML = '';
          await ensureMarked();
          if (data.greeting) appendMessage('assistant', data.greeting, true);
          historyLoaded = true;
          messageInput.disabled = false;
          setStatus('');
          setTimeout(function () {
            if (messageInput) messageInput.focus();
          }, 150);
        }

        window.SuaveAgent = {
          open: function () {
            setOpen(true);
            ensureMarked();
            resumeIfPossible(false);
          },
          close: function () {
            setOpen(false);
          },
          startWithSession: startWithSession,
          startWithContact: async function (contact, name) {
            setOpen(true);
            showChat();
            messagesEl.innerHTML = '';
            setStatus('Starting conversation…');
            try {
              var res = await fetch(startUrl, {
                method: 'POST',
                headers: {
                  'Accept': 'application/json',
                  'Content-Type': 'application/json',
                  'X-CSRF-TOKEN': csrf,
                  'X-Requested-With': 'XMLHttpRequest'
                },
                credentials: 'same-origin',
                body: JSON.stringify({
                  contact: contact,
                  name: name || ''
                })
              });
              var data = await res.json();
              if (!res.ok || !data.conversation_id) {
                throw new Error(data.message || 'Unable to start chat.');
              }
              await startWithSession(data);
            } catch (err) {
              setStatus('');
              showLead();
              leadError.textContent = err.message || 'Unable to start chat.';
              leadError.hidden = false;
            }
          }
        };

        function scheduleAutoOpen() {
          window.setTimeout(function () {
            if (autoOpenDismissed || !panel.hidden) return;
            window.SuaveAgent.open();
          }, 5000);
        }

        if (document.readyState === 'complete') {
          scheduleAutoOpen();
        } else {
          window.addEventListener('load', scheduleAutoOpen);
        }

        window.addEventListener('suave-agent:start', function (e) {
          if (e.detail && e.detail.chat_session) {
            startWithSession(e.detail.chat_session);
          } else if (e.detail && e.detail.contact) {
            window.SuaveAgent.startWithContact(e.detail.contact, e.detail.name);
          }
        });
      })();
    </script>
  @endpush
@endonce
