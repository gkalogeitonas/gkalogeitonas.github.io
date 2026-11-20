@props(['items'])
<section class="py-10">
    <x-cv.heading id="education">{{ __('cv.sections.education') }}</x-cv.heading>
    <div class="space-y-6">
        @foreach ($items as $entry)
            <div class="grid gap-1 md:grid-cols-[11rem_1fr]">
                <span class="font-mono text-sm text-zinc-500">{{ $entry['period'] }}</span>
                <div>
                    <h3 class="font-semibold text-zinc-900 dark:text-white">
                        @isset($entry['url'])
                            <a href="{{ $entry['url'] }}" target="_blank" rel="noopener" class="hover:text-amber-600">{{ $entry['degree'] }}</a>
                        @else
                            {{ $entry['degree'] }}
                        @endisset
                    </h3>
                    <p class="text-zinc-500">
                        {{ $entry['school'] }}
                        @isset($entry['grade'])
                            · <span class="font-mono text-amber-700 dark:text-amber-400">{{ __('cv.grade') }} {{ $entry['grade'] }}</span>
                        @endisset
                    </p>
                    @isset($entry['thesis'])
                        <x-cv.thesis :thesis="$entry['thesis']" />
                    @endisset
                </div>
            </div>
        @endforeach
    </div>
</section>
