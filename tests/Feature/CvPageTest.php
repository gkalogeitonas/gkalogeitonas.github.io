<?php

use App\Cv\CvRepository;

beforeEach(fn () => $this->withoutVite());

dataset('pages', [
    'english' => ['en', '/'],
    'greek' => ['el', '/el'],
]);

it('renders the CV in each language', function (string $locale, string $path) {
    $cv = app(CvRepository::class)->for($locale);

    $this->get($path)
        ->assertOk()
        ->assertSee('<html lang="'.$locale.'">', false)
        ->assertSee($cv['person']['name'])
        ->assertSee(e($cv['person']['headline']), false)
        ->assertSee(__('cv.sections.experience', locale: $locale));
})->with('pages');

it('renders every section of the content file', function (string $locale, string $path) {
    $cv = app(CvRepository::class)->for($locale);

    $response = $this->get($path);

    foreach ($cv['experience'] as $job) {
        $response->assertSee($job['role'])->assertSee($job['company']);
    }
    foreach ($cv['education'] as $entry) {
        $response->assertSee($entry['degree']);
    }
    foreach ($cv['certifications'] as $cert) {
        $response->assertSee($cert['url'], false);
    }
    foreach (collect($cv['skills'])->pluck('items')->flatten() as $skill) {
        $response->assertSee($skill);
    }
})->with('pages');

it('shows the MSc thesis with its public repositories', function () {
    $this->get('/')
        ->assertSee('Design and Implementation of a Smart Agriculture Platform with IoT Node Integration')
        ->assertSee('https://github.com/gkalogeitonas/agronos', false);

    $this->get('/el')
        ->assertSee('Σχεδιασμός και Υλοποίηση Πλατφόρμας Έξυπνης Γεωργίας με Ενσωμάτωση IoT Κόμβων');
});

it('does not expose contact details to scrapers', function (string $locale, string $path) {
    $html = $this->get($path)->getContent();

    expect($html)
        ->not->toContain('gkalog2@gmail.com')
        ->not->toMatch('/\b69[0-9]{8}\b/') // no Greek mobile number
        ->toContain('data-email="'.strrev('gkalog2@gmail.com').'"');
})->with('pages');

it('links to the other language and marks the current one', function () {
    $this->get('/')
        ->assertSee('<span aria-current="page" class="text-amber-700 dark:text-amber-400">en</span>', false)
        ->assertSee('href="'.url('/el').'/" hreflang="el"', false);

    $this->get('/el')
        ->assertSee('<span aria-current="page" class="text-amber-700 dark:text-amber-400">el</span>', false)
        ->assertSee('href="'.url('/').'/" hreflang="en"', false);
});

it('leaves out grades and encryption claims', function (string $locale, string $path) {
    $html = $this->get($path)->getContent();

    expect($html)
        ->not->toMatch('/\b8[.,]8\b/')
        ->not->toContain('AES')
        ->not->toContain('end-to-end');
})->with('pages');
