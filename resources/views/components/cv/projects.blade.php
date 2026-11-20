@props(['items'])
<section class="py-10 print:py-4">
    <x-cv.heading id="projects">{{ __('cv.sections.projects') }}</x-cv.heading>
    <div class="space-y-6 print:space-y-3">
        @foreach ($items as $project)
            <article id="{{ Str::slug($project['name']) }}" class="scroll-mt-8 grid gap-1 md:grid-cols-[11rem_1fr] print:break-inside-avoid print:grid-cols-[11rem_1fr] print:gap-4">
                <span class="font-mono text-sm text-zinc-500">{{ $project['period'] }}</span>
                <div>
                    <h3>
                        <span class="font-mono font-bold text-zinc-900 dark:text-white">{{ $project['name'] }}</span>
                        <span class="text-zinc-500">@ {{ $project['context'] }}</span>
                    </h3>
                    <p class="mt-1 leading-relaxed">{{ $project['summary'] }}</p>
                    <div class="mt-3 flex flex-wrap gap-2">
                        @foreach ($project['stack'] as $item)
                            <x-cv.tag>{{ $item }}</x-cv.tag>
                        @endforeach
                    </div>
                    @isset($project['links'])
                        <div class="mt-3 flex flex-wrap gap-x-5 gap-y-2 font-mono text-sm">
                            @foreach ($project['links'] as $link)
                                <a href="{{ $link['url'] }}" target="_blank" rel="noopener" class="text-amber-700 hover:underline dark:text-amber-400">{{ $link['label'] }} ↗</a>
                            @endforeach
                        </div>
                    @endisset
                </div>
            </article>
        @endforeach
    </div>
</section>
