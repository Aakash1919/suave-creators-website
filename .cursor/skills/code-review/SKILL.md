---
name: code-review
description: >-
  Review changes since a fixed point (commit, branch, tag, or merge-base) on two
  axes: Standards (repo coding standards) and Spec (originating issue/plan).
  Use when reviewing a branch, PR, WIP diff, or "review since X".
---

# Code Review

Two-axis review of the diff between `HEAD` and a fixed point the user supplies:

- **Standards**: does the code conform to this repo's documented coding standards?
- **Spec**: does the code faithfully implement the originating issue / plan / PR description?

Both axes run as **parallel sub-agents** so they do not pollute each other's context. Aggregate findings under separate headings.

Use GitHub (`gh`) and in-repo plans for issue and review context.

## Process

### 1. Pin the fixed point

Whatever the user said is the fixed point (commit SHA, branch, tag, `main`, `HEAD~5`, etc.). If they did not specify one, ask for it.

Capture once:

- Diff: `git diff <fixed-point>...HEAD` (three-dot = merge-base)
- Commits: `git log <fixed-point>..HEAD --oneline`

Confirm the fixed point resolves (`git rev-parse <fixed-point>`) and the diff is non-empty.

### 2. Identify the spec source

Look for the originating spec, in this order:

1. Issue references in commit messages (`#123`, `Closes #45`) — fetch with `gh issue view <n>` when available.
2. A path the user passed as an argument.
3. A plan under `.cursor/plans/` matching the branch or feature.
4. A file under `docs/` matching the branch or feature.
5. Open PR body via `gh pr view` when the branch has a PR.

If nothing is found, ask where the spec is. If they say there is none, skip the Spec sub-agent and report "no spec available".

### 3. Identify the standards sources

**Hubs own shared law** (read these first):

| Source | Owns |
|---|---|
| [`AGENTS.md`](../../../AGENTS.md) | Always — swarm entry + quality gates |
| `system-coding-standards` | Short Suave constitution |
| `laravel-best-practices` + mapped `rule/` | Deep Laravel + Suave overlay (`rule/suave.md`) |

**Layer recipes (`create-*`)** — use only for **placement, template, and return contracts** when the diff scaffolds that layer.

| Source | When |
|---|---|
| `create-service` / `create-form-request` / `create-migration` | Matching layer in the diff |
| `suave-admin` | Admin / RBAC / DataTables / admin requests |
| `suave-frontend` | Marketing Blade / assets / CSS |
| `frontend-audit` | When marketing pages/assets/routes changed — require audit pass notes |

Also paste the full smell baseline from [`reference/smells.md`](reference/smells.md) into the Standards prompt.

Bindings:

- **The repo overrides.** A documented Suave standard always wins over a smell.
- **Hubs over recipes.** Shared rules come from coding-standards + LBP; `create-*` only for placement/return.
- **Judgement call.** Baseline smells are heuristics, never hard violations.
- **Skip tooling.** Do not re-report what Pint already enforces.

### 4. Spawn both sub-agents in parallel

**Standards** prompt must include:

- Diff command + commit list
- List of standards-source paths (and which apply)
- Full text of [`reference/smells.md`](reference/smells.md)
- Brief: "Report, per file/hunk where relevant, (a) every place the diff violates a documented standard: cite the skill/file + the rule; and (b) any baseline smell: name it and quote the hunk. Documented breaches can be hard; smells are always judgement calls. Repo standards override the baseline. Skip tooling. Under 400 words."

**Spec** prompt must include:

- Diff command + commit list
- Path or fetched contents of the spec
- Brief: "Report: (a) requirements the spec asked for that are missing or partial; (b) behaviour in the diff that was not asked for (scope creep); (c) requirements that look implemented but where the implementation looks wrong. Quote the spec line for each finding. Under 400 words."

If the spec is missing, skip Spec and note that in the final report.

### 5. Aggregate

Present under `## Standards` and `## Spec`, verbatim or lightly cleaned. Do **not** merge or rerank across axes.

End with one line: total findings per axis, and the worst issue **within each axis** (if any).

## Why two axes

- Follows every standard but implements the wrong thing → Standards pass, Spec fail.
- Does exactly what the issue asked but breaks conventions → Spec pass, Standards fail.
