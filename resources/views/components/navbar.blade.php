<nav x-data="navbar()" x-init="init()"
    :class="['sticky top-0 z-50 w-full transition-colors duration-300', scrolled ?
        'backdrop-blur supports-[backdrop-filter]:bg-gray-900/70 border-b border-white/10 shadow-[0_1px_0_0_rgba(255,255,255,0.06)]' :
        'bg-transparent'
    ]"
    class="print:hidden">
    <!-- Top bar -->
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 items-center justify-between">
            <!-- Left: Brand + Desktop Nav -->
            <div class="flex items-center gap-3">
                <a href="/" class="flex items-center gap-2 shrink-0 group">
                    <img class="h-10 w-10 rounded-xl ring-1 ring-white/10 group-hover:ring-white/20 transition"
                        src="{{ asset('images/logo.png') }}" alt="Logo" />
                    <span
                        class="hidden sm:block text-white/90 group-hover:text-white font-semibold tracking-tight"></span>
                </a>

                <!-- Desktop links -->
                <div class="hidden md:flex md:items-center md:gap-1 ml-4">
                    <x-landing-page-nav-link href="/" :current="request()->is('/')">Home</x-landing-page-nav-link>
                    <x-landing-page-nav-link href="/posts" :current="request()->is('posts')">Blog</x-landing-page-nav-link>
                    <x-landing-page-nav-link href="/about" :current="request()->is('about')">About</x-landing-page-nav-link>
                    <x-landing-page-nav-link href="/contact" :current="request()->is('contact')">Contact</x-landing-page-nav-link>
                    <x-landing-page-nav-link href="/ujian" :current="request()->is('ujian')">Ujian</x-landing-page-nav-link>
                </div>
            </div>



            <!-- Right: Actions / Profile -->
            <div class="hidden md:flex items-center gap-2">
                <!-- Theme toggle -->
                <button @click="toggleTheme"
                    class="p-2 rounded-xl hover:bg-white/10 text-white/80 focus:outline-none focus:ring-2 focus:ring-indigo-400"
                    aria-label="Toggle theme">
                    <svg x-show="theme==='dark'" class="h-5 w-5" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M21.752 15.002A9.718 9.718 0 0 1 12 21.75a9.75 9.75 0 0 1 0-19.5 9.75 9.75 0 0 1 9.752 12.752Z" />
                    </svg>
                    <svg x-show="theme==='light'" class="h-5 w-5" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M12 3v2m0 14v2m9-9h-2M5 12H3m14.95 6.95-1.414-1.414M7.464 7.464 6.05 6.05m11.486 0-1.414 1.414M7.464 16.536 6.05 17.95M12 8a4 4 0 1 0 0 8 4 4 0 0 0 0-8Z" />
                    </svg>
                </button>

                @auth
                    <!-- Dashboard CTA -->
                    {{-- <a href="/dashboard"
                        class="hidden lg:inline-flex items-center gap-2 rounded-xl bg-indigo-500/90 hover:bg-indigo-500 text-white px-3 py-2 text-sm font-medium shadow-sm">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M3 13h18M5 7h14M7 17h10" />
                        </svg>
                        Dashboard
                    </a> --}}

                    <!-- Profile dropdown -->
                    <div class="relative" x-data="{ open: false }" @keydown.escape.window="open=false">
                        <button @click="open=!open" :aria-expanded="open"
                            class="flex items-center gap-2 rounded-full bg-white/5 px-2 py-1 ring-1 ring-white/10 hover:ring-white/20 focus:outline-none focus:ring-2 focus:ring-indigo-400">
                            <img class="h-8 w-8 rounded-full object-cover"
                                src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : asset('images/default-avatar.png') }}"
                                alt="{{ Auth::user()->name }}" />
                            <span
                                class="hidden xl:block text-sm text-white/90 max-w-[10rem] truncate">{{ Auth::user()->name }}</span>
                            <svg class="h-4 w-4 text-white/70" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M5.23 7.21a.75.75 0 0 1 1.06.02L10 10.94l3.71-3.71a.75.75 0 1 1 1.06 1.06l-4.24 4.24a.75.75 0 0 1-1.06 0L5.25 8.27a.75.75 0 0 1-.02-1.06Z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                        <div x-cloak x-show="open" x-transition.opacity @click.away="open=false"
                            class="absolute right-0 mt-2 w-56 origin-top-right rounded-xl bg-white/95 backdrop-blur shadow-lg ring-1 ring-gray-200"
                            role="menu">
                            <div class="py-1">
                                <a href="/profile" class="block px-4 py-2 text-sm text-gray-800 hover:bg-gray-50"
                                    role="menuitem">Your Profile</a>
                                <a href="/dashboard" class="block px-4 py-2 text-sm text-gray-800 hover:bg-gray-50"
                                    role="menuitem">Dashboard</a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                        class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50"
                                        role="menuitem">Log Out</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endauth

                @guest
                    <a href="{{ route('login') }}"
                        class="inline-flex items-center rounded-xl px-3 py-2 text-sm font-medium text-white/90 hover:text-white hover:bg-white/10 ring-1 ring-white/10">Login</a>
                    {{-- <a href="{{ route('register') }}"
                        class="inline-flex items-center rounded-xl bg-indigo-500/90 hover:bg-indigo-500 text-white px-3 py-2 text-sm font-medium shadow-sm">Register</a> --}}
                @endguest
            </div>

            <!-- Mobile: Hamburger -->
            <div class="md:hidden">
                <button @click="mobileOpen=!mobileOpen" :aria-expanded="mobileOpen"
                    class="inline-flex items-center justify-center rounded-xl p-2 text-white/90 hover:bg-white/10 focus:outline-none focus:ring-2 focus:ring-indigo-400"
                    aria-controls="mobile-menu">
                    <span class="sr-only">Open main menu</span>
                    <svg x-show="!mobileOpen" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                    <svg x-show="mobileOpen" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile sheet -->
    <div x-cloak x-show="mobileOpen" x-transition.opacity class="md:hidden">
        <div class="px-4 pt-2 pb-6 space-y-2 border-t border-white/10 bg-gray-900/95 backdrop-blur">
            <div class="flex items-center gap-2 py-2">
                <button @click="toggleTheme"
                    class="p-2 rounded-xl hover:bg-white/10 text-white/80 focus:outline-none focus:ring-2 focus:ring-indigo-400"
                    aria-label="Toggle theme">
                    <svg x-show="theme==='dark'" class="h-5 w-5" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M21.752 15.002A9.718 9.718 0 0 1 12 21.75a9.75 9.75 0 0 1 0-19.5 9.75 9.75 0 0 1 9.752 12.752Z" />
                    </svg>
                    <svg x-show="theme==='light'" class="h-5 w-5" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M12 3v2m0 14v2m9-9h-2M5 12H3m14.95 6.95-1.414-1.414M7.464 7.464 6.05 6.05m11.486 0-1.414 1.414M7.464 16.536 6.05 17.95M12 8a4 4 0 1 0 0 8 4 4 0 0 0 0-8Z" />
                    </svg>
                </button>
                <div class="flex-1">
                    <label for="m-search" class="sr-only">Search</label>
                    <input id="m-search" type="search" placeholder="Search…"
                        class="w-full rounded-xl bg-white/5 ring-1 ring-white/10 placeholder:text-white/40 text-white px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-400" />
                </div>
            </div>

            <div class="space-y-1">
                <x-landing-page-nav-link class="block" href="/"
                    :current="request()->is('/')">Home</x-landing-page-nav-link>
                <x-landing-page-nav-link class="block" href="/posts"
                    :current="request()->is('posts')">Blog</x-landing-page-nav-link>
                <x-landing-page-nav-link class="block" href="/about"
                    :current="request()->is('about')">About</x-landing-page-nav-link>
                <x-landing-page-nav-link class="block" href="/contact"
                    :current="request()->is('contact')">Contact</x-landing-page-nav-link>
                <x-landing-page-nav-link class="block" href="/ujian"
                    :current="request()->is('ujian')">Ujian</x-landing-page-nav-link>
            </div>

            @auth
                <div class="mt-4 rounded-xl border border-white/10 p-4">
                    <div class="flex items-center gap-3">
                        <img class="h-10 w-10 rounded-full object-cover"
                            src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : asset('images/default-avatar.png') }}"
                            alt="{{ Auth::user()->name }}" />
                        <div>
                            <p class="text-sm font-medium text-white/90">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-white/50">{{ Auth::user()->email }}</p>
                        </div>
                    </div>
                    <div class="mt-3 space-y-1">
                        <a href="/profile" class="block rounded-lg px-3 py-2 text-sm text-white/80 hover:bg-white/10">Your
                            Profile</a>
                        <a href="/dashboard"
                            class="block rounded-lg px-3 py-2 text-sm text-white/80 hover:bg-white/10">Dashboard</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="w-full text-left rounded-lg px-3 py-2 text-sm text-red-400 hover:bg-red-500/10">Sign
                                out</button>
                        </form>
                    </div>
                </div>
            @endauth

            @guest
                <div class="mt-2 grid grid-cols-2 gap-2">
                    <a href="{{ route('login') }}"
                        class="rounded-xl px-3 py-2 text-center text-sm font-medium text-white/90 ring-1 ring-white/10 hover:bg-white/10">Login</a>
                    {{-- <a href="{{ route('register') }}"
                        class="rounded-xl px-3 py-2 text-center text-sm font-medium bg-indigo-500/90 hover:bg-indigo-500 text-white">Register</a> --}}
                </div>
            @endguest
        </div>
    </div>
</nav>


<!-- Alpine helpers -->
<script>
    function navbar() {
        return {
            scrolled: false,
            mobileOpen: false,
            theme: 'dark',
            init() {
                // Scroll style
                this.scrolled = window.scrollY > 4;
                window.addEventListener('scroll', () => {
                    this.scrolled = window.scrollY > 4;
                });
                // Theme from localStorage
                const saved = localStorage.getItem('theme');
                const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
                this.theme = saved || (prefersDark ? 'dark' : 'light');
                this.applyTheme();
            },
            toggleTheme() {
                this.theme = this.theme === 'dark' ? 'light' : 'dark';
                localStorage.setItem('theme', this.theme);
                this.applyTheme();
            },
            applyTheme() {
                const html = document.documentElement;
                if (this.theme === 'dark') {
                    html.classList.add('dark');
                    html.classList.add('bg-gray-950');
                } else {
                    html.classList.remove('dark');
                    html.classList.remove('bg-gray-950');
                }
            }
        }
    }
</script>
