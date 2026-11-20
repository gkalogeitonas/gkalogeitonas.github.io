@props(['thesis'])
<div class="mt-3 border-l-2 border-amber-500/60 pl-4">
    <p class="font-mono text-xs text-amber-700 dark:text-amber-400">{{ __('cv.thesis') }}</p>
    <p class="mt-1 font-semibold text-zinc-900 dark:text-white">{{ $thesis['title'] }}</p>
    <a href="#{{ Str::slug($thesis['name']) }}" class="mt-1 inline-block font-mono text-sm text-amber-700 hover:underline dark:text-amber-400">{{ __('cv.thesis_project', ['name' => $thesis['name']]) }} ↑</a>
</div>
