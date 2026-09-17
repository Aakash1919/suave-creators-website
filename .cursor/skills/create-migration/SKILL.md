---
name: create-migration
description: >-
  Use when writing Laravel migrations for Suave. Never edit a migration that
  already ran on live; guard with Schema::hasTable / hasColumn.
---

# Create Migration

## File placement

`database/migrations/` (project root migrations — no tenant module folders).

## Conventions

- **Never edit a migration that already ran on live.** Add a new file instead.
- Columns `snake_case`. Tables **plural**. Real FKs + indexes where needed.
- Guard everything: `Schema::hasTable` / `hasColumn` on create and alter so re-runs do not fail.
- Changing nullability / type: confirm the column exists and only `change()` when still needed.

## Template

```php
public function up(): void
{
    if (! Schema::hasTable('widgets')) {
        Schema::create('widgets', function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });
    }

    if (Schema::hasTable('widgets') && ! Schema::hasColumn('widgets', 'slug')) {
        Schema::table('widgets', function (Blueprint $table): void {
            $table->string('slug')->nullable()->after('name');
        });
    }
}
```

## Anti-patterns

- Editing a shipped migration on live
- Unguarded `Schema::table` adds
- Mixing unguarded ADD COLUMN with a non-idempotent backfill

Follow existing `blogs` thumb migrations and `2026_08_21_010000_add_draft_fields_to_contact_requests_table.php`. Deep rules: `laravel-best-practices` → `rule/migrations.md` + `rule/suave.md`.
