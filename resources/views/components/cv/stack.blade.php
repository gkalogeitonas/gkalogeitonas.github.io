@props(['groups'])
<section>
    <x-cv.heading id="stack">{{ __('cv.sections.stack') }}</x-cv.heading>
    @foreach ($groups as $group)
        <div class="mb-4">
            <h3 class="font-mono text-xs uppercase text-zinc-500">{{ $group['group'] }}</h3>
            <div class="mt-2 flex flex-wrap gap-2">
                @foreach ($group['items'] as $item)
                    <x-cv.tag>{{ $item }}</x-cv.tag>
                @endforeach
            </div>
        </div>
    @endforeach
</section>
