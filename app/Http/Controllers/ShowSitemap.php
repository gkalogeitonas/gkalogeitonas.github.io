<?php

namespace App\Http\Controllers;

use App\Cv\Locales;
use Illuminate\Http\Response;

final class ShowSitemap
{
    public function __invoke(Locales $locales): Response
    {
        return response()
            ->view('sitemap', ['locales' => $locales])
            ->header('Content-Type', 'application/xml');
    }
}
