@props(['thesis'])
<article class="mt-4 rounded-xl border border-amber-500/40 bg-white p-6 print:break-inside-avoid print:p-4 dark:bg-zinc-900">
    <p class="font-mono text-xs text-amber-700 dark:text-amber-400">{{ __('cv.thesis') }}</p>
    <h4 class="mt-1 font-semibold text-zinc-900 dark:text-white">{{ $thesis['title'] }}</h4>
    <p class="mt-3 leading-relaxed">
        <span class="font-mono font-bold text-zinc-900 dark:text-white">{{ $thesis['name'] }}</span>: {{ $thesis['summary'] }}
    </p>
    <div class="mt-4 flex flex-wrap gap-2">
        @foreach ($thesis['stack'] as $item)
            <x-cv.tag>{{ $item }}</x-cv.tag>
        @endforeach
    </div>
    <div class="mt-5 flex flex-wrap gap-x-5 gap-y-2 font-mono text-sm">
        @foreach ($thesis['links'] as $link)
            <a href="{{ $link['url'] }}" target="_blank" rel="noopener" class="text-amber-700 hover:underline dark:text-amber-400">{{ $link['label'] }} ↗</a>
        @endforeach
    </div>
</article>
