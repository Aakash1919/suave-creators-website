---
name: create-service
description: >-
  Use when adding or editing App\Services\* classes. Controllers delegate
  mutations here; services never return HTTP or flash messages.
---

# Create Service

## File placement

`app/Services/{Feature}Service.php` (flat under `App\Services`, not per-module folders).

## Conventions

- Services own mutations (create/update/delete, file storage, cache busts, domain transforms). Controllers stay thin.
- Constructor-inject collaborators. Return models, arrays, collections, or `void` — **never** HTTP, redirects, or `createFlashMessage()` / Toastr.
- New admin CRUD gets a **new** `{Feature}Service` in the **same** change as the controller + Form Requests.
- Do **not** call `$request->validate()` — receive a validated Form Request or trusted array (internal drafts).
- Match siblings: see `BlogService`, `CaseStudyService`, `TestimonialService`.

## Template

```php
public function create(BlogStoreRequest $request): Blog
{
    return DB::transaction(function () use ($request): Blog {
        // persist + domain transforms
    });
}
```

## Return / response

Return the persisted model (or void). The controller wraps success with `adminSuccess` / JSON / redirect.

## Anti-patterns

- HTTP responses or flash from a service
- Growing a god service with unrelated slices
- Inline validation in the service
- Fat controllers that skip a service for CRUD

Domain catalog of existing services: `suave-admin`. Deep architecture: `laravel-best-practices` → `rule/architecture.md` + `rule/suave.md`.
