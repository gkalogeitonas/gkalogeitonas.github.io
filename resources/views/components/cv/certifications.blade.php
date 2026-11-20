@props(['items'])
<section class="py-10 print:break-inside-avoid print:py-4">
    <x-cv.heading id="certifications">{{ __('cv.sections.certifications') }}</x-cv.heading>
    <div class="grid gap-3 sm:grid-cols-2 lg:grid-cols-3 print:grid-cols-3 print:gap-2">
        @foreach ($items as $cert)
            <a href="{{ $cert['url'] }}" target="_blank" rel="noopener"
               class="group rounded-lg border border-zinc-300 bg-white p-4 transition print:p-2 hover:-translate-y-0.5 hover:border-amber-500 motion-reduce:transform-none dark:border-zinc-800 dark:bg-zinc-900">
                <p class="font-mono text-xs text-zinc-500">{{ $cert['year'] }} · {{ $cert['issuer'] }}</p>
                <p class="mt-1 font-medium text-zinc-900 group-hover:text-amber-600 dark:text-white dark:group-hover:text-amber-400">{{ $cert['name'] }} ↗</p>
            </a>
        @endforeach
    </div>
</section>
