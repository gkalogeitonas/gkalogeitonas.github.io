<?php

use App\Cv\CvRepository;

it('lists the locales that have content', function () {
    expect(app(CvRepository::class)->locales())->toEqualCanonicalizing(['en', 'el']);
});

it('rejects a locale without content', function () {
    app(CvRepository::class)->for('fr');
})->throws(InvalidArgumentException::class, 'No CV content for locale [fr].');

it('rejects path traversal in the locale', function () {
    app(CvRepository::class)->for('../../.env');
})->throws(InvalidArgumentException::class);

it('has the required structure in every locale file', function (string $locale) {
    $cv = app(CvRepository::class)->for($locale);

    expect($cv)->toHaveKeys(['meta', 'person', 'profile', 'experience', 'education', 'skills', 'beyond', 'languages', 'certifications'])
        ->and($cv['meta'])->toHaveKeys(['title', 'description'])
        ->and($cv['person'])->toHaveKeys(['name', 'headline', 'avatar', 'email.user', 'email.domain', 'links'])
        ->and(public_path($cv['person']['avatar']))->toBeFile();

    foreach ($cv['experience'] as $job) {
        expect($job)->toHaveKeys(['role', 'company', 'period', 'points']);
    }
    foreach ($cv['education'] as $entry) {
        expect($entry)->toHaveKeys(['degree', 'school', 'period']);
    }
    foreach ($cv['certifications'] as $cert) {
        expect($cert)->toHaveKeys(['name', 'issuer', 'year', 'url']);
    }
})->with(
    // Datasets are resolved before the application boots, so read the directory directly.
    fn () => array_map(fn (string $file) => pathinfo($file, PATHINFO_FILENAME), glob(__DIR__.'/../../content/cv/*.yml')),
);
