@props(['person', 'profile'])
<section class="grid items-center gap-10 py-16 md:grid-cols-[1fr_auto] md:py-20">
    <div>
        <p class="font-mono text-sm text-zinc-500"><span class="text-amber-600 dark:text-amber-400" aria-hidden="true">$</span> whoami</p>
        <h1 class="mt-3 font-mono text-4xl font-bold tracking-tight text-zinc-900 md:text-5xl dark:text-white">
            {{ $person['name'] }}<span class="animate-pulse text-amber-500 motion-reduce:animate-none" aria-hidden="true">_</span>
        </h1>
        <p class="mt-4 text-xl">{{ $person['headline'] }}</p>
        <div class="mt-4 max-w-2xl space-y-3 leading-relaxed text-zinc-600 dark:text-zinc-400">
            @foreach ($profile as $paragraph)
                <p>{{ $paragraph }}</p>
            @endforeach
        </div>
        <div class="mt-8 flex flex-wrap gap-3 font-mono text-sm">
            {{-- Address is reversed in the markup and assembled by resources/js/app.js. --}}
            <a href="#" data-email="{{ strrev($person['email']['user'].'@'.$person['email']['domain']) }}"
               class="rounded border border-amber-500 bg-amber-500 px-4 py-2 font-semibold text-zinc-950 hover:bg-amber-400">{{ __('cv.email_me') }}</a>
            @foreach ($person['links'] as $label => $url)
                <a href="{{ $url }}" target="_blank" rel="noopener me"
                   class="rounded border border-zinc-400 px-4 py-2 hover:border-amber-500 dark:border-zinc-700">{{ $label }}</a>
            @endforeach
        </div>
        <noscript><p class="mt-3 text-sm text-zinc-500">{{ __('cv.email_noscript') }}</p></noscript>
    </div>
    <img src="{{ asset($person['avatar']) }}" alt="{{ __('cv.photo_alt', ['name' => $person['name']]) }}" width="176" height="176"
         class="hidden size-44 rounded-full object-cover grayscale ring-4 ring-amber-500/30 md:block">
</section>
