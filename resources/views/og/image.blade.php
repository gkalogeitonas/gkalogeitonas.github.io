{{-- Source of public/images/og.png (1200×630). Only routed locally; see README to regenerate. --}}
<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="utf-8">
    @fonts
    @vite(['resources/css/app.css'])
</head>
<body class="m-0">
    <div class="flex h-[630px] w-[1200px] items-center justify-between gap-16 bg-zinc-950 px-24 text-zinc-300">
        <div>
            <p class="font-mono text-2xl text-zinc-500"><span class="text-amber-400">$</span> whoami</p>
            <h1 class="mt-5 font-mono text-7xl leading-tight font-bold tracking-tight text-white">
                {{ $cv['person']['name'] }}<span class="text-amber-500">_</span>
            </h1>
            <p class="mt-6 text-3xl">{{ $cv['person']['headline'] }}</p>
            <p class="mt-10 flex flex-wrap gap-3 font-mono text-xl">
                @foreach (['PHP', 'Laravel', 'Vue', 'ESP32', 'LoRa'] as $tag)
                    <span class="rounded bg-zinc-800 px-3 py-1.5 text-zinc-200">{{ $tag }}</span>
                @endforeach
            </p>
            <p class="mt-10 font-mono text-xl text-amber-400">gkalogeitonas.github.io</p>
        </div>
        <img src="{{ asset($cv['person']['avatar']) }}" alt="" class="size-72 shrink-0 rounded-full object-cover grayscale ring-8 ring-amber-500/30">
    </div>
</body>
</html>
