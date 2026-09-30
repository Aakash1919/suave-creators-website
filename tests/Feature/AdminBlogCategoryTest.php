<?php

namespace Tests\Feature;

use App\Models\BlogCategory;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Database\Seeders\RolesAndPermissionsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminBlogCategoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_and_update_a_blog_category(): void
    {
        $user = $this->adminUser();

        $create = $this->actingAs($user)->postJson(route('admin.blog-categories.store'), [
            'name' => 'Product Design',
            'slug' => '',
            'sort_order' => 4,
        ]);

        $create->assertOk();
        $create->assertJsonPath('success', true);

        $category = BlogCategory::query()->where('name', 'Product Design')->first();
        $this->assertNotNull($category);
        $this->assertSame('product-design', $category->slug);
        $this->assertSame(4, $category->sort_order);

        $update = $this->actingAs($user)->putJson(route('admin.blog-categories.update', $category), [
            'name' => 'Design',
            'slug' => 'design',
            'sort_order' => 2,
        ]);

        $update->assertOk();
        $category->refresh();
        $this->assertSame('Design', $category->name);
        $this->assertSame('design', $category->slug);
        $this->assertSame(2, $category->sort_order);
    }

    public function test_duplicate_category_name_is_rejected(): void
    {
        $user = $this->adminUser();
        BlogCategory::query()->create([
            'name' => 'Insights',
            'slug' => 'insights',
            'sort_order' => 1,
        ]);

        $response = $this->actingAs($user)->post(route('admin.blog-categories.store'), [
            'name' => 'Insights',
            'slug' => 'fresh-insights',
            'sort_order' => 2,
        ]);

        $response->assertSessionHasErrors('name');
        $this->assertSame(1, BlogCategory::query()->count());
    }

    public function test_editor_cannot_open_blog_categories(): void
    {
        (new RolesAndPermissionsSeeder)->run();

        $user = User::factory()->createOne();
        $user->assignRole('editor');

        $this->actingAs($user)
            ->get(route('admin.blog-categories.index'))
            ->assertForbidden();
    }

    public function test_admin_category_index_lists_existing_categories(): void
    {
        $user = $this->adminUser();

        BlogCategory::query()->create([
            'name' => 'Engineering',
            'slug' => 'engineering',
            'sort_order' => 1,
        ]);

        $response = $this->actingAs($user)->get(route('admin.blog-categories.index'));

        $response->assertOk();
        $response->assertSee('New category', false);
        $response->assertSee(route('admin.blog-categories.store'), false);

        $table = $this->actingAs($user)->getJson(route('admin.blog-categories.index', [
            'draw' => 1,
            'start' => 0,
            'length' => 10,
            'search' => ['value' => 'Engineering', 'regex' => false],
            'order' => [['column' => 2, 'dir' => 'asc']],
            'columns' => [
                ['data' => 'name', 'name' => 'blog_categories.name', 'searchable' => 'true', 'orderable' => 'true', 'search' => ['value' => '', 'regex' => 'false']],
                ['data' => 'slug', 'name' => 'blog_categories.slug', 'searchable' => 'true', 'orderable' => 'true', 'search' => ['value' => '', 'regex' => 'false']],
                ['data' => 'sort_order', 'name' => 'blog_categories.sort_order', 'searchable' => 'true', 'orderable' => 'true', 'search' => ['value' => '', 'regex' => 'false']],
                ['data' => 'blogs_count', 'name' => 'blogs_count', 'searchable' => 'false', 'orderable' => 'true', 'search' => ['value' => '', 'regex' => 'false']],
                ['data' => 'actions', 'name' => 'actions', 'searchable' => 'false', 'orderable' => 'false', 'search' => ['value' => '', 'regex' => 'false']],
            ],
        ]));

        $table->assertOk();
        $table->assertJsonPath('recordsFiltered', 1);
        $this->assertStringContainsString('Engineering', (string) $table->json('data.0.name'));
    }

    public function test_migration_grants_blog_categories_permissions_to_the_admin_role(): void
    {
        (new RolesAndPermissionsSeeder)->run();

        $names = [
            'blog-categories.view',
            'blog-categories.create',
            'blog-categories.update',
        ];

        Permission::query()->whereIn('name', $names)->delete();

        $migration = require database_path('migrations/2026_09_30_104619_add_blog_categories_permissions.php');
        $migration->up();

        $admin = Role::query()->where('name', 'admin')->firstOrFail();
        $editor = Role::query()->where('name', 'editor')->firstOrFail();

        foreach ($names as $name) {
            $this->assertTrue($admin->permissions()->where('name', $name)->exists());
            $this->assertFalse($editor->permissions()->where('name', $name)->exists());
        }
    }

    public function test_user_without_blog_create_permission_cannot_store_a_category(): void
    {
        (new RolesAndPermissionsSeeder)->run();

        $user = User::factory()->createOne();

        $response = $this->actingAs($user)->post(route('admin.blog-categories.store'), [
            'name' => 'Blocked',
            'slug' => 'blocked',
        ]);

        $response->assertForbidden();
        $this->assertDatabaseMissing('blog_categories', ['slug' => 'blocked']);
    }

    protected function adminUser(): User
    {
        (new RolesAndPermissionsSeeder)->run();

        $user = User::factory()->createOne();
        $user->assignRole('admin');

        return $user;
    }
}
