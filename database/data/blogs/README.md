# Blog seed package

Offline source used by `Database\Seeders\BlogSeeder` (via `php artisan db:seed`).

| Path | Purpose |
|------|---------|
| `blogs.json` | All blog fields (content, FAQs, meta, category, dates) |
| `images/{slug}.{ext}` | Featured images renamed to the blog slug |
| `images/content/*` | Inline content images referenced from HTML as `images/content/...` |

```bash
php artisan db:seed
# or
php artisan db:seed --class=BlogSeeder
```

Do not scrape the live site — keep this package committed and seed from it.
