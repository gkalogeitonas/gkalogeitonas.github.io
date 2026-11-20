# gkalogeitonas.github.io

Personal CV site of Georgios Kalogeitonas — a Laravel app that is exported to static HTML and served by GitHub Pages.

## Content

- `content/cv/<locale>.yml` — all CV content (one file per language, same structure).
- `lang/<locale>/cv.php` — section headings and UI strings.
- `public/images/` — profile photo and `og.png` (link preview image).
- `config/cv.php` — published languages and their URLs (`/` English, `/el/` Greek).

Each language needs `content/cv/<locale>.yml` and `lang/<locale>/cv.php`; tests fail if their structure drifts from English.

Edit the YAML, run the tests, push. No database.

## Local development (ddev)

```sh
ddev start
ddev composer install
ddev npm install
ddev npm run dev        # Vite with hot reload → https://gkalogeitonas-cv.ddev.site
ddev exec vendor/bin/pest
```

PHP version is set in `.ddev/config.yaml` (`php_version`).

## Link preview image

`public/images/og.png` (1200×630) is a screenshot of the local-only route `/_og-image`
(`resources/views/og/image.blade.php`). After changing it, open
https://gkalogeitonas-cv.ddev.site/_og-image in a 1200×630 viewport and save a screenshot over `og.png`.

## Stack

Laravel 13 · Blade components · Tailwind CSS v4 · Vite (fonts self-hosted at build time) · Pest.
