<x-layout :title="$title">
    <main class="relative isolate bg-white dark:bg-zinc-950">
        <!-- INTRO -->
        <section class="px-4 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-7xl pt-20 pb-10 lg:pt-28 lg:pb-14">
                <h1 class="text-4xl font-extrabold tracking-tight text-gray-900 dark:text-white sm:text-5xl">About</h1>
                <p class="mt-4 max-w-3xl text-lg text-gray-600 dark:text-gray-400">I’m a developer who values clean
                    architecture, accessible UI, and measurable results. Here’s a deeper look at how I work and what
                    I’ve done.</p>
            </div>
        </section>

        <!-- BIO + PHOTO -->
        <section class="px-4 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-7xl grid gap-12 lg:grid-cols-12 items-start">
                <div class="lg:col-span-7 space-y-4 text-gray-700 dark:text-gray-300">
                    <p>I started building websites during college and soon moved into full‑stack development with
                        Laravel. I enjoy shaping ideas into polished products and collaborating closely with designers
                        and founders.</p>
                    <p>My work spans landing pages, dashboards, CMS features, and full SaaS builds. I emphasize
                        performance budgets, robust validation, sensible caching, and a11y from the start.</p>
                </div>
                <div class="lg:col-span-5">
                    <img src="{{ asset('images/profile-hero.jpg') }}" alt="Iqbal Fahrozi"
                        class="rounded-3xl shadow-2xl ring-1 ring-gray-200 dark:ring-white/10" />
                </div>
            </div>
        </section>

        <!-- SKILLS -->
        <section class="px-4 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-7xl py-16">
                <h2 class="text-2xl sm:text-3xl font-bold tracking-tight text-gray-900 dark:text-white">Skills</h2>
                <div class="mt-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($skills ?? [['Laravel', 92], ['Tailwind CSS', 90], ['Alpine.js', 82], ['MySQL', 80], ['REST API', 85], ['Docker', 70]] as [$name, $level])
                        <div class="rounded-2xl border border-gray-200 dark:border-white/10 p-5">
                            <div class="flex items-center justify-between">
                                <span class="font-medium text-gray-900 dark:text-white">{{ $name }}</span>
                                <span class="text-xs text-gray-500 dark:text-gray-400">{{ $level }}%</span>
                            </div>
                            <div class="mt-2 h-2 rounded-full bg-gray-100 dark:bg-white/5">
                                <div class="h-2 rounded-full bg-gradient-to-r from-indigo-600 to-violet-600"
                                    style="width: {{ $level }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- EXPERIENCE -->
        <section class="px-4 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-7xl py-4">
                <h2 class="text-2xl sm:text-3xl font-bold tracking-tight text-gray-900 dark:text-white">Experience</h2>
                <ol class="mt-6 space-y-6">
                    @foreach ($experience ?? [['Full‑Stack Developer', 'Acme Studio', '2023 — Present', 'Built SaaS features, migrated UI to Tailwind, introduced CI.'], ['Frontend Developer', 'Pixel Labs', '2021 — 2023', 'Shipped component library, improved Core Web Vitals.']] as [$role, $company, $period, $desc])
                        <li class="relative rounded-2xl border border-gray-200 dark:border-white/10 p-5">
                            <div class="flex items-start justify-between gap-4">
                                <div>
                                    <h3 class="font-semibold text-gray-900 dark:text-white">{{ $role }}</h3>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">{{ $company }}</p>
                                </div>
                                <span
                                    class="shrink-0 text-xs text-gray-500 dark:text-gray-400">{{ $period }}</span>
                            </div>
                            <p class="mt-2 text-sm text-gray-700 dark:text-gray-300">{{ $desc }}</p>
                        </li>
                    @endforeach
                </ol>
            </div>
        </section>

        <!-- VALUES + CONTACT CTA -->
        <section class="px-4 sm:px-6 lg:px-8 pb-20">
            <div class="mx-auto max-w-7xl grid gap-8 lg:grid-cols-12 items-center">
                <div class="lg:col-span-7">
                    <h2 class="text-2xl sm:text-3xl font-bold tracking-tight text-gray-900 dark:text-white">What I value
                    </h2>
                    <ul class="mt-4 grid gap-3 text-sm text-gray-700 dark:text-gray-300">
                        <li class="rounded-2xl border border-gray-200 dark:border-white/10 p-5"><strong>Clarity</strong>
                            — clean code, clear UX, and helpful docs.</li>
                        <li class="rounded-2xl border border-gray-200 dark:border-white/10 p-5">
                            <strong>Performance</strong> — speed budgets, profiling, and caching.
                        </li>
                        <li class="rounded-2xl border border-gray-200 dark:border-white/10 p-5">
                            <strong>Reliability</strong> — tests, CI, and thoughtful monitoring.
                        </li>
                    </ul>
                </div>
                <div class="lg:col-span-5">
                    <div
                        class="rounded-3xl bg-gradient-to-r from-indigo-600 to-violet-600 p-8 text-white ring-1 ring-white/10">
                        <h3 class="text-2xl font-bold">Let’s work together</h3>
                        <p class="mt-1 text-white/80">Tell me about your goals — I’ll reply soon.</p>
                        <a href="/contact"
                            class="mt-5 inline-flex justify-center rounded-xl bg-white text-indigo-700 px-5 py-3 text-sm font-semibold shadow hover:bg-white/90">Contact</a>
                    </div>
                </div>
            </div>
        </section>
    </main>
</x-layout>
