---
name: create-form-request
description: >-
  Use when adding or editing Form Request validation (store/update rules,
  authorize). Admin and Frontend namespaces.
---

# Create Form Request

## File placement

| Area | Path |
|---|---|
| Admin | `app/Http/Requests/Admin/{Resource}StoreRequest.php` / `{Resource}UpdateRequest.php` |
| Public marketing | `app/Http/Requests/Frontend/...` |

**Naming (required):** `{Resource}{Action}Request` — e.g. `BlogStoreRequest`, never `StoreBlogRequest`.

## Conventions

- `authorize()` + `rules()` (+ messages) only. No persistence or orchestration.
- `authorize()` checks the matching permission (or authenticated user for profile); route `permission:` middleware remains.
- Shared field rules live in `App\Http\Requests/Admin/Concerns/*`.
- Domain normalization after validation stays in the Service.

## Template

```php
public function authorize(): bool
{
    return $this->user()?->hasPermission('blogs.create') ?? false;
}

public function rules(): array
{
    return [
        'title' => ['required', 'string', 'max:255'],
    ];
}
```

## Anti-patterns

- Inline `$request->validate()` in controllers or services
- Business orchestration inside the Form Request
- Wrong name order (`StoreBlogRequest`)

Domain request catalog: `suave-admin`. Deep rules: `laravel-best-practices` → `rule/validation.md` + `rule/suave.md`.
