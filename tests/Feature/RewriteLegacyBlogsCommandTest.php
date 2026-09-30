<?php

namespace Tests\Feature;

use App\Ai\Agents\BlogRewriteAgent;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\User;
use App\Services\BlogDraftGenerationService;
use App\Services\BlogRewriteService;
use App\Services\BlogService;
use App\Support\Blogs\BlogInternalLinks;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class RewriteLegacyBlogsCommandTest extends TestCase
{
    use RefreshDatabase;

    private const IMAGE = '<p><img alt="Legacy chart" src="/storage/blogs/content/legacy-post-2.webp"></p>';

    private const SPACING = 'width: 100%; margin-top: 20px; margin-bottom: 20px';

    /**
     * @var list<array<string, mixed>>
     */
    private array $responses = [];

    private int $calls = 0;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('public');
        config([
            'ai.providers.openai.key' => 'test-key',
            'blogs.rewrite.below_id' => 70,
            'blogs.rewrite.length_tolerance' => 0.15,
            'blogs.rewrite.max_attempts' => 3,
            'blogs.rewrite.min_links' => 3,
        ]);

        $test = $this;
        $this->app->bind(BlogRewriteService::class, function ($app) use ($test) {
            return new class($app->make(BlogService::class), $app->make(BlogDraftGenerationService::class), $test) extends BlogRewriteService
            {
                public function __construct($blogs, $drafts, private RewriteLegacyBlogsCommandTest $test)
                {
                    parent::__construct($blogs, $drafts);
                }

                protected function requestRewrite(BlogRewriteAgent $agent, string $prompt, string $model): array
                {
                    return $this->test->nextResponse($prompt);
                }
            };
        });

        $this->seedPosts();
    }

    /**
     * Hand the next queued fake model payload to the service.
     *
     * @return array<string, mixed>
     */
    public function nextResponse(string $prompt): array
    {
        $this->calls++;

        return array_shift($this->responses) ?? $this->validPayload();
    }

    public function test_rewrite_saves_content_keeps_images_and_backs_up_table(): void
    {
        $this->responses = [$this->validPayload()];
        DB::table('blogs')->where('id', 5)->update(['created_at' => '2024-01-01 09:00:00', 'updated_at' => '2024-02-01 09:00:00']);
        $legacyBefore = Blog::query()->find(5);

        $this->artisan('run-once:rewrite-legacy-blogs', ['blog' => '5'])
            ->expectsOutputToContain('Original saved to blogs_backup.')
            ->assertSuccessful();

        $legacy = Blog::query()->find(5);
        $content = (string) $legacy->content;

        $this->assertStringContainsString('src="/storage/blogs/content/legacy-post-2.webp"', $content);
        $this->assertStringContainsString('alt="Legacy chart"', $content);
        $this->assertSame(1, substr_count($content, '<img'));
        $this->assertStringNotContainsString('[[IMG_', $content);
        $this->assertStringContainsString('href="/contact-us"', $content);
        $this->assertMatchesRegularExpression('#<img[^>]*style="width: 100%; margin-top: 20px; margin-bottom: 20px"#', $content);
        $this->assertDoesNotMatchRegularExpression('#<p\b[^>]*>\s*<img#i', $content);
        $this->assertSame(
            substr_count($content, '<a '),
            preg_match_all('#<a\b[^>]*style="text-decoration: none#', $content)
        );
        $this->assertCount(3, $legacy->faqs);

        $this->assertSame($legacyBefore->title, $legacy->title);
        $this->assertSame($legacyBefore->slug, $legacy->slug);
        $this->assertSame($legacyBefore->featured_image, $legacy->featured_image);
        $this->assertSame((string) $legacyBefore->getRawOriginal('created_at'), (string) $legacy->getRawOriginal('created_at'));
        $this->assertSame((string) $legacyBefore->getRawOriginal('updated_at'), (string) $legacy->getRawOriginal('updated_at'));
        $this->assertSame((string) $legacyBefore->getRawOriginal('published_at'), (string) $legacy->getRawOriginal('published_at'));

        $this->assertTrue(Schema::hasTable('blogs_backup'));
        $this->assertSame([5], DB::table('blogs_backup')->pluck('blog_id')->map(fn ($id): int => (int) $id)->all());
        $this->assertSame((string) $legacyBefore->content, (string) DB::table('blogs_backup')->value('content'));
    }

    public function test_restore_brings_back_the_original_even_after_rewriting_twice(): void
    {
        $original = (string) Blog::query()->find(5)->content;
        $this->responses = [$this->validPayload(), $this->validPayload()];

        $this->artisan('run-once:rewrite-legacy-blogs', ['blog' => '5'])->assertSuccessful();
        $this->artisan('run-once:rewrite-legacy-blogs', ['blog' => '5'])
            ->expectsOutputToContain('Original already in blogs_backup (kept unchanged).')
            ->assertSuccessful();
        $this->assertNotSame($original, (string) Blog::query()->find(5)->content);
        $this->assertSame(1, DB::table('blogs_backup')->count());

        $this->artisan('run-once:restore-blog-content')->assertFailed();
        DB::table('blogs')->where('id', 5)->update(['updated_at' => '2024-02-01 09:00:00']);
        $this->artisan('run-once:restore-blog-content', ['--blog' => '5'])->assertSuccessful();

        $this->assertSame($original, (string) Blog::query()->find(5)->content);
        $this->assertSame('2024-02-01 09:00:00', (string) DB::table('blogs')->where('id', 5)->value('updated_at'));
    }

    public function test_banned_phrase_triggers_retry_then_passes(): void
    {
        $bad = $this->validPayload();
        $bad['content'] = str_replace('Most stores', 'In today\'s fast-paced digital landscape most stores', $bad['content']);
        $this->responses = [$bad, $this->validPayload()];

        $this->artisan('run-once:rewrite-legacy-blogs', ['blog' => '5', '--skip-backup' => true])->assertSuccessful();

        $this->assertSame(2, $this->calls);
        $this->assertStringNotContainsString('fast-paced', (string) Blog::query()->find(5)->content);
    }

    public function test_disallowed_link_missing_image_and_wrong_length_are_rejected(): void
    {
        $service = $this->app->make(BlogRewriteService::class);
        $tokens = ['[[IMG_1]]' => self::IMAGE];

        $badLink = str_replace('/services/e-commerce-development', '/technologies/php-development', $this->validPayload()['content']);
        $this->assertNotEmpty(array_filter(
            $service->validate($badLink, $tokens, ''),
            fn (string $e): bool => str_contains($e, '/technologies/php-development')
        ));

        $noImage = str_replace('<p>[[IMG_1]]</p>', '', $this->validPayload()['content']);
        $this->assertNotEmpty(array_filter(
            $service->validate($noImage, $tokens, ''),
            fn (string $e): bool => str_contains($e, '[[IMG_1]]')
        ));

        $tooShort = '<p>[[IMG_1]]</p><p>Short. <a href="/services/e-commerce-development">a</a> <a href="/services/custom-crm-development">b</a> <a href="/services/web-development-services">c</a> <a href="/contact-us">d</a></p>';
        $this->assertNotEmpty(array_filter(
            $service->validate($tooShort, $tokens, ''),
            fn (string $e): bool => str_contains($e, 'too short')
        ));
    }

    public function test_invented_figures_ai_constructions_and_faq_phrases_are_rejected(): void
    {
        $service = $this->app->make(BlogRewriteService::class);
        $tokens = ['[[IMG_1]]' => self::IMAGE];
        $html = $this->validPayload()['content'];

        $invented = str_replace('Most stores', 'Errors fell 30% and most stores', $html);
        $this->assertNotEmpty(array_filter($service->validate($invented, $tokens, '<p>Old copy</p>'), fn (string $e): bool => str_contains($e, '30%')));
        $this->assertSame([], array_filter($service->validate($invented, $tokens, '<p>Errors fell 30% last year.</p>'), fn (string $e): bool => str_contains($e, '30%')));

        $notJust = str_replace('Most stores', 'A template is not just a theme, it\'s a ceiling and most stores', $html);
        $this->assertNotEmpty(array_filter($service->validate($notJust, $tokens, ''), fn (string $e): bool => str_contains($e, 'not just a theme, it\'s a ceiling')));

        $headingThenBut = str_replace('Where Templates Start Costing You Sales</h2><p>', 'Revenue Comes From Loyalty, Not Just New Visitors</h2><p>Stores chase new customers, but ', $html);
        $this->assertSame([], array_filter($service->validate($headingThenBut, $tokens, ''), fn (string $e): bool => str_contains($e, 'not just') || str_contains($e, 'contrasts')));

        $plainJust = str_replace('Most stores', 'Speed is just one factor, but most stores', $html);
        $this->assertSame([], array_filter($service->validate($plainJust, $tokens, ''), fn (string $e): bool => str_contains($e, 'not just')));

        $dashes = str_replace('Most stores', 'One — two — three — four — most stores', $html);
        $this->assertNotEmpty(array_filter($service->validate($dashes, $tokens, ''), fn (string $e): bool => str_contains($e, 'em dashes')));

        $faqs = [['question' => 'Is it safe?', 'answer' => 'Yes, it is robust.']];
        $this->assertNotEmpty(array_filter($service->validate($html, $tokens, '', false, $faqs), fn (string $e): bool => str_contains($e, 'robust')));
    }

    public function test_plain_word_swaps_touch_text_only(): void
    {
        $service = $this->app->make(BlogRewriteService::class);

        $html = $service->swapPlainWords('<p class="robust">Seamless checkout, robust sync, and seamlessly empowered teams.</p>');

        $this->assertSame('<p class="robust">Smooth checkout, reliable sync, and smoothly helped teams.</p>', $html);
    }

    public function test_excess_em_dashes_are_reduced_to_the_limit(): void
    {
        config(['blogs.rewrite.em_dash_per_100_words' => 0.0]);
        $service = $this->app->make(BlogRewriteService::class);

        $html = $service->reduceEmDashes('<p>Speed matters — a lot — for stores. Data — yours — should stay put. One more — here.</p>');

        $this->assertSame('<p>Speed matters (a lot) for stores. Data (yours) should stay put. One more, here.</p>', $html);
    }

    public function test_page_links_must_sit_in_the_body_not_only_the_closing(): void
    {
        $service = $this->app->make(BlogRewriteService::class);
        $tokens = ['[[IMG_1]]' => self::IMAGE];
        $has = fn (array $errors, string $needle): bool => array_filter($errors, fn (string $e): bool => str_contains($e, $needle)) !== [];
        $filler = implode(' ', array_fill(0, 14, 'Checkout speed and data ownership matter here.'));

        $bunched = '<p>Most stores outgrow their template quietly.</p>'
            .'<h2 id="a">Where templates cost sales</h2><p>'.$filler.'</p><p>[[IMG_1]]</p>'
            .'<h2 id="b">Deciding whether to rebuild</h2><p>See our <a href="/services/e-commerce-development">e-commerce work</a>, '
            .'<a href="/services/custom-crm-development">CRM builds</a> and <a href="/services/web-development-services">web builds</a>, '
            .'then <a href="/contact-us">send us your app list</a>.</p>';
        $this->assertTrue($has($service->validate($bunched, $tokens, ''), 'not in the closing section'));

        $late = '<p>Most stores outgrow their template quietly.</p>'
            .'<h2 id="a">Where templates cost sales</h2><p>'.$filler.' <a href="/services/e-commerce-development">e-commerce work</a>, '
            .'<a href="/services/custom-crm-development">CRM builds</a>, <a href="/services/web-development-services">web builds</a>.</p><p>[[IMG_1]]</p>'
            .'<h2 id="b">Deciding whether to rebuild</h2><p><a href="/contact-us">Send us your app list</a>.</p>';
        $this->assertTrue($has($service->validate($late, $tokens, ''), 'first page link comes too late'));

        $this->assertFalse($has($service->validate($this->validPayload()['content'], $tokens, ''), 'link'));
    }

    public function test_ai_writing_signals_are_rejected(): void
    {
        $service = $this->app->make(BlogRewriteService::class);
        $tokens = ['[[IMG_1]]' => self::IMAGE];
        $html = $this->validPayload()['content'];
        $title = 'E-Commerce Beyond Shopify: How Custom Platforms Outperform Templates';
        $has = fn (array $errors, string $needle): bool => array_filter($errors, fn (string $e): bool => str_contains($e, $needle)) !== [];

        $formulaic = str_replace('Plan Your Move Off the Template', 'Personalization That Drives Repeat Purchases', $html);
        $this->assertTrue($has($service->validate($formulaic, $tokens, ''), 'stock'));

        $slogan = str_replace('Plan Your Move Off the Template', 'Your Store Should Be as Fast and Flexible as Your Team', $html);
        $this->assertTrue($has($service->validate($slogan, $tokens, ''), 'stock'));

        $titleHeading = str_replace('Plan Your Move Off the Template', $title, $html);
        $this->assertTrue($has($service->validate($titleHeading, $tokens, '', false, [], $title), 'repeats the post title'));
        $this->assertStringNotContainsString($title, $service->stripTitleHeadings($titleHeading, $title));

        $duplicate = str_replace('Plan Your Move Off the Template', 'Where Templates Start Costing You Sales', $html);
        $this->assertTrue($has($service->validate($duplicate, $tokens, ''), 'appears twice'));

        $authority = str_replace('Most stores', 'Our architects see it constantly. Most stores', $html);
        $this->assertTrue($has($service->validate($authority, $tokens, ''), 'see it constantly'));

        $filler = str_replace('Most stores', 'A rebuild lets you sell smarter and drive growth. Most stores', $html);
        $this->assertTrue($has($service->validate($filler, $tokens, ''), 'sell smarter'));

        $claims = str_replace('Most stores', 'If a page takes longer than three seconds, most visitors will bounce, and a custom build pays for itself within a year. Most stores', $html);
        $errors = $service->validate($claims, $tokens, '<p>Old copy.</p>');
        $this->assertTrue($has($errors, 'three seconds'));
        $this->assertTrue($has($errors, 'most visitors'));
        $this->assertTrue($has($errors, 'pays for itself within a year'));
        $this->assertFalse($has($service->validate($claims, $tokens, '<p>Pages slower than three seconds lose most visitors; it pays for itself within a year.</p>'), 'is not in the original'));

        $contrasts = str_replace('Most stores', 'It is not about launch speed, but about scale. The goal is not features, but fit. Most stores', $html);
        $this->assertTrue($has($service->validate($contrasts, $tokens, ''), 'contrasts'));

        $stuffed = str_replace('Most stores', str_repeat('Custom e-commerce wins here. ', 7).'Most stores', $html);
        $this->assertTrue($has($service->validate($stuffed, $tokens, ''), '"custom e-commerce" appears'));

        $this->assertSame([], $service->validate($html, $tokens, '', false, [], $title));
    }

    public function test_link_anchors_must_name_the_page_and_client_stories_are_rejected(): void
    {
        $service = $this->app->make(BlogRewriteService::class);
        $tokens = ['[[IMG_1]]' => self::IMAGE];
        $html = $this->validPayload()['content'];
        $has = fn (array $errors, string $needle): bool => array_filter($errors, fn (string $e): bool => str_contains($e, $needle)) !== [];

        $vague = str_replace('CRM built around your sales process', 'setup that connects your tools', $html);
        $this->assertTrue($has($service->validate($vague, $tokens, ''), 'uses the anchor "setup that connects your tools"'));

        $story = str_replace('Most stores', 'One mid-size distributor we worked with cut order processing time in half. Most stores', $html);
        $errors = $service->validate($story, $tokens, '<p>Old copy.</p>');
        $this->assertTrue($has($errors, 'invented client story'));
        $this->assertTrue($has($errors, '"in half"'));

        $twice = str_replace('Most stores', 'A <a href="/services/custom-crm-development">CRM rebuild</a> helps. Most stores', $html);
        $this->assertTrue($has($service->validate($twice, $tokens, ''), 'linked 2 times'));

        $shortNotJust = str_replace('Most stores', "It's not just technical. Most stores", $html);
        $this->assertTrue($has($service->validate($shortNotJust, $tokens, ''), 'not just'));

        $this->assertTrue(BlogInternalLinks::anchorFits('e-commerce platforms', ['ecommerce', 'commerce']));
        $this->assertTrue(BlogInternalLinks::anchorFits('our AI agents', ['ai', 'agent']));
        $this->assertFalse(BlogInternalLinks::anchorFits('a purpose-built system', ['enterprise']));
    }

    public function test_no_em_dashes_by_default_and_ranges_survive(): void
    {
        $service = $this->app->make(BlogRewriteService::class);
        $tokens = ['[[IMG_1]]' => self::IMAGE];

        $oneDash = str_replace('Most stores', 'Speed matters — most stores', $this->validPayload()['content']);
        $this->assertNotEmpty(array_filter($service->validate($oneDash, $tokens, ''), fn (string $e): bool => str_contains($e, 'Remove all 1 em dashes')));

        $faqDash = [['question' => 'Is it quick?', 'answer' => 'Usually — within a quarter.']];
        $this->assertNotEmpty(array_filter($service->validate($this->validPayload()['content'], $tokens, '', false, $faqDash), fn (string $e): bool => str_contains($e, 'em dashes')));

        $this->assertSame(
            '<p>Builds run $45,000 – $85,000 over 8 - 14 weeks, and the team, not the tool, sets the pace. Always on, and it matters.</p>',
            $service->reduceEmDashes('<p>Builds run $45,000 – $85,000 over 8 - 14 weeks, and the team – not the tool – sets the pace. Always on&mdash;and it matters.</p>')
        );
    }

    public function test_rewrite_without_optional_sections_passes_validation(): void
    {
        $service = $this->app->make(BlogRewriteService::class);
        $html = $this->validPayload()['content'];

        $this->assertStringNotContainsString('<table', $html);
        $this->assertSame([], $service->validate($html, ['[[IMG_1]]' => self::IMAGE], ''));
    }

    public function test_images_round_trip_byte_for_byte(): void
    {
        $service = $this->app->make(BlogRewriteService::class);
        $html = '<p>Intro</p>'.self::IMAGE.'<figure class="x"><img src="/a.webp" alt="A"><figcaption>Cap</figcaption></figure><p>Text <img src="/b.webp" alt="B"> inline</p>';

        $tokenized = $service->tokenizeImages($html);

        $this->assertCount(3, $tokenized['tokens']);
        $this->assertStringNotContainsString('<img', $tokenized['html']);
        $this->assertSame(
            '<p>Intro</p><img style="'.self::SPACING.'" alt="Legacy chart" src="/storage/blogs/content/legacy-post-2.webp">'
            .'<figure class="x"><img src="/a.webp" alt="A"><figcaption>Cap</figcaption></figure>'
            ."<p>Text inline</p>\n<img style=\"".self::SPACING.'" src="/b.webp" alt="B">'."\n",
            $service->restoreImages($tokenized['html'], $tokenized['tokens'])
        );
    }

    public function test_posts_at_or_above_below_id_are_never_touched(): void
    {
        $human = (string) Blog::query()->find(70)->content;

        $this->artisan('run-once:rewrite-legacy-blogs', ['blog' => '70'])
            ->expectsOutputToContain('is never rewritten')
            ->assertFailed();
        $this->artisan('run-once:rewrite-legacy-blogs', ['blog' => 'human-post'])->assertFailed();

        $this->assertSame($human, (string) Blog::query()->find(70)->content);
        $this->assertSame(0, $this->calls);
    }

    public function test_dry_run_writes_preview_and_saves_nothing(): void
    {
        $original = (string) Blog::query()->find(5)->content;

        $this->artisan('run-once:rewrite-legacy-blogs', ['blog' => 'legacy-post', '--dry-run' => true])
            ->expectsOutputToContain('Preview written to')
            ->assertSuccessful();

        $this->assertSame($original, (string) Blog::query()->find(5)->content);
        $this->assertFileExists(storage_path('app/blog-rewrites/5-legacy-post.html'));
        @unlink(storage_path('app/blog-rewrites/5-legacy-post.html'));
    }

    public function test_links_are_not_underlined(): void
    {
        $service = $this->app->make(BlogRewriteService::class);

        $this->assertSame(
            '<p><a style="text-decoration: none" href="/contact-us">Talk</a> <a href="/x" style="text-decoration:none">X</a> <a href="/y" style="text-decoration: none; color: red">Y</a></p>',
            $service->unUnderlineLinks('<p><a href="/contact-us">Talk</a> <a href="/x" style="text-decoration:none">X</a> <a href="/y" style="color: red">Y</a></p>')
        );
    }

    public function test_legacy_links_are_normalized(): void
    {
        $service = $this->app->make(BlogRewriteService::class);

        $html = $service->normalizeLinks('<a href="https://www.suavecreators.com/service/e-commerce-development/">x</a><a href="https://suavecreators.com/industries/healthcare">y</a><a href="https://example.org/z">z</a>');

        $this->assertStringContainsString('href="/services/e-commerce-development"', $html);
        $this->assertStringContainsString('href="/industries/healthcare-software-development"', $html);
        $this->assertStringContainsString('href="https://example.org/z"', $html);
    }

    public function test_restored_images_get_their_own_spaced_block_like_human_posts(): void
    {
        $service = $this->app->make(BlogRewriteService::class);
        $img = '<img alt="Chart" class="max-w-full h-auto rounded-lg" src="/storage/blogs/content/x-1.webp" / title="Chart">';
        $spaced = '<img style="'.self::SPACING.'" alt="Chart" class="max-w-full h-auto rounded-lg" src="/storage/blogs/content/x-1.webp" / title="Chart">';

        $this->assertSame(
            '<p>Intro.</p>'.$spaced.'<h2>Next</h2>',
            $service->restoreImages('<p>Intro.</p><p>[[IMG_1]]</p><h2>Next</h2>', ['[[IMG_1]]' => '<p>'.$img.'</p>'])
        );

        $inline = $service->restoreImages('<p>Some text.<br><br>[[IMG_1]]</p><p>More.</p>', ['[[IMG_1]]' => $img]);
        $this->assertSame("<p>Some text.</p>\n".$spaced."\n<p>More.</p>", $inline);

        $heading = $service->restoreImages('<h2 id="a">Five Elements<br>[[IMG_1]]<br>1. Navigation</h2><p>Body.</p>', ['[[IMG_1]]' => $img]);
        $this->assertSame("<h2 id=\"a\">Five Elements1. Navigation</h2>\n".$spaced."\n<p>Body.</p>", $heading);

        $wrapped = '<p dir="ltr"><span style="font-weight: 700"><img src="/c.webp" alt="C"><br></span></p>';
        $this->assertSame('<p>A.</p><img style="'.self::SPACING.'" src="/c.webp" alt="C">', $service->restoreImages('<p>A.</p><p>[[IMG_1]]</p>', ['[[IMG_1]]' => $wrapped]));

        $this->assertSame(
            '<img src="/a.webp" style="'.self::SPACING.'; border-radius: 4px">',
            $service->spaceImages('<img src="/a.webp" style="width: 50%; margin: 0; border-radius: 4px">')
        );

        $figure = '<figure style="display: inline-block">'.$img.'<br></figure>';
        $this->assertSame('<p>A.</p>'.$figure, $service->restoreImages('<p>A.</p><p>[[IMG_1]]</p>', ['[[IMG_1]]' => $figure]));
    }

    public function test_rewrites_link_site_pages_only_never_blog_posts(): void
    {
        $service = $this->app->make(BlogRewriteService::class);

        $html = $service->normalizeLinks('<p>Read <a href="/blog/human-post">our guide</a> or <a href="https://suavecreators.com/blogs">the blog</a>, then <a href="/contact-us">talk to us</a>.</p>');
        $this->assertSame('<p>Read our guide or the blog, then <a href="/contact-us">talk to us</a>.</p>', $html);

        $this->assertNotContains('/blog/human-post', BlogInternalLinks::allowedPaths());

        $links = BlogInternalLinks::suggestForRewrite(Blog::query()->findOrFail(5), 6);
        $this->assertSame([], array_filter($links, fn (array $l): bool => BlogInternalLinks::isBlogPath($l['url'])));
        $this->assertGreaterThanOrEqual(3, count(array_filter($links, fn (array $l): bool => $l['type'] !== 'contact')));
    }

    /**
     * Valid fake payload: ~86 words (human post target 82, band 69–95), the image token once, three body links + contact CTA.
     *
     * @return array<string, mixed>
     */
    private function validPayload(): array
    {
        $filler = implode(' ', array_fill(0, 3, 'Checkout speed and data ownership matter here.'));
        $more = implode(' ', array_fill(0, 2, 'Checkout speed and data ownership matter here.'));

        return [
            'content' => '<p>Most stores outgrow their template quietly, one workaround at a time. Our <a href="/services/e-commerce-development">custom e-commerce team</a> sees this weekly.</p>'
                .'<h2 id="where-templates-break">Where Templates Start Costing You Sales</h2>'
                .'<p>'.$filler.' Pair it with a <a href="/services/custom-crm-development">CRM built around your sales process</a>. '.$more.'</p>'
                .'<p>[[IMG_1]]</p>'
                .'<p>Then add <a href="/services/web-development-services">a fast web storefront</a>.</p>'
                .'<h2 id="plan-your-move">Plan Your Move Off the Template</h2>'
                .'<p><strong>Scope Your Build:</strong> <a href="/contact-us">Schedule a free consultation</a>.</p>',
            'faqs' => [
                ['question' => 'When should we leave a template?', 'answer' => 'When workarounds cost more than a build.'],
                ['question' => 'How long does a custom build take?', 'answer' => 'Typically three to six months.'],
                ['question' => 'Do we keep our SEO?', 'answer' => 'Yes, with redirects mapped before launch.'],
            ],
            'sections_used' => [],
        ];
    }

    private function seedPosts(): void
    {
        $author = User::factory()->create();
        $category = BlogCategory::query()->create([
            'name' => 'Software Development',
            'slug' => 'software-development',
            'sort_order' => 1,
        ]);

        $words = implode(' ', array_fill(0, 20, 'Human written copy here.'));

        Blog::query()->forceCreate([
            'id' => 5,
            'blog_category_id' => $category->id,
            'created_by_id' => $author->id,
            'slug' => 'legacy-post',
            'title' => 'Legacy Post',
            'short_description' => 'Legacy excerpt.',
            'content' => '<p>Old intro.</p>'.self::IMAGE.'<p>Old body.</p>',
            'featured_image' => 'blogs/legacy-post.webp',
            'status' => Blog::STATUS_PUBLISHED,
            'published_at' => now()->subYear(),
        ]);

        Blog::query()->forceCreate([
            'id' => 70,
            'blog_category_id' => $category->id,
            'created_by_id' => $author->id,
            'slug' => 'human-post',
            'title' => 'Human Post',
            'short_description' => 'Human excerpt.',
            'content' => '<h2>Human heading</h2><p>'.$words.'</p>',
            'status' => Blog::STATUS_PUBLISHED,
            'published_at' => now()->subDay(),
        ]);
    }
}
