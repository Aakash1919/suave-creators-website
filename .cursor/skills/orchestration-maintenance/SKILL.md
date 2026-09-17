---
name: orchestration-maintenance
description: >-
  Use after creating or changing admin/frontend behavior, routes, permissions,
  assets, or conventions — update the owning skill, registry, and layer recipes
  if needed.
---

# Maintenance

After a meaningful change (controller, service, route, Form Request, migration, Blade section, asset convention):

1. Identify owning domain skill from `git diff`:
   - Admin / RBAC / DataTables / admin requests → `suave-admin`
   - Marketing Blade / `public/assets` / frontend Support → `suave-frontend`
2. Update that skill (and `suave-frontend/reference.md` for asset renames). Preserve Known Gotchas / domain-specific tables.
3. If you added/renamed/moved a skill, update [`.cursor/SKILL-REGISTRY.md`](../../SKILL-REGISTRY.md).
4. If a **repeated** layer convention changed (flash ownership, migration guards, Form Request naming), update the matching `create-*` or `system-coding-standards` / `laravel-best-practices/rule/suave.md` — not every domain skill.
5. Run scoped quality gates: `vendor/bin/pint --dirty`; marketing → `frontend-audit` + `verify-frontend-conventions.ps1`; app/routes/business rules → scoped PHPUnit.

Do not spawn Filament/Spatie/Vue-Inertia subtrees. This app is Blade + first-party RBAC.

If no skill content changed, say so explicitly.
