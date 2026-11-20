<?php

namespace App\Cv;

/**
 * schema.org Person (JSON-LD) built from CV content, for search engines.
 * Contact details are deliberately left out.
 */
final class PersonSchema
{
    /**
     * @param  array<string, mixed>  $cv
     * @return array<string, mixed>
     */
    public static function from(array $cv, string $url): array
    {
        $person = $cv['person'];
        $currentJob = $cv['experience'][0];

        return [
            '@context' => 'https://schema.org',
            '@type' => 'Person',
            'name' => $person['name'],
            'url' => $url,
            'image' => asset($person['avatar']),
            'jobTitle' => $currentJob['role'],
            'worksFor' => ['@type' => 'Organization', 'name' => $currentJob['company']],
            'address' => ['@type' => 'PostalAddress', 'addressLocality' => $person['location']],
            'alumniOf' => collect($cv['education'])
                ->pluck('school')
                ->unique()
                ->map(fn (string $school) => ['@type' => 'EducationalOrganization', 'name' => $school])
                ->values()
                ->all(),
            'knowsAbout' => collect($cv['skills'])->pluck('items')->flatten()->values()->all(),
            'knowsLanguage' => collect($cv['languages'])->pluck('name')->all(),
            'sameAs' => array_values($person['links']),
        ];
    }
}
