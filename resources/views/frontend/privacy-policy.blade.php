@extends('layouts.frontend')

@php($siteUrl = rtrim((string) config('app.url'), '/'))

@section('content')
<!-- Privacy Policy Hero Start -->
<section class="legal-hero relative z-10 w-full pb-10 pt-8 md:pb-12 md:pt-10 lg:pb-14 lg:pt-[52px] site-container">
  <nav class="blog-breadcrumb" aria-label="Breadcrumb">
    <a href="{{ route('home') }}">Home</a>
    <span aria-hidden="true">/</span>
    <span aria-current="page">Privacy Policy</span>
  </nav>
  <h1 class="legal-hero__title">Privacy Policy</h1>
  <p class="legal-hero__lead">How Suave Creators collects, uses, and protects your information.</p>
</section>
<!-- Privacy Policy Hero End -->

<!-- Privacy Policy Content Start -->
<section class="full-bleed bg-cover bg-top bg-no-repeat py-12 sm:py-16 lg:py-20"
  style="background-image: url('{{ asset('assets/background/technology-section-bg.png') }}');"
  aria-labelledby="privacy-policy-heading">
  <div class="section-inner">
    <article class="legal-page" id="privacy-policy-heading">
      <section class="legal-page__section">
        <h2>1. Introduction</h2>
        <p>The personal privacy of our website users is very crucial to us. So there is a set of principles we follow here at Suave Creators. These principles are intended to protect the user’s private data.</p>
        <p>We are committed to protect your privacy by developing technology that ensures a safe online experience when you visit our site.</p>
        <p class="legal-page__note"><strong>NOTE:</strong> We collect and manage your personal information ourselves only. We do not sell, share, or rent any personal information provided by the data subject to any third party.</p>
      </section>

      <section class="legal-page__section">
        <h2>2. Information We Collect</h2>

        <h3>A. Personal Information</h3>
        <p>When you contact us or submit forms, we may collect:</p>
        <ul>
          <li>Your Name</li>
          <li>Your Email address</li>
          <li>Your Phone number</li>
          <li>Your Company name</li>
          <li>Your Service or complete Project details</li>
        </ul>
        <p>This personal information helps us understand your business requirements and provide customised solutions.</p>

        <h3>B. Technical &amp; Usage Data</h3>
        <p>When you use our services or saw content, we may automatically take and store some useful information. This may include:</p>
        <ul>
          <li>Internet Protocol (IP address)</li>
          <li>Device information and Browser data</li>
          <li>Pages visited, time spent, and referral URLs</li>
        </ul>
        <p>This user information helps us analyse website performance and enhance your experience.</p>

        <h3>C. Optional Information</h3>
        <ul>
          <li>Contact us form or inquiry forms</li>
          <li>Newsletter or email subscriptions</li>
          <li>Feedback forms, surveys, etc.</li>
        </ul>
      </section>

      <section class="legal-page__section">
        <h2>3. How We Use Your Information</h2>
        <ul>
          <li>Offering and improving our services</li>
          <li>Responding to user requests and inquiries</li>
          <li>Improving the website, services, and products</li>
          <li>Sending updates, promotional materials, and emailers</li>
          <li>Ensuring website security and functionality</li>
          <li>Compliance with legal, regulatory, or contractual obligations</li>
        </ul>
        <p>We do not sell, trade, or transfer your personal information to outside parties.</p>
      </section>

      <section class="legal-page__section">
        <h2>4. Cookies Policy</h2>
        <p>Our website uses cookies and similar technologies to improve your user experience.</p>
        <h3>What are cookies?</h3>
        <p>Cookies are small data files stored on your device that help us:</p>
        <ul>
          <li>Recognise returning visitors</li>
          <li>Analyse website traffic and usage</li>
          <li>Save preferences for faster navigation</li>
        </ul>
        <p>You can manage or disable cookies in your browser settings. However, disabling cookies may affect website functionality.</p>
      </section>

      <section class="legal-page__section">
        <h2>5. Information Sharing</h2>
        <p>We may share limited information only when it is required:</p>
        <ul>
          <li>With trusted partners assisting in operations or marketing (under confidentiality agreements)</li>
          <li>With legal authorities, if required to comply with applicable laws</li>
          <li>Within the Suave Creators group entities for internal processing</li>
        </ul>
        <p>We confirm that all shared data is handled securely within this policy.</p>
      </section>

      <section class="legal-page__section">
        <h2>6. Data Security</h2>
        <p>We follow industry-standard measures to protect your data:</p>
        <ul>
          <li>SSL encryption for secure transmission</li>
          <li>Regular data monitoring and restricted access</li>
          <li>Secure cloud storage with encryption protocols</li>
        </ul>
      </section>

      <section class="legal-page__section">
        <h2>7. Your Rights and Choices</h2>
        <p>You have the right to:</p>
        <ul>
          <li>Access, correct, or update your personal data</li>
          <li>Request deletion of your data</li>
          <li>Withdraw consent for marketing communication</li>
          <li>Request details about data usage or sharing</li>
        </ul>
        <p>To exercise these rights, please contact us at <a href="mailto:info@suavecreators.com">info@suavecreators.com</a>.</p>
      </section>

      <section class="legal-page__section">
        <h2>8. Children’s Privacy</h2>
        <p>Our services are not directed toward minors under 13 years of age. We do not knowingly collect personal details from minors. If you believe a minor has shared information with us, contact us immediately for removal.</p>
      </section>

      <section class="legal-page__section">
        <h2>9. Links to Other Websites</h2>
        <p>Our website may contain links to external websites. Suave Creators is not responsible for the privacy practices of third-party sites. We encourage users to review the privacy policies of any linked sites they visit.</p>
      </section>

      <section class="legal-page__section">
        <h2>10. Data Retention</h2>
        <p>We retain your data only as long as necessary to fulfil the purposes outlined in this policy or to comply with legal requirements.</p>
      </section>

      <section class="legal-page__section">
        <h2>11. Electronic Communication</h2>
        <p>You may unsubscribe from promotional communications at any time by clicking the unsubscribe link in our emails.</p>
      </section>

      <section class="legal-page__section">
        <h2>12. Governing Law</h2>
        <p>This Privacy Policy is governed by the laws of India. Any disputes shall be subject to the jurisdiction of the courts of Himachal Pradesh, India.</p>
      </section>

      <section class="legal-page__section">
        <h2>13. Updates to This Policy</h2>
        <p>We may revise or update this Privacy Policy from time to time. Changes will be effective upon posting on this page with the updated date.</p>
      </section>

      <section class="legal-page__section">
        <h2>14. Contact Us</h2>
        <p>
          <strong>Suave Creators</strong><br>
          @foreach (\App\Support\Frontend\ContactSupport::offices() as $office)
            <span class="block mt-2"><strong>{{ $office['label'] }}:</strong><br>
              @foreach ($office['lines'] as $line)
                {{ $line }}@if (! $loop->last)<br>@endif
              @endforeach
            </span>
          @endforeach
        </p>
        <ul class="legal-page__contact">
          <li><a href="mailto:info@suavecreators.com">info@suavecreators.com</a></li>
          <li><a href="{{ $siteUrl }}" target="_blank" rel="noopener noreferrer">{{ $siteUrl }}</a></li>
        </ul>
      </section>
    </article>
  </div>
</section>
<!-- Privacy Policy Content End -->
@endsection
