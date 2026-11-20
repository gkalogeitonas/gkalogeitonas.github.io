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
    foreach ($cv['projects'] as $project) {
        $response->assertSee($project['name'])->assertSee(e($project['summary']), false);
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

it('shows the MSc thesis and points to its project', function () {
    $this->get('/')
        ->assertSee('Design and Implementation of a Smart Agriculture Platform with IoT Node Integration')
        ->assertSee('href="#agronos"', false)
        ->assertSee('id="agronos"', false)
        ->assertSee('https://github.com/gkalogeitonas/agronos', false);

    $this->get('/el')
        ->assertSee('Σχεδιασμός και Υλοποίηση Πλατφόρμας Έξυπνης Γεωργίας με Ενσωμάτωση IoT Κόμβων');
});

it('links the public projects to their repositories', function (string $locale, string $path) {
    $this->get($path)
        ->assertSee(__('cv.sections.projects', locale: $locale))
        ->assertSee('href="https://github.com/gkalogeitonas/laraPMS"', false);
})->with('pages');

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

it('marks the short programme as a training certificate, not a degree', function () {
    $this->get('/')->assertSee('Postgraduate Training Certificate · 20 ECTS');
    $this->get('/el')->assertSee('Πιστοποιητικό Μεταπτυχιακής Επιμόρφωσης · 20 ECTS');
});

it('leaves out grades and encryption claims', function (string $locale, string $path) {
    $html = $this->get($path)->getContent();

    expect($html)
        ->not->toMatch('/\b8[.,]8\b/')
        ->not->toContain('AES')
        ->not->toContain('end-to-end');
})->with('pages');
