<x-layouts.app :cv="$cv" :locale="$locale" :locales="$locales">
    <header class="border-b border-zinc-300 print:hidden dark:border-zinc-800">
        <div class="mx-auto flex max-w-5xl items-center justify-between px-6 py-3 font-mono text-xs text-zinc-500">
            <span>~/gkalogeitonas</span>
            <div class="flex items-center gap-5">
                <x-cv.language-switch :locale="$locale" :locales="$locales" />
                <a href="{{ asset('cv-'.$locale.'.pdf') }}" download class="hover:text-amber-600 dark:hover:text-amber-400">cv.pdf</a>
                <x-cv.theme-toggle />
            </div>
        </div>
    </header>

    <main class="mx-auto max-w-5xl px-6 pb-24 print:max-w-none print:px-0 print:pb-0">
        <x-cv.hero :person="$cv['person']" :profile="$cv['profile']" :site-url="$locales->url($locale)" />
        <x-cv.experience :items="$cv['experience']" />
        <x-cv.projects :items="$cv['projects']" />
        <x-cv.education :items="$cv['education']" />

        <div class="grid gap-10 py-10 md:grid-cols-2 print:grid-cols-2 print:py-4">
            <x-cv.stack :groups="$cv['skills']" />
            <div class="space-y-10">
                <x-cv.beyond :beyond="$cv['beyond']" />
                <x-cv.languages :items="$cv['languages']" />
            </div>
        </div>

        <x-cv.certifications :items="$cv['certifications']" />
    </main>
</x-layouts.app>
