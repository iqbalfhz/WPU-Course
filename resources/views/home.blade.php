<x-layout :title="$title">

    <main class="relative isolate bg-white dark:bg-zinc-950">
        <!-- HERO -->
        <section class="px-4 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-7xl pt-20 pb-16 lg:pt-28 lg:pb-24">
                <div class="grid items-center gap-10 lg:grid-cols-12">
                    <div class="lg:col-span-7">
                        <h1
                            class="text-4xl font-extrabold tracking-tight text-gray-900 dark:text-white sm:text-5xl lg:text-6xl">
                            Iqbal Fahrozi
                        </h1>
                        <p class="mt-3 text-xl font-medium text-gray-700 dark:text-gray-200">Full‑Stack Web Developer</p>
                        <p class="mt-5 text-gray-600 dark:text-gray-400 max-w-2xl">
                            I design and build fast, accessible products with Laravel, Tailwind, and modern tooling.
                            Explore a curated selection of my work below.
                        </p>
                        <div class="mt-8 flex flex-col sm:flex-row gap-3">
                            <a href="#projects"
                                class="inline-flex items-center justify-center rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white px-5 py-3 text-sm font-semibold shadow">View
                                Projects</a>
                            <a href="/contact"
                                class="inline-flex items-center justify-center rounded-xl ring-1 ring-gray-300 dark:ring-white/10 px-5 py-3 text-sm font-semibold text-gray-900 dark:text-white hover:bg-gray-50 dark:hover:bg-white/5">Hire
                                Me</a>
                        </div>
                    </div>
                    <div class="lg:col-span-5">
                        <div class="relative mx-auto max-w-sm">
                            <div
                                class="absolute -inset-4 rounded-3xl bg-gradient-to-tr from-indigo-500/20 to-violet-500/20 blur-2xl">
                            </div>
                            <img src="{{ asset('images/profile-hero.jpg') }}" alt="Iqbal Fahrozi"
                                class="relative rounded-3xl shadow-2xl ring-1 ring-gray-200 dark:ring-white/10" />
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- FEATURED PROJECTS -->
        <section id="projects" class="px-4 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-7xl py-8">
                <div class="flex items-end justify-between gap-4">
                    <h2 class="text-2xl sm:text-3xl font-bold tracking-tight text-gray-900 dark:text-white">Featured
                        Projects</h2>
                    <a href="/posts"
                        class="text-sm font-medium text-indigo-600 dark:text-indigo-400 hover:underline">Read case
                        studies</a>
                </div>

                <div class="mt-8 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($featured ?? [] as $p)
                        <article
                            class="group rounded-2xl bg-white dark:bg-zinc-900 border border-gray-200 dark:border-white/10 overflow-hidden">
                            <div class="relative">
                                <img src="{{ $p->cover ?? asset('images/placeholder-project.jpg') }}"
                                    alt="{{ $p->title }}"
                                    class="h-48 w-full object-cover group-hover:scale-[1.02] transition" />
                                <div
                                    class="absolute inset-0 ring-1 ring-inset ring-black/5 dark:ring-white/10 rounded-t-2xl">
                                </div>
                            </div>
                            <div class="p-5">
                                <div class="flex items-center gap-2 text-xs text-gray-500 dark:text-gray-400">
                                    <span
                                        class="rounded-full bg-indigo-50 text-indigo-700 dark:bg-indigo-500/10 dark:text-indigo-400 px-2 py-0.5">{{ strtoupper($p->type ?? 'WEB') }}</span>
                                    <span>{{ $p->year ?? date('Y') }}</span>
                                </div>
                                <h3 class="mt-2 text-lg font-semibold text-gray-900 dark:text-white">
                                    {{ $p->title ?? 'Project Title' }}</h3>
                                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400 line-clamp-2">
                                    {{ $p->summary ?? 'Short project description goes here.' }}</p>
                                <div class="mt-3 flex items-center gap-2">
                                    @if (!empty($p->live_url))
                                        <a href="{{ $p->live_url }}" target="_blank"
                                            class="inline-flex items-center rounded-lg bg-gray-900 text-white dark:bg-white dark:text-gray-900 px-3 py-1.5 text-xs font-medium hover:opacity-90">Live</a>
                                    @endif
                                    @if (!empty($p->repo_url))
                                        <a href="{{ $p->repo_url }}" target="_blank"
                                            class="inline-flex items-center rounded-lg ring-1 ring-gray-300 dark:ring-white/10 px-3 py-1.5 text-xs font-medium text-gray-700 dark:text-white hover:bg-gray-50 dark:hover:bg-white/5">Code</a>
                                    @endif
                                </div>
                            </div>
                        </article>
                    @endforeach

                    @if (empty($featured))
                        @for ($i = 1; $i <= 3; $i++)
                            <article
                                class="group rounded-2xl bg-white dark:bg-zinc-900 border border-gray-200 dark:border-white/10 overflow-hidden">
                                <img src="{{ asset('images/placeholder-project.jpg') }}"
                                    alt="Sample {{ $i }}" class="h-48 w-full object-cover" />
                                <div class="p-5">
                                    <div class="flex items-center gap-2 text-xs text-gray-500 dark:text-gray-400">
                                        <span
                                            class="rounded-full bg-indigo-50 text-indigo-700 dark:bg-indigo-500/10 dark:text-indigo-400 px-2 py-0.5">WEB</span>
                                        <span>{{ date('Y') }}</span>
                                    </div>
                                    <h3 class="mt-2 text-lg font-semibold text-gray-900 dark:text-white">Portfolio
                                        Sample {{ $i }}</h3>
                                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Showcase your best work
                                        with clean cards and quick actions.</p>
                                </div>
                            </article>
                        @endfor
                    @endif
                </div>

                @if (($featured ?? null) && method_exists($featured, 'links'))
                    <div class="mt-8">
                        {{ $featured->links() }}
                    </div>
                @endif
            </div>
        </section>

        <!-- QUICK FACTS + SERVICES PREVIEW -->
        <section class="px-4 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-7xl py-16">
                <div class="grid gap-8 lg:grid-cols-12">
                    <div class="lg:col-span-5">
                        <h2 class="text-2xl sm:text-3xl font-bold tracking-tight text-gray-900 dark:text-white">Quick
                            facts</h2>
                        <dl class="mt-6 grid grid-cols-2 gap-4">
                            <div
                                class="rounded-2xl bg-gray-50 dark:bg-white/5 p-5 ring-1 ring-gray-200 dark:ring-white/10">
                                <dt class="text-xs text-gray-500">Experience</dt>
                                <dd class="mt-1 text-2xl font-bold text-gray-900 dark:text-white">5+ yrs</dd>
                            </div>
                            <div
                                class="rounded-2xl bg-gray-50 dark:bg-white/5 p-5 ring-1 ring-gray-200 dark:ring-white/10">
                                <dt class="text-xs text-gray-500">Projects</dt>
                                <dd class="mt-1 text-2xl font-bold text-gray-900 dark:text-white">40+</dd>
                            </div>
                        </dl>
                    </div>
                    <div class="lg:col-span-7">
                        <h2 class="text-2xl sm:text-3xl font-bold tracking-tight text-gray-900 dark:text-white">Services
                        </h2>
                        <div class="mt-6 grid gap-4 sm:grid-cols-2">
                            @foreach ($services ?? [['Web Apps', 'Laravel + MySQL + Tailwind.'], ['UI Engineering', 'Design‑system components & a11y.']] as $s)
                                <div class="rounded-2xl border border-gray-200 dark:border-white/10 p-5">
                                    <h3 class="font-semibold text-gray-900 dark:text-white">{{ $s[0] }}</h3>
                                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{ $s[1] }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA -->
        <section class="px-4 sm:px-6 lg:px-8 pb-20">
            <div class="mx-auto max-w-7xl">
                <div
                    class="rounded-3xl bg-gradient-to-r from-indigo-600 to-violet-600 p-8 sm:p-12 text-white ring-1 ring-white/10">
                    <div class="grid gap-6 lg:grid-cols-2 items-center">
                        <div>
                            <h3 class="text-2xl sm:text-3xl font-bold">Have a project in mind?</h3>
                            <p class="mt-2 text-white/80">I’d love to help you ship it fast.</p>
                        </div>
                        <div class="text-right">
                            <a href="/contact"
                                class="inline-flex justify-center rounded-xl bg-white text-indigo-700 px-5 py-3 text-sm font-semibold shadow hover:bg-white/90">Get
                                in touch</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

</x-layout>
