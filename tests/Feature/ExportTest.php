<?php

beforeEach(fn () => $this->withoutVite());

it('exports every published page', function () {
    $paths = config('export.paths');

    foreach (config('cv.locales') as $options) {
        expect($paths)->toContain($options['path']);
    }

    expect($paths)->toContain('/sitemap.xml')
        ->and(config('export.crawl'))->toBeFalse();
});

it('links each language to its own PDF', function (string $path, string $pdf) {
    $this->get($path)->assertSee('href="'.asset($pdf).'" download', false);
})->with([
    'english' => ['/', 'cv-en.pdf'],
    'greek' => ['/el', 'cv-el.pdf'],
]);

it('spells out contact details for print', function () {
    $this->get('/')
        ->assertSee('<span data-email-text></span>', false)
        ->assertSee('>github.com/gkalogeitonas</a>', false)
        ->assertSee('>www.linkedin.com/in/georgios-kalogeitonas</a>', false);
});
