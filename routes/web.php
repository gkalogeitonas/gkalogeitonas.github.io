<?php

use App\Cv\CvRepository;
use App\Http\Controllers\ShowCv;
use App\Http\Controllers\ShowSitemap;
use Illuminate\Support\Facades\Route;

foreach (config('cv.locales') as $locale => $options) {
    Route::get($options['path'], ShowCv::class)
        ->defaults('locale', $locale)
        ->name("cv.{$locale}");
}

Route::get('/sitemap.xml', ShowSitemap::class)->name('sitemap');

// Design source for public/images/og.png. Never part of the exported site.
if (app()->environment('local')) {
    Route::get('/_og-image', fn (CvRepository $cvs) => view('og.image', ['cv' => $cvs->for('en')]));
}
