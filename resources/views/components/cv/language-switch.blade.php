@props(['locale', 'locales'])
<nav aria-label="{{ __('cv.language') }}" class="flex gap-3">
    @foreach ($locales->all() as $option)
        @if ($option === $locale)
            <span aria-current="page" class="text-amber-700 dark:text-amber-400">{{ $option }}</span>
        @else
            <a href="{{ $locales->url($option) }}" hreflang="{{ $option }}" lang="{{ $option }}" class="hover:text-amber-600 dark:hover:text-amber-400">{{ $option }}</a>
        @endif
    @endforeach
</nav>
