<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\RespondsToAdminAjax;
use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\ChatLead;
use App\Models\ContactRequest;
use App\Models\User;
use App\Services\SeoAuditReportService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;
use Throwable;

class DashboardController extends Controller
{
    use RespondsToAdminAjax;

    /**
     * Render the admin home dashboard with permission-gated quick links and stats.
     */
    public function __invoke(Request $request): View
    {
        $user = $request->user();

        $canBlogs = $user->hasPermission('blogs.view');
        $canConversations = $user->hasPermission('conversations.view');
        $canContacts = $user->hasPermission('contacts.view');
        $canUsers = $user->hasPermission('users.view');
        $canProfile = $user->hasPermission('profile.update');
        $canSeoAudit = $user->hasPermission('seo.audit');

        $stats = collect([
            [
                'label' => 'Blog posts',
                'value' => $canBlogs ? Blog::query()->count() : null,
                'hint' => $canBlogs ? Blog::query()->where('status', Blog::STATUS_PUBLISHED)->count().' published' : null,
                'icon' => 'fa-newspaper',
                'tone' => '',
                'route' => 'admin.blogs.index',
                'show' => $canBlogs,
            ],
            [
                'label' => 'Chat leads',
                'value' => $canConversations ? ChatLead::query()->count() : null,
                'hint' => $canConversations
                    ? ChatLead::query()->whereNotNull('escalated_at')->count().' escalated'
                    : null,
                'icon' => 'fa-comments',
                'tone' => 'emerald',
                'route' => 'admin.conversations.index',
                'show' => $canConversations,
            ],
            [
                'label' => 'Contact requests',
                'value' => $canContacts ? ContactRequest::query()->count() : null,
                'hint' => $canContacts
                    ? ContactRequest::query()->where('status', ContactRequest::STATUS_NEW)->count().' new'
                        .(ContactRequest::query()->where('status', ContactRequest::STATUS_DRAFT)->count() > 0
                            ? ' · '.ContactRequest::query()->where('status', ContactRequest::STATUS_DRAFT)->count().' incomplete'
                            : '')
                    : null,
                'icon' => 'fa-envelope-open-text',
                'tone' => 'amber',
                'route' => 'admin.contacts.index',
                'show' => $canContacts,
            ],
            [
                'label' => 'Users',
                'value' => $canUsers ? User::query()->count() : null,
                'hint' => $canUsers ? 'Admin panel accounts' : null,
                'icon' => 'fa-users',
                'tone' => 'amber',
                'route' => 'admin.users.index',
                'show' => $canUsers,
            ],
            [
                'label' => 'Your profile',
                'value' => $canProfile ? 'Ready' : null,
                'hint' => $canProfile ? 'Update name, email, password' : null,
                'icon' => 'fa-user-gear',
                'tone' => 'rose',
                'route' => 'admin.profile.edit',
                'show' => $canProfile,
            ],
        ])->where('show', true)->values();

        return view('admin.dashboard', [
            'user' => $user,
            'stats' => $stats,
            'canSeoAudit' => $canSeoAudit,
            'seoReportTo' => (string) config('seo.audit_report.to', 'info@suavecreators.com'),
            'seoReportMailer' => (string) config('seo.audit_report.mailer', 'log'),
            'links' => collect([
                [
                    'label' => 'Blogs',
                    'description' => 'Create and publish marketing posts',
                    'icon' => 'fa-newspaper',
                    'route' => 'admin.blogs.index',
                    'show' => $canBlogs,
                ],
                [
                    'label' => 'AI Conversations',
                    'description' => 'Review SuaveAgent leads and transcripts',
                    'icon' => 'fa-comments',
                    'route' => 'admin.conversations.index',
                    'show' => $canConversations,
                ],
                [
                    'label' => 'Contacts',
                    'description' => 'Review contact form inquiries',
                    'icon' => 'fa-envelope-open-text',
                    'route' => 'admin.contacts.index',
                    'show' => $canContacts,
                ],
                [
                    'label' => 'Users',
                    'description' => 'Manage accounts and role access',
                    'icon' => 'fa-users',
                    'route' => 'admin.users.index',
                    'show' => $canUsers,
                ],
                [
                    'label' => 'Profile',
                    'description' => 'Update your account details',
                    'icon' => 'fa-user-gear',
                    'route' => 'admin.profile.edit',
                    'show' => $canProfile,
                ],
            ])->where('show', true)->values(),
        ]);
    }

    /**
     * Crawl sitemap URLs and deliver the SEO audit report (mail or log).
     */
    public function generateSeoReport(Request $request, SeoAuditReportService $auditor): JsonResponse|RedirectResponse
    {
        set_time_limit(0);

        try {
            $report = $auditor->generateAndDeliver();
        } catch (Throwable $e) {
            report($e);

            return $this->adminError($request, 'SEO audit failed: '.$e->getMessage());
        }

        $mailer = (string) config('seo.audit_report.mailer', 'log');
        $to = (string) config('seo.audit_report.to', 'info@suavecreators.com');
        $delivery = $mailer === 'log'
            ? "logged for {$to}"
            : "emailed to {$to}";

        $message = sprintf(
            'SEO audit report generated: %d pages (%d with issues). Report %s.',
            (int) $report['page_count'],
            (int) $report['issue_page_count'],
            $delivery,
        );

        if ($this->wantsAdminJson($request)) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'redirect' => null,
            ]);
        }

        Session::flash('status', $message);

        return back();
    }
}
