<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\ChatLead;
use App\Models\ContactRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
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
}
