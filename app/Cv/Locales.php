<?php

namespace App\Cv;

/**
 * The locales the CV is published in (config/cv.php) and their public URLs.
 *
 * URLs end with a slash because the static export serves each locale as a
 * directory index (/el/index.html), which GitHub Pages exposes as /el/.
 */
final class Locales
{
    /**
     * @param  array<string, array{path: string, og: string}>  $locales
     */
    public function __construct(
        private readonly array $locales,
        private readonly string $baseUrl,
    ) {}

    /** @return list<string> */
    public function all(): array
    {
        return array_keys($this->locales);
    }

    public function default(): string
    {
        return $this->all()[0];
    }

    public function url(string $locale): string
    {
        return rtrim($this->baseUrl, '/').rtrim($this->locales[$locale]['path'], '/').'/';
    }

    /** Open Graph locale, e.g. en_US. */
    public function og(string $locale): string
    {
        return $this->locales[$locale]['og'];
    }
}
