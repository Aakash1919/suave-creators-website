import { chromium } from 'playwright';
import assert from 'node:assert/strict';

// Local UI regression checks: submission responses and gtag are intercepted.
// Run against a local Laravel server: node tests/Browser/enquiry-tracking.mjs
const base = process.env.TRACKING_TEST_URL || 'http://127.0.0.1:8017';
const browser = await chromium.launch({ headless: true, channel: 'chrome' });
try {
  for (const [selector, expectedName] of [['[data-contact-form]', 'contact_us'], ['[data-contact-modal-form]', 'contact_popup']]) {
    for (const scenario of ['success', 'validation', 'server', 'network', 'malformed', 'rejected', 'bot', 'client', 'timeout']) {
      const page = await browser.newPage();
      let posts = 0;
      const events = [];
      await page.exposeFunction('recordLead', payload => events.push(payload));
      await page.addInitScript(({ scenario }) => {
        window.gtag = (command, name, payload) => {
          if (command === 'event' && name === 'generate_lead') {
            window.recordLead(JSON.parse(JSON.stringify(payload)));
            if (scenario !== 'timeout') setTimeout(() => payload.event_callback?.(), 100);
          }
        };
      }, { scenario });
      await page.route('**/*', async route => {
        const request = route.request();
        if (!request.url().startsWith(base)) return route.abort();
        if (request.method() !== 'POST') return route.continue();
        if (request.url().includes('draft')) return route.fulfill({ json: { success: true } });
        posts++;
        await new Promise(resolve => setTimeout(resolve, 100));
        if (scenario === 'network') return route.abort();
        if (scenario === 'malformed') return route.fulfill({ body: '<html>not JSON</html>' });
        return route.fulfill({ status: scenario === 'validation' ? 422 : scenario === 'server' ? 500 : 200,
          json: { success: scenario !== 'rejected', lead_tracked: scenario !== 'bot', errors: { email: ['Invalid email'] }, redirect: `${base}/thank-you` } });
      });
      await page.goto(`${base}/contact-us`, { waitUntil: 'domcontentloaded' });
      // Simulate scripts being evaluated again: handlers must remain single-bound.
      await page.evaluate(() => {
        for (const script of [...document.scripts]) {
          if (script.textContent.includes("const form = document.querySelector('[data-contact-form]')") ||
              script.textContent.includes("var modalRoot = document.querySelector('[data-contact-modal-root]')")) {
            (0, eval)(script.textContent);
          }
        }
        window.openContactModal?.();
      });
      assert.equal(events.length, 0, 'opening the popup must not track a lead');
      await page.evaluate(({ selector, scenario }) => {
        const form = document.querySelector(selector);
        if (scenario !== 'client') {
          for (const [name, value] of Object.entries({ name: 'Tracking Test', email: 'tracking@example.com', phone: '+919876543210', service: 'custom-software', message: 'Local tracking regression test.' })) {
            form.querySelector(`[name="${name}"]`).value = value;
          }
          form.querySelector('[data-phone-field-input]').value = '+919876543210';
        }
        // Bypass disabled buttons to exercise repeated submit events as well.
        form.dispatchEvent(new Event('submit', { bubbles: true, cancelable: true }));
        form.dispatchEvent(new Event('submit', { bubbles: true, cancelable: true }));
      }, { selector, scenario });
      const succeeds = ['success', 'timeout'].includes(scenario);
      if (succeeds && expectedName === 'contact_popup') await page.waitForURL('**/thank-you');
      else await page.waitForTimeout(400);
      assert.equal(posts, scenario === 'client' ? 0 : 1, `${expectedName}/${scenario}: submission count`);
      assert.equal(events.length, succeeds ? 1 : 0, `${expectedName}/${scenario}: event count`);
      if (succeeds) {
        assert.equal(events[0].form_name, expectedName);
        assert.ok(!JSON.stringify(events).match(/Tracking Test|tracking@example|9876543210|Local tracking|"value"|"currency"/));
        await page.reload({ waitUntil: 'domcontentloaded' });
        await page.waitForTimeout(150);
        assert.equal(events.length, 1, 'refresh must not replay leads');
      }
      console.log(`PASS ${expectedName}/${scenario}`);
      await page.close();
    }
  }
} finally { await browser.close(); }
