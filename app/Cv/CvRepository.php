<?php

namespace App\Cv;

use InvalidArgumentException;
use Symfony\Component\Yaml\Yaml;

/**
 * Reads the CV content for a locale from content/cv/<locale>.yml.
 */
final class CvRepository
{
    public function __construct(private readonly string $directory) {}

    /**
     * @return array<string, mixed>
     *
     * @throws InvalidArgumentException when no content exists for the locale
     */
    public function for(string $locale): array
    {
        if (! in_array($locale, $this->locales(), true)) {
            throw new InvalidArgumentException("No CV content for locale [{$locale}].");
        }

        return Yaml::parseFile($this->path($locale));
    }

    /**
     * Locales that have a content file, e.g. ['en'].
     *
     * @return list<string>
     */
    public function locales(): array
    {
        return array_map(
            fn (string $file) => pathinfo($file, PATHINFO_FILENAME),
            glob($this->directory.'/*.yml') ?: [],
        );
    }

    private function path(string $locale): string
    {
        return "{$this->directory}/{$locale}.yml";
    }
}
