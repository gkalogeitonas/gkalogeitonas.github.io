<?php

namespace App\Http\Controllers;

use App\Cv\CvRepository;
use App\Cv\Locales;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\App;

final class ShowCv
{
    public function __invoke(CvRepository $cvs, Locales $locales, string $locale): View
    {
        App::setLocale($locale);

        return view('cv.show', [
            'cv' => $cvs->for($locale),
            'locale' => $locale,
            'locales' => $locales,
        ]);
    }
}
