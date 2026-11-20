@props(['cv', 'locale', 'locales'])
@php
    $url = $locales->url($locale);
    $ogImage = asset('images/og.png');
@endphp
<!DOCTYPE html>
<html lang="{{ $locale }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $cv['meta']['title'] }}</title>
    <meta name="description" content="{{ $cv['meta']['description'] }}">
    <link rel="canonical" href="{{ $url }}">
    @foreach ($locales->all() as $alternate)
        <link rel="alternate" hreflang="{{ $alternate }}" href="{{ $locales->url($alternate) }}">
    @endforeach
    <link rel="alternate" hreflang="x-default" href="{{ $locales->url($locales->default()) }}">

    <meta property="og:type" content="profile">
    <meta property="og:title" content="{{ $cv['meta']['title'] }}">
    <meta property="og:description" content="{{ $cv['meta']['description'] }}">
    <meta property="og:url" content="{{ $url }}">
    <meta property="og:image" content="{{ $ogImage }}">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:image:alt" content="{{ $cv['person']['name'] }} — {{ $cv['person']['headline'] }}">
    <meta property="og:locale" content="{{ $locales->og($locale) }}">
    @foreach (array_diff($locales->all(), [$locale]) as $alternate)
        <meta property="og:locale:alternate" content="{{ $locales->og($alternate) }}">
    @endforeach
    <meta name="twitter:card" content="summary_large_image">

    <script type="application/ld+json">{!! json_encode(\App\Cv\PersonSchema::from($cv, $url), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG) !!}</script>

    <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">
    {{-- Apply the theme before first paint: saved choice, otherwise the system preference. --}}
    <script>
        (() => {
            const saved = localStorage.getItem('theme');
            const dark = saved ? saved === 'dark' : matchMedia('(prefers-color-scheme: dark)').matches;
            document.documentElement.classList.toggle('dark', dark);
        })();
    </script>
    @fonts
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-zinc-100 font-sans text-zinc-700 antialiased dark:bg-zinc-950 dark:text-zinc-300">
    {{ $slot }}
</body>
</html>
