<?php

// Static export (spatie/laravel-export) to dist/, published to GitHub Pages.
// Run with production settings so local-only tooling (Boost, /_og-image) is off:
//   ddev composer export
return [
    // Pages are listed explicitly below. Crawling would also follow the cv-*.pdf
    // links, which only exist after scripts/pdf.mjs has run on the export.
    'crawl' => false,

    'use_streaming' => false,

    // Every page of the site. Keep in sync with config/cv.php locales (tested).
    'paths' => [
        '/',
        '/el',
        '/sitemap.xml',
    ],

    'include_files' => [
        'public' => '',
    ],

    // Matched against the full source path of each file in public/.
    'exclude_file_patterns' => [
        '/\.php$/',
        '#(^|/)public/\.htaccess$#',
        '#(^|/)public/hot$#',
        '#(^|/)public/fonts-manifest\.dev\.json$#',
        '#(^|/)public/storage(/|$)#',
    ],

    'clean_before_export' => true,

    // null = dist/ in the project root.
    'disk' => null,

    'before' => [],
    'after' => [],
];
