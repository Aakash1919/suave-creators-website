# Suave Creators — agent instructions

This project uses **Cursor Agent Skills**. Skills are not optional documentation — open and follow them before coding.

## Required skills

| Area | Read first |
|------|------------|
| Admin / RBAC / Form Requests / admin CRUD | [`.cursor/skills/suave-admin/SKILL.md`](.cursor/skills/suave-admin/SKILL.md) |
| Marketing frontend / design import / assets / CSS | [`.cursor/skills/suave-frontend/SKILL.md`](.cursor/skills/suave-frontend/SKILL.md) |

## How to use

1. Match the user task to a row above.
2. **Read** the skill file (and `reference.md` for frontend asset renames) before editing.
3. Follow stack rules in the skill (e.g. first-party RBAC, `*Service` + Form Requests for admin; categorized `assets/` + verify script for frontend).
4. Do **not** invent Filament, Spatie Permission, Breeze, or flat `public/images/` paths.

Project rules under `.cursor/rules/` reinforce the same gates when relevant files are in context.
