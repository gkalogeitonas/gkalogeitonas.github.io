<?php

namespace App\Http\Controllers;

use App\Cv\CvRepository;
use Illuminate\Contracts\View\View;

final class ShowCv
{
    public function __invoke(CvRepository $cvs): View
    {
        return view('cv.show', ['cv' => $cvs->for(app()->getLocale())]);
    }
}
