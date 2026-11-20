<?php

return [
    /*
     | Locales the CV is published in, mapped to their URL path. The first one is
     | the default (x-default in hreflang). Each needs content/cv/<locale>.yml
     | and lang/<locale>/cv.php.
     */
    'locales' => [
        'en' => ['path' => '/', 'og' => 'en_US'],
        'el' => ['path' => '/el', 'og' => 'el_GR'],
    ],
];
