@props(['items'])
<section>
    <x-cv.heading id="languages">{{ __('cv.sections.languages') }}</x-cv.heading>
    <ul>
        @foreach ($items as $language)
            <li class="font-mono text-sm">{{ mb_strtolower($language['name']) }} <span class="text-zinc-500">// {{ mb_strtolower($language['level']) }}</span></li>
        @endforeach
    </ul>
</section>
