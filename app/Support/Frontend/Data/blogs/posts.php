<?php
/**
 * Sample blog posts for the /blogs listing and /blog/{slug} single template.
 * Each post: slug, title, image, short_description, content (HTML), author_name,
 * category, published_date, updated_date, toc (table of contents), faqs.
 */
return array(
  array(
    'slug' => 'digital-strategy-that-creates-value',
    'title' => 'How to Build a Digital Strategy That Creates Real Business Value',
    'image' => '/assets/blog/digital-strategy-collaboration.png',
    'short_description' => 'A practical framework for connecting customer needs, technology decisions, and measurable growth.',
    'author_name' => 'Suave Creators',
    'category' => 'Digital Strategy',
    'published_date' => '2026-07-10',
    'published_label' => 'Jul 10, 2026',
    'updated_date' => '2026-07-10',
    'toc' => array(
      array('id' => 'start-with-outcomes', 'label' => 'Start With Outcomes, Not Tools'),
      array('id' => 'map-the-customer-journey', 'label' => 'Map the Customer Journey First'),
      array('id' => 'choosing-the-right-technology', 'label' => 'Choosing the Right Technology'),
      array('id' => 'measure-what-matters', 'label' => 'Measure What Actually Matters'),
    ),
    'content' => '
      <p>Every business wants a “digital strategy”, but very few can describe what that phrase actually means for their day-to-day operations. A digital strategy is not a list of software to buy — it is a plan for how technology, people, and process work together to move a specific business metric.</p>
      <h2 id="start-with-outcomes">Start With Outcomes, Not Tools</h2>
      <p>The biggest mistake we see is teams picking a platform before they have agreed on the outcome. Whether the goal is reducing support tickets, increasing repeat purchases, or shortening onboarding time, the outcome should be defined in a single sentence before any tool is discussed.</p>
      <p>Once the outcome is locked, it becomes much easier to say no to distracting feature requests and “nice to have” integrations that do not move the number you actually care about.</p>
      <h2 id="map-the-customer-journey">Map the Customer Journey First</h2>
      <p>A short discovery workshop mapping how customers currently discover, evaluate, and use your product will surface more opportunities than any competitor analysis. Look specifically for moments where customers drop off, contact support, or hesitate before converting.</p>
      <h3>Common friction points</h3>
      <ul>
        <li>Slow or confusing onboarding flows</li>
        <li>Disconnected data between marketing, sales, and support tools</li>
        <li>Manual processes that delay a response to the customer</li>
      </ul>
      <h2 id="choosing-the-right-technology">Choosing the Right Technology</h2>
      <p>With outcomes and friction points defined, technology selection becomes a much narrower decision. We typically recommend starting with the smallest possible stack that solves the highest-friction problem, then expanding only when the first phase is proven.</p>
      <h2 id="measure-what-matters">Measure What Actually Matters</h2>
      <p>Instrument your strategy from day one. A dashboard that tracks the single outcome metric you defined earlier keeps every team member focused on the same goal, and makes it far easier to prove ROI to stakeholders after launch.</p>
    ',
    'faqs' => array(
      array('question' => 'How long does it take to build a digital strategy?', 'answer' => 'Most organisations can define a workable strategy in two to four weeks, including discovery workshops, journey mapping, and a technology shortlist.'),
      array('question' => 'Do we need a large team to execute a digital strategy?', 'answer' => 'No. A focused strategy with a clear outcome can often be executed by a small cross-functional team supported by the right tooling.'),
      array('question' => 'How do we know if our strategy is working?', 'answer' => 'Track the single outcome metric you defined at the start. If that metric is trending in the right direction, the strategy is working — even if the tactics evolve.'),
    ),
  ),
  array(
    'slug' => 'product-data-customer-experiences',
    'title' => 'Turning Product Data into Better Customer Experiences',
    'image' => '/assets/blog/product-experience-mapping.png',
    'short_description' => 'Learn how focused analytics can reveal friction, guide priorities, and improve every step of the user journey.',
    'author_name' => 'Suave Creators',
    'category' => 'Product Growth',
    'published_date' => '2026-06-24',
    'published_label' => 'Jun 24, 2026',
    'updated_date' => '2026-06-24',
    'toc' => array(
      array('id' => 'why-most-analytics-fail', 'label' => 'Why Most Analytics Setups Fail'),
      array('id' => 'the-three-signals-worth-tracking', 'label' => 'The Three Signals Worth Tracking'),
      array('id' => 'turning-signals-into-action', 'label' => 'Turning Signals Into Action'),
    ),
    'content' => '
      <p>Product teams collect enormous amounts of data, yet many still struggle to answer a simple question: what should we build next? The problem is rarely a lack of data — it is a lack of focus on the signals that actually predict customer behaviour.</p>
      <h2 id="why-most-analytics-fail">Why Most Analytics Setups Fail</h2>
      <p>Dashboards packed with vanity metrics create noise instead of clarity. Page views and session counts feel productive to track, but they rarely explain why a customer churned or upgraded.</p>
      <h2 id="the-three-signals-worth-tracking">The Three Signals Worth Tracking</h2>
      <p>We recommend narrowing focus to three categories of signal: activation (did the customer reach their first value moment), engagement (are they returning to the workflows that matter), and friction (where do they hesitate, retry, or contact support).</p>
      <h3>Activation</h3>
      <p>Define the specific action that correlates with long-term retention, then measure how quickly and how often new customers reach it.</p>
      <h3>Friction</h3>
      <p>Session replay and funnel drop-off data are some of the fastest ways to find UI and workflow problems that data alone will not reveal.</p>
      <h2 id="turning-signals-into-action">Turning Signals Into Action</h2>
      <p>Data is only valuable when it changes a roadmap decision. Review your top three signals every sprint and require that any new feature request references at least one of them before it is prioritised.</p>
    ',
    'faqs' => array(
      array('question' => 'What tools do you recommend for product analytics?', 'answer' => 'The right tool depends on your stack, but the principle matters more than the tool: track activation, engagement, and friction consistently.'),
      array('question' => 'How often should we review product data?', 'answer' => 'Weekly for fast-moving teams, and at minimum before every sprint planning session, so decisions stay grounded in real behaviour.'),
    ),
  ),
  array(
    'slug' => 'digital-workflows-teams-use',
    'title' => 'Designing Digital Workflows Your Team Will Actually Use',
    'image' => '/assets/blog/software-development-laptop-code.png',
    'short_description' => 'Simple principles for creating connected tools that reduce busywork and make collaboration easier.',
    'author_name' => 'Suave Creators',
    'category' => 'Future of Work',
    'published_date' => '2026-05-29',
    'published_label' => 'May 29, 2026',
    'updated_date' => '2026-05-29',
    'toc' => array(
      array('id' => 'why-tools-get-abandoned', 'label' => 'Why New Tools Get Abandoned'),
      array('id' => 'design-around-existing-habits', 'label' => 'Design Around Existing Habits'),
      array('id' => 'automate-the-boring-parts', 'label' => 'Automate the Boring Parts First'),
    ),
    'content' => '
      <p>Most workflow tools fail for the same reason: they were designed around a process diagram instead of the way people actually work. If a tool adds friction, teams quietly route around it within a few weeks.</p>
      <h2 id="why-tools-get-abandoned">Why New Tools Get Abandoned</h2>
      <p>New software is usually introduced to solve a visibility problem for managers, but the day-to-day user rarely sees a benefit for themselves. Without a clear personal win, adoption fades quickly after the initial rollout excitement.</p>
      <h2 id="design-around-existing-habits">Design Around Existing Habits</h2>
      <p>Effective workflow design starts by observing where work already happens — chat threads, spreadsheets, inboxes — and building bridges from those habits into the new system, rather than demanding an abrupt switch.</p>
      <h2 id="automate-the-boring-parts">Automate the Boring Parts First</h2>
      <p>Status updates, handoff notifications, and repetitive data entry are the easiest wins. Automating these tasks first builds trust in the new workflow before asking teams to change more complex behaviours.</p>
      <p>Once trust is established, teams are far more open to deeper process changes because they have already seen the tool save them real time.</p>
    ',
    'faqs' => array(),
  ),
  array(
    'slug' => 'ai-powered-software-development-2026',
    'title' => 'How AI Is Reshaping Software Development in 2026',
    'image' => '/assets/blog/digital-strategy-collaboration.png',
    'short_description' => 'From code generation to QA automation, AI tooling is changing how modern engineering teams ship software.',
    'author_name' => 'Suave Creators',
    'category' => 'Artificial Intelligence',
    'published_date' => '2026-05-14',
    'published_label' => 'May 14, 2026',
    'updated_date' => '2026-05-14',
    'toc' => array(
      array('id' => 'ai-across-the-sdlc', 'label' => 'AI Across the Development Lifecycle'),
      array('id' => 'where-ai-still-needs-a-human', 'label' => 'Where AI Still Needs a Human'),
      array('id' => 'getting-started-with-ai-tooling', 'label' => 'Getting Started With AI Tooling'),
    ),
    'content' => '
      <p>Artificial intelligence has moved well beyond chat assistants and into the daily toolkit of software teams — writing boilerplate, reviewing pull requests, generating test cases, and even flagging production incidents before customers notice.</p>
      <h2 id="ai-across-the-sdlc">AI Across the Development Lifecycle</h2>
      <p>Modern teams now use AI at nearly every stage: drafting technical specs, scaffolding new services, generating unit tests, and summarising incident postmortems. Each of these tasks used to consume hours of senior engineering time.</p>
      <h2 id="where-ai-still-needs-a-human">Where AI Still Needs a Human</h2>
      <p>Architecture decisions, security trade-offs, and product judgement calls still require experienced engineers. AI tooling accelerates execution, but the responsibility for correctness and business alignment remains firmly with the team.</p>
      <h2 id="getting-started-with-ai-tooling">Getting Started With AI Tooling</h2>
      <p>Start small: pick one repetitive task — code review comments, test generation, or documentation — and measure the time saved before expanding AI usage across the rest of the pipeline.</p>
    ',
    'faqs' => array(),
  ),
  array(
    'slug' => 'choosing-the-right-tech-stack',
    'title' => 'Choosing the Right Tech Stack for Your Startup',
    'image' => '/assets/blog/product-experience-mapping.png',
    'short_description' => 'A pragmatic guide to picking technology that supports growth without slowing your team down.',
    'author_name' => 'Suave Creators',
    'category' => 'Startups',
    'published_date' => '2026-04-30',
    'published_label' => 'Apr 30, 2026',
    'updated_date' => '2026-04-30',
    'toc' => array(
      array('id' => 'optimise-for-speed-of-learning', 'label' => 'Optimise for Speed of Learning'),
      array('id' => 'avoid-premature-scale', 'label' => 'Avoid Premature Scale'),
      array('id' => 'pick-boring-technology', 'label' => 'Pick Boring Technology Where You Can'),
    ),
    'content' => '
      <p>Founders often ask which framework or cloud provider is “best”. The honest answer is that the best stack is the one your team can ship and debug quickly, because early-stage speed of learning matters more than theoretical scalability.</p>
      <h2 id="optimise-for-speed-of-learning">Optimise for Speed of Learning</h2>
      <p>Every week spent evaluating infrastructure options is a week not spent learning from real customers. Choose tools your team already knows well enough to move fast on day one.</p>
      <h2 id="avoid-premature-scale">Avoid Premature Scale</h2>
      <p>Building for a million users before you have a hundred is one of the most common early-stage mistakes. Complex distributed architecture adds operational overhead that slows down the iteration your startup needs most.</p>
      <h2 id="pick-boring-technology">Pick Boring Technology Where You Can</h2>
      <p>Well-documented, widely adopted technology means faster hiring, easier debugging, and more available answers when something breaks at 2am. Save your innovation budget for the parts of the product that differentiate you.</p>
    ',
    'faqs' => array(),
  ),
  array(
    'slug' => 'ux-principles-that-drive-conversions',
    'title' => '5 UX Principles That Drive Conversions',
    'image' => '/assets/blog/software-development-laptop-code.png',
    'short_description' => 'Small, evidence-backed interface changes that consistently improve sign-ups, checkouts, and retention.',
    'author_name' => 'Suave Creators',
    'category' => 'Design',
    'published_date' => '2026-04-12',
    'published_label' => 'Apr 12, 2026',
    'updated_date' => '2026-04-12',
    'toc' => array(
      array('id' => 'reduce-decision-fatigue', 'label' => 'Reduce Decision Fatigue'),
      array('id' => 'design-for-the-first-five-seconds', 'label' => 'Design for the First Five Seconds'),
      array('id' => 'make-progress-visible', 'label' => 'Make Progress Visible'),
    ),
    'content' => '
      <p>Conversion-focused design is less about beautiful visuals and more about removing hesitation at each decision point. These five principles apply across sign-up flows, checkouts, and onboarding.</p>
      <h2 id="reduce-decision-fatigue">Reduce Decision Fatigue</h2>
      <p>Every extra field, option, or choice adds cognitive load. Trim forms to only what is essential for the next step, and defer optional details until after the primary action is complete.</p>
      <h2 id="design-for-the-first-five-seconds">Design for the First Five Seconds</h2>
      <p>Visitors decide whether to keep reading almost immediately. A clear headline paired with a single obvious next action outperforms a page full of competing calls to action.</p>
      <h2 id="make-progress-visible">Make Progress Visible</h2>
      <p>Multi-step flows should always show users where they are and how much is left. Progress indicators reduce abandonment because they set clear expectations about the remaining effort.</p>
    ',
    'faqs' => array(),
  ),
);
