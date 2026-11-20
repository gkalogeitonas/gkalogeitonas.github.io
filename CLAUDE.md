# Project notes for agents

- Run everything through ddev: `ddev exec vendor/bin/pest`, `ddev artisan …`, `ddev npm run build`, `ddev composer …`. PHP lives in the container, not on the host.
- No database: sessions/cache use files. Don't add migrations or Eloquent models for CV content.
- CV content is YAML in `content/cv/<locale>.yml`, read via `App\Cv\CvRepository`. UI strings are in `lang/<locale>/cv.php`. Never hard-code CV text in Blade.
- Views: `resources/views/cv/show.blade.php` composes anonymous components in `resources/views/components/cv/`.
- The site is exported to static HTML for GitHub Pages: no server-side behaviour at request time (no forms, sessions, or query-string logic).
- Privacy: never render the phone number; the email is only emitted reversed in `data-email` and assembled by `resources/js/app.js`.
