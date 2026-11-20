<?php

beforeEach(fn () => $this->withoutVite());

it('declares canonical and hreflang URLs with trailing slashes', function (string $path, string $canonical) {
    $base = rtrim(config('app.url'), '/');

    $this->get($path)
        ->assertSee('<link rel="canonical" href="'.$base.$canonical.'">', false)
        ->assertSee('<link rel="alternate" hreflang="en" href="'.$base.'/">', false)
        ->assertSee('<link rel="alternate" hreflang="el" href="'.$base.'/el/">', false)
        ->assertSee('<link rel="alternate" hreflang="x-default" href="'.$base.'/">', false);
})->with([
    'english' => ['/', '/'],
    'greek' => ['/el', '/el/'],
]);

it('has Open Graph tags with an existing 1200×630 image', function () {
    $this->get('/el')
        ->assertSee('<meta property="og:type" content="profile">', false)
        ->assertSee('<meta property="og:image" content="'.asset('images/og.png').'">', false)
        ->assertSee('<meta property="og:locale" content="el_GR">', false)
        ->assertSee('<meta property="og:locale:alternate" content="en_US">', false);

    [$width, $height] = getimagesize(public_path('images/og.png'));

    expect([$width, $height])->toBe([1200, 630]);
});

it('describes the person with JSON-LD and no contact details', function () {
    $html = $this->get('/')->getContent();

    preg_match('#<script type="application/ld\+json">(.+?)</script>#s', $html, $match);
    $schema = json_decode($match[1], true, flags: JSON_THROW_ON_ERROR);

    expect($schema)
        ->toMatchArray([
            '@type' => 'Person',
            'name' => 'Georgios Kalogeitonas',
            'jobTitle' => 'Full Stack Developer',
            'url' => rtrim(config('app.url'), '/').'/',
        ])
        ->and($schema['sameAs'])->toContain('https://github.com/gkalogeitonas')
        ->and(collect($schema['alumniOf'])->pluck('name'))->toContain('Hellenic Open University')
        ->and($schema)->not->toHaveKeys(['email', 'telephone']);
});

it('publishes a sitemap with both languages', function () {
    $base = rtrim(config('app.url'), '/');

    $response = $this->get('/sitemap.xml')
        ->assertOk()
        ->assertHeader('Content-Type', 'application/xml');

    $xml = simplexml_load_string($response->getContent());

    expect($xml)->not->toBeFalse();

    $locations = [];
    foreach ($xml->url as $url) {
        $locations[] = (string) $url->loc;
    }

    expect($locations)->toBe([$base.'/', $base.'/el/']);
});
