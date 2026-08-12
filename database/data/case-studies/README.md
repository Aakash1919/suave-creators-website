# Case study seed package

Offline source used by `Database\Seeders\CaseStudySeeder` (via `php artisan db:seed`).

| Path | Purpose |
|------|---------|
| `cases.php` | All case study fields (hero, metrics, overview, two story sections) |

Hero images stay in `public/assets/case-studies/` and are referenced as `assets/case-studies/...` on seeded rows. New uploads from admin go to `storage/app/public/case-studies/`.

```bash
php artisan db:seed
# or
php artisan db:seed --class=CaseStudySeeder
```

Case studies are **manual only** — there is no AI draft generation.
