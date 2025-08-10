<nav class="bg-gray-800" x-data="{ isOpen: false }">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 items-center justify-between">
            <div class="flex items-center">
                <div class="shrink-0">
                    <img class="size-20" src="{{ asset('images/logo.png') }}" alt="Your Company" />
                </div>
                <div class="hidden md:block">
                    <div class="ml-10 flex items-baseline space-x-4">
                        <x-landing-page-nav-link href="/" :current="request()->is('/')">Home</x-landing-page-nav-link>
                        <x-landing-page-nav-link href="/posts" :current="request()->is('posts')">Blog</x-landing-page-nav-link>
                        <x-landing-page-nav-link href="/about" :current="request()->is('about')">About</x-landing-page-nav-link>
                        <x-landing-page-nav-link href="/contact" :current="request()->is('contact')">Contact</x-landing-page-nav-link>
                    </div>
                </div>
            </div>
            <div class="hidden md:block">
                <div class="ml-4 flex items-center md:ml-6">

                    <!-- Profile dropdown -->
                    <div class="relative ml-3">
                        <div>
                            @if (Auth::check())
                                <button type="button" @click="isOpen = !isOpen"
                                    class="relative flex max-w-xs items-center rounded-full bg-gray-800 text-sm focus:outline-hidden focus-visible:ring-2 focus-visible:ring-white focus-visible:ring-offset-2 focus-visible:ring-offset-gray-800 cursor-pointer"
                                    id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                                    <span class="absolute -inset-1.5"></span>
                                    <span class="sr-only">Open user menu</span>
                                    <img class="size-8 rounded-full"
                                        src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : asset('images/default-avatar.png') }}"
                                        alt="{{ Auth::user()->name }}" />
                                    <div class="ml-3">
                                        <div class="text-sm font-medium text-gray-300">{{ Auth::user()->name }}</div>
                                    </div>
                                    <div class="ms-1 text-gray-300">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </button>
                            @else
                                <a href="{{ route('login') }}"
                                    class="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Login</a>
                                <a href="{{ route('register') }}"
                                    class="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Register</a>
                            @endif
                        </div>

                        <div x-show="isOpen" x-transition:enter="transition ease-out duration-100 transform"
                            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75 transform"
                            x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                            class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black/5 focus:outline-hidden"
                            role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button"
                            tabindex="-1">
                            <!-- Active: "bg-gray-100 outline-hidden", Not Active: "" -->
                            <a href="/profile" class="block px-4 py-2 text-sm text-gray-700" role="menuitem"
                                tabindex="-1" id="user-menu-item-0">Your Profile</a>
                            <a href="/dashboard" class="block px-4 py-2 text-sm text-gray-700" role="menuitem"
                                tabindex="-1" id="user-menu-item-1">Dashboard</a>
                            <form method="POST" action="{{ route('logout') }}" class="block">
                                @csrf
                                <button type="submit" class="block px-4 py-2 text-sm text-gray-700 cursor-pointer"
                                    role="menuitem" tabindex="-1" id="user-menu-item-2">Log Out</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="-mr-2 flex md:hidden">
                <!-- Mobile menu button -->
                <button type="button" @click="isOpen = !isOpen"
                    class="relative inline-flex items-center justify-center rounded-md bg-gray-800 p-2 text-gray-400 hover:bg-gray-700 hover:text-white focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800 focus:outline-hidden"
                    aria-controls="mobile-menu" aria-expanded="false">
                    <span class="absolute -inset-0.5"></span>
                    <span class="sr-only">Open main menu</span>
                    <!-- Menu open: "hidden", Menu closed: "block" -->
                    <svg :class="{ 'hidden': isOpen, 'block': !isOpen }" class="size-6" fill="none"
                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"
                        data-slot="icon">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                    <!-- Menu open: "block", Menu closed: "hidden" -->
                    <svg :class="{ 'block': isOpen, 'hidden': !isOpen }" class="size-6" fill="none"
                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"
                        data-slot="icon">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile menu, show/hide based on menu state. -->
    <div x-show="isOpen" class="md:hidden" id="mobile-menu">
        <div class="space-y-1 px-2 pt-2 pb-3 sm:px-3">
            <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->
            <x-landing-page-nav-link class="block" href="/" :current="request()->is('/')">Home</x-landing-page-nav-link>
            <x-landing-page-nav-link class="block" href="/posts" :current="request()->is('posts')">Blog</x-landing-page-nav-link>
            <x-landing-page-nav-link class="block" href="/about" :current="request()->is('about')">About</x-landing-page-nav-link>
            <x-landing-page-nav-link class="block" href="/contact"
                :current="request()->is('contact')">Contact</x-landing-page-nav-link>
        </div>
        <div class="border-t border-gray-700 pt-4 pb-3">
            @auth
                <div class="flex items-center px-5">
                    <div class="shrink-0">
                        <img class="size-10 rounded-full"
                            src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : asset('images/default-avatar.png') }}"
                            alt="{{ Auth::user()->name }}" />
                    </div>
                    <div class="ml-3">
                        <div class="text-base/5 font-medium text-white">T{{ Auth::user()->name }}</div>
                        <div class="text-sm font-medium text-gray-400">{{ Auth::user()->email }}</div>
                    </div>
                </div>
                <div class="mt-3 space-y-1 px-2">
                    <a href="/profile"
                        class="block rounded-md px-3 py-2 text-base font-medium text-gray-400 hover:bg-gray-700 hover:text-white">Your
                        Profile</a>
                    <a href="/dashboard"
                        class="block rounded-md px-3 py-2 text-base font-medium text-gray-400 hover:bg-gray-700 hover:text-white">Dashboard</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="block w-full text-left rounded-md px-3 py-2 text-base font-medium text-gray-400 hover:bg-gray-700 hover:text-white">
                            Sign out
                        </button>
                    </form>
                </div>
            @endauth
            @guest
                <div class="mt-3 space-y-1 px-2">
                    <a href="{{ route('login') }}"
                        class="block rounded-md px-3 py-2 text-base font-medium text-gray-400 hover:bg-gray-700 hover:text-white">Login</a>
                    <a href="{{ route('register') }}"
                        class="block rounded-md px-3 py-2 text-base font-medium text-gray-400 hover:bg-gray-700 hover:text-white">Register</a>
                </div>
            @endguest
        </div>
    </div>
</nav>
