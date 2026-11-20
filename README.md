# gkalogeitonas.github.io

Personal CV site of Georgios Kalogeitonas — a Laravel app that is exported to static HTML and served by GitHub Pages.

## Content

- `content/cv/<locale>.yml` — all CV content (one file per language, same structure).
- `lang/<locale>/cv.php` — section headings and UI strings.
- `public/images/` — profile photo.

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

## Stack

Laravel 13 · Blade components · Tailwind CSS v4 · Vite (fonts self-hosted at build time) · Pest.
