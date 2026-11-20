@props(['id'])
<h2 id="{{ $id }}" class="mb-5 scroll-mt-8 font-mono text-sm text-amber-700 dark:text-amber-400">
    <span class="text-zinc-400" aria-hidden="true">##</span> {{ $slot }}
</h2>
