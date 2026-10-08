# Enquiry tracking deployment and verification

## Diagnosis and change

Existing tracking is inline in both Blade submit handlers through
`window.suaveTrackEvent`, which calls the existing Google tag. The popup sent
`form_name=contact_modal` and navigated immediately after queuing its event.
That navigation is a delivery race, not proof of the missing production hit.
Local browser regression checks reproduced two POSTs from repeated submit events.
Both handlers also accepted malformed HTTP 200 bodies as successful responses.

The fix adds initialization and in-flight guards, requires explicit server
`success` and `lead_tracked` flags, renames the popup to `contact_popup`, and waits
for Google's event callback before navigating, with a 2-second fallback. The
contact page retains `contact_us`. No tag, consent, GTM, revenue, server-side
business logic, or thank-you-page tracking is added or changed.

## Before deployment

Obtain production deployment approval. Deploy the Blade changes through the
normal site release process and clear/rebuild compiled views as that process
requires. No migration or asset build is needed for these inline-script changes.
The skill and regression test files document and verify the change.

Local browser checks use intercepted POST responses and gtag calls. Laravel
feature tests exercise real persistence and validation with an isolated test DB.
Neither proves receipt in the production GA4 property. Blocked tags, consent
restrictions, and network loss can prevent delivery; the browser emits at most
one event call per confirmed submission, without retrying Analytics.

## After approved deployment

1. Open Tag Assistant and connect to https://suavecreators.com. Use a browser
   without ad blocking and follow the site's existing consent choices. Confirm
   the existing tag's destination is G-5HX7B8X9QP (Google tag GT-5NXQXDJG).
   Do not add a GA4 tag to GTM-THXXRSV6.
2. In that property, open Admin > Data display > DebugView. If needed, enable
   Analytics debug mode using the Google Analytics Debugger extension. Check
   browser Network requests to `g/collect` for `en=generate_lead`, destination
   `tid=G-5HX7B8X9QP`, and `ep.form_name`.
3. Submit one legitimate test enquiry on /contact-us. Expect one generate_lead
   with form_name=contact_us after successful persistence. Double-click Submit;
   there should be only one final POST and one lead event. Refresh: no new lead.
4. Open the popup from a CTA. Opening it must produce no generate_lead. Submit a
   distinct legitimate test enquiry. Expect one generate_lead with
   form_name=contact_popup before the thank-you redirect. Refresh the thank-you
   page and go back: neither should emit another lead.
5. Try missing/invalid required fields: expect validation and no lead event.
   For server/network failure checks use staging or local request interception;
   do not disrupt the production endpoint. A retry after a failure must remain
   possible.
6. Confirm event parameters contain no name, email, phone, enquiry text, value,
   or currency. Check Realtime's event-name card and inspect each event's
   parameters; DebugView and Network are better for individual-hit diagnosis.
   Allow reporting latency and compare a baseline rather than aggregate counts
   that may include other visitors. If a hit is absent, check consent, blockers,
   Network transport, and tag configuration before adding tracking.

Google Ads conversion import and bidding changes are separate follow-up work.

## Local verification results (2026-10-08)

- Browser: 18 scenarios pass across both forms, including repeated script
  initialization, repeated submit events, popup opening, success, validation,
  HTTP/network failures, malformed responses, bot-filtered success, callback
  fallback and refresh. Google calls and server responses are intercepted.
- Scoped Laravel tests: 30 passed, 189 assertions (AnalyticsTrackingTest,
  ContactModalTest, ContactFormDraftTest).
- Full Laravel suite: 169/172 passed. Confirmed the same three failures against
  original HEAD Blade files: ConsultationCtaLabelTest::test_home_keeps_inline_consultation_field,
  NewServicePagesSeoTest::test_homepage_and_footer_link_new_services_and_industries,
  SeoSitelinksCleanupTest::test_homepage_exposes_clear_primary_sitelink_candidates.
- Pint and git diff whitespace check passed.
- Frontend audit: 53 pages, no status failures, no broken internal links, no
  missing source-string assets; failed on 36 absent local storage/blogs uploads.
  These uploads are outside the tracking change and were not replaced.
- Convention PowerShell script could not run: neither powershell nor pwsh is
  installed. Run this required gate on an environment with PowerShell before release.
