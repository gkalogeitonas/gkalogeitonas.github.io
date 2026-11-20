<?php

use App\Http\Controllers\ShowCv;
use Illuminate\Support\Facades\Route;

Route::get('/', ShowCv::class)->name('cv');
