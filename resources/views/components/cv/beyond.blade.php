@props(['beyond'])
<section>
    <x-cv.heading id="beyond-code">{{ __('cv.sections.beyond') }}</x-cv.heading>
    <p class="leading-relaxed">{{ $beyond['text'] }}</p>
    <div class="mt-4 flex flex-wrap gap-2">
        @foreach ($beyond['tags'] as $tag)
            <span class="rounded-full border border-amber-500/40 px-3 py-1 font-mono text-xs text-amber-700 dark:text-amber-300">#{{ $tag }}</span>
        @endforeach
    </div>
</section>
