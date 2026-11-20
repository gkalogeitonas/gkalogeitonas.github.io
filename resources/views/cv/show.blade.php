<x-layouts.app :title="$cv['meta']['title']" :description="$cv['meta']['description']">
    <header class="border-b border-zinc-300 dark:border-zinc-800">
        <div class="mx-auto flex max-w-5xl items-center justify-between px-6 py-3 font-mono text-xs text-zinc-500">
            <span>~/gkalogeitonas</span>
            <x-cv.theme-toggle />
        </div>
    </header>

    <main class="mx-auto max-w-5xl px-6 pb-24">
        <x-cv.hero :person="$cv['person']" :profile="$cv['profile']" />
        <x-cv.experience :items="$cv['experience']" />
        <x-cv.education :items="$cv['education']" />

        <div class="grid gap-10 py-10 md:grid-cols-2">
            <x-cv.stack :groups="$cv['skills']" />
            <div class="space-y-10">
                <x-cv.beyond :beyond="$cv['beyond']" />
                <x-cv.languages :items="$cv['languages']" />
            </div>
        </div>

        <x-cv.certifications :items="$cv['certifications']" />
    </main>
</x-layouts.app>
