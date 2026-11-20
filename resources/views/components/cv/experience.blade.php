@props(['items'])
<section class="py-10">
    <x-cv.heading id="experience">{{ __('cv.sections.experience') }}</x-cv.heading>
    <div class="divide-y divide-zinc-300 border-y border-zinc-300 dark:divide-zinc-800 dark:border-zinc-800">
        @foreach ($items as $job)
            <details class="group" @if ($loop->first) open @endif>
                <summary class="grid cursor-pointer list-none grid-cols-[1fr_auto] gap-4 py-4 md:grid-cols-[11rem_1fr_auto]">
                    <span class="hidden font-mono text-sm text-zinc-500 md:block">{{ $job['period'] }}</span>
                    <span>
                        <span class="font-semibold text-zinc-900 dark:text-white">{{ $job['role'] }}</span>
                        <span class="text-zinc-500">@ {{ $job['company'] }}</span>
                        <span class="block font-mono text-xs text-zinc-500 md:hidden">{{ $job['period'] }}</span>
                    </span>
                    <span class="font-mono text-zinc-400 transition group-open:rotate-90" aria-hidden="true">›</span>
                </summary>
                <ul class="mb-5 space-y-1.5 md:ml-[12rem]">
                    @foreach ($job['points'] as $point)
                        <li class="flex gap-2"><span class="font-mono text-amber-600 dark:text-amber-400" aria-hidden="true">▹</span>{{ $point }}</li>
                    @endforeach
                </ul>
            </details>
        @endforeach
    </div>
</section>
