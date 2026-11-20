<?php

use App\Cv\CvRepository;

beforeEach(fn () => $this->withoutVite());

it('renders the CV home page', function () {
    $this->get('/')
        ->assertOk()
        ->assertSee('<html lang="en">', false)
        ->assertSee('Georgios Kalogeitonas')
        ->assertSee('Full Stack Developer — e-commerce, ERP integrations &amp; IoT.', false);
});

it('renders every section of the content file', function () {
    $cv = app(CvRepository::class)->for('en');

    $response = $this->get('/');

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
});

it('shows the MSc thesis with its public repositories', function () {
    $this->get('/')
        ->assertSee('Design and Implementation of a Smart Agriculture Platform with IoT Node Integration')
        ->assertSee('grade 8.8 / 10')
        ->assertSee('https://github.com/gkalogeitonas/agronos', false)
        ->assertSee('https://github.com/gkalogeitonas/Agronos-iot-device', false);
});

it('does not expose contact details to scrapers', function () {
    $html = $this->get('/')->getContent();

    expect($html)
        ->not->toContain('gkalog2@gmail.com')
        ->not->toMatch('/\b69[0-9]{8}\b/') // no Greek mobile number
        ->toContain('data-email="'.strrev('gkalog2@gmail.com').'"');
});

it('sets title and meta description from the content file', function () {
    $this->get('/')
        ->assertSee('<title>Georgios Kalogeitonas — Full Stack Developer</title>', false)
        ->assertSee('<meta name="description" content="Full-stack developer (PHP, Laravel, Vue)', false);
});
