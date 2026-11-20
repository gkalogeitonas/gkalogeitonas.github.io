<?php

use App\Cv\CvRepository;

/** Shape of a nested array: keys and list lengths, without the values. */
function shape(mixed $value): mixed
{
    if (! is_array($value)) {
        return gettype($value);
    }

    return array_map(shape(...), $value);
}

it('has the same content structure in every language as in English', function () {
    $cvs = app(CvRepository::class);
    $english = shape($cvs->for('en'));

    foreach (array_diff($cvs->locales(), ['en']) as $locale) {
        expect(shape($cvs->for($locale)))->toBe($english, "content/cv/{$locale}.yml differs in structure from en.yml");
    }
});

it('has the same UI strings in every language', function () {
    $english = array_keys(Arr::dot(require lang_path('en/cv.php')));

    foreach (config('cv.locales') as $locale => $options) {
        expect(array_keys(Arr::dot(require lang_path("{$locale}/cv.php"))))->toBe($english, "lang/{$locale}/cv.php");
    }
});

it('has content and UI strings for every configured locale', function () {
    foreach (array_keys(config('cv.locales')) as $locale) {
        expect(base_path("content/cv/{$locale}.yml"))->toBeFile()
            ->and(lang_path("{$locale}/cv.php"))->toBeFile();
    }
});
