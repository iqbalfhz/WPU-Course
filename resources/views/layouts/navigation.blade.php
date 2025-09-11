<nav class="fixed top-0 z-50 w-full bg-white border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700">
    <div class="px-3 py-3 lg:px-5 lg:pl-3">
        <div class="flex items-center justify-between">
            <div class="flex items-center justify-start rtl:justify-end">
                <!-- Hamburger (mobile) -->
                <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar" aria-controls="logo-sidebar"
                    type="button"
                    class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
                    <span class="sr-only">Open sidebar</span>
                    <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                        <path clip-rule="evenodd" fill-rule="evenodd"
                            d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z" />
                    </svg>
                </button>

                <!-- Logo / Brand -->
                <a href="{{ route('dashboard.index') }}" class="flex ms-2 md:me-24 items-center">
                    <img src="{{ asset('images/logo.png') }}" class="h-12 w-auto me-3" alt="Admin Logo">
                    <span class="self-center text-2xl font-bold whitespace-nowrap dark:text-white">
                        Admin Portfolio
                    </span>
                </a>
            </div>

            <!-- USER (Desktop only) -->
            @auth
                <div class="hidden sm:flex items-center ms-3">
                    <button id="dropdownUserButtonDesktop" data-dropdown-toggle="dropdown-user-desktop" type="button"
                        class="flex items-center text-sm bg-white rounded-full focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600 cursor-pointer"
                        aria-expanded="false">
                        <img class="w-8 h-8 rounded-full"
                            src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : asset('images/default-avatar.png') }}"
                            alt="{{ Auth::user()->name }}">
                        <div class="ml-3 text-left">
                            <p class="text-sm font-medium text-gray-700 dark:text-white">{{ Auth::user()->name }}</p>
                        </div>
                        <div class="ms-2 text-gray-700 dark:text-white">
                            <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.06 1.06l-4.24 4.25a.75.75 0 01-1.06 0L5.21 8.27a.75.75 0 01.02-1.06z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                    </button>

                    <!-- Dropdown Content (Desktop) -->
                    <div id="dropdown-user-desktop"
                        class="z-50 hidden mt-2 w-48 text-base list-none bg-white divide-y divide-gray-100 rounded shadow dark:bg-gray-700 dark:divide-gray-600">
                        @include('components.user-menu')
                    </div>
                </div>
            @endauth
            <!-- /USER Desktop -->
        </div>
    </div>
</nav>

<!-- SIDEBAR -->
<aside id="logo-sidebar"
    class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 transition-transform -translate-x-full bg-white border-r border-gray-200 sm:translate-x-0 dark:bg-gray-800 dark:border-gray-700"
    aria-label="Sidebar">
    <!-- Wrapper flex kolom penuh: area menu (scroll) + footer (tetap) -->
    <div class="h-full flex flex-col bg-white dark:bg-gray-800">

        <!-- AREA MENU (scrollable) -->
        <div class="flex-1 min-h-0 px-3 pb-4 overflow-y-auto">
            <ul class="space-y-2 font-medium">
                <li>
                    <a href="{{ route('dashboard.index') }}"
                        class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                        <svg class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"
                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                            viewBox="0 0 22 21">
                            <path
                                d="M16.975 11H10V4.025a1 1 0 0 0-1.066-.998 8.5 8.5 0 1 0 9.039 9.039.999.999 0 0 0-1-1.066h.002Z" />
                            <path
                                d="M12.5 0c-.157 0-.311.01-.565.027A1 1 0 0 0 11 1.02V10h8.975a1 1 0 0 0 1-.935c.013-.188.028-.374.028-.565A8.51 8.51 0 0 0 12.5 0Z" />
                        </svg>
                        <span class="ms-3">Dashboard</span>
                    </a>
                </li>

                <!-- Seleksi Karyawan Menu -->
                <li x-data="{ open: false }">
                    <button @click="open = !open" type="button"
                        class="flex items-center w-full p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                        <svg class="w-5 h-5 text-blue-600 transition duration-75 dark:text-blue-400 group-hover:text-blue-800 dark:group-hover:text-blue-200"
                            fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                            aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        <span class="ms-3 flex-1 text-left">Seleksi Karyawan</span>
                        <svg :class="{ 'rotate-90': open }" class="w-4 h-4 ml-auto transition-transform" fill="none"
                            stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>

                    <ul x-show="open" x-transition x-cloak class="pl-8 mt-2 space-y-1">
                        <li>
                            <a href="{{ route('kandidat.index') }}"
                                class="flex items-center gap-2 py-1 text-gray-700 dark:text-gray-200 hover:underline">
                                <svg class="w-4 h-4 text-green-600 dark:text-green-400" fill="none"
                                    stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M5.121 17.804A13.937 13.937 0 0 1 12 15c2.5 0 4.847.655 6.879 1.804M15 11a3 3 0 1 0-6 0 3 3 0 0 0 6 0Z" />
                                </svg>
                                Data Kandidat
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('tes-online.index') }}"
                                class="flex items-center gap-2 py-1 text-gray-700 dark:text-gray-200 hover:underline">
                                <svg class="w-4 h-4 text-purple-600 dark:text-purple-400" fill="none"
                                    stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 20h9" />
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M16.5 3.5a2.121 2.121 0 1 1-3 3L5 15v4h4l8.5-8.5a2.121 2.121 0 0 0-3-3Z" />
                                </svg>
                                Tes Online
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('soal-online.index') }}"
                                class="flex items-center gap-2 py-1 text-gray-700 dark:text-gray-200 hover:underline">
                                <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none"
                                    stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2" />
                                </svg>
                                Soal Online
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('seleksi.hasil-fuzzy') }}"
                                class="flex items-center gap-2 py-1 text-gray-700 dark:text-gray-200 hover:underline">
                                <svg class="w-4 h-4 text-cyan-600 dark:text-cyan-400" fill="none"
                                    stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M9 17v-2a4 4 0 0 1 8 0v2" />
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>
                                Hasil Seleksi Fuzzy
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('seleksi.rule-fuzzy') }}"
                                class="flex items-center gap-2 py-1 text-gray-700 dark:text-gray-200 hover:underline">
                                <svg class="w-4 h-4 text-red-600 dark:text-red-400" fill="none"
                                    stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3" />
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 19a7 7 0 1 0 0-14 7 7 0 0 0 0 14Z" />
                                </svg>
                                Pengaturan Rule Fuzzy
                            </a>
                        </li>
                    </ul>
                </li>

                <li>
                    <a href="{{ route('posting.index') }}"
                        class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                        <svg class="shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"
                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                            viewBox="0 0 18 18">
                            <path
                                d="M6.143 0H1.857A1.857 1.857 0 0 0 0 1.857v4.286C0 7.169.831 8 1.857 8h4.286A1.857 1.857 0 0 0 8 6.143V1.857A1.857 1.857 0 0 0 6.143 0Zm10 0h-4.286A1.857 1.857 0 0 0 10 1.857v4.286C10 7.169 10.831 8 11.857 8h4.286A1.857 1.857 0 0 0 18 6.143V1.857A1.857 1.857 0 0 0 16.143 0Zm-10 10H1.857A1.857 1.857 0 0 0 0 11.857v4.286C0 17.169.831 18 1.857 18h4.286A1.857 1.857 0 0 0 8 16.143v-4.286A1.857 1.857 0 0 0 6.143 10Zm10 0h-4.286A1.857 1.857 0 0 0 10 11.857v4.286c0 1.026.831 1.857 1.857 1.857h4.286A1.857 1.857 0 0 0 18 16.143v-4.286A1.857 1.857 0 0 0 16.143 10Z" />
                        </svg>
                        <span class="flex-1 ms-3 whitespace-nowrap">Posting</span>
                    </a>
                </li>

                <!-- Contoh item lain (static / belum ada route) -->
                <li>
                    <a href="#"
                        class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                        <svg class="shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"
                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                            viewBox="0 0 20 20">
                            <path
                                d="m17.418 3.623-.018-.008a6.713 6.713 0 0 0-2.4-.569V2h1a1 1 0 1 0 0-2h-2a1 1 0 0 0-1 1v2H9.89A6.977 6.977 0 0 1 12 8v5h-2V8A5 5 0 1 0 0 8v6a1 1 0 0 0 1 1h8v4a1 1 0 0 0 1 1h2a1 1 0 0 0 1-1v-4h6a1 1 0 0 0 1-1V8a5 5 0 0 0-2.582-4.377ZM6 12H4a1 1 0 0 1 0-2h2a1 1 0 0 1 0 2Z" />
                        </svg>
                        <span class="flex-1 ms-3 whitespace-nowrap">Inbox</span>
                        <span
                            class="inline-flex items-center justify-center w-3 h-3 p-3 ms-3 text-sm font-medium text-blue-800 bg-blue-100 rounded-full dark:bg-blue-900 dark:text-blue-300">3</span>
                    </a>
                </li>

                <li>
                    <a href="#"
                        class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                        <svg class="shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"
                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                            viewBox="0 0 20 18">
                            <path
                                d="M14 2a3.963 3.963 0 0 0-1.4.267 6.439 6.439 0 0 1-1.331 6.638A4 4 0 1 0 14 2Zm1 9h-1.264A6.957 6.957 0 0 1 15 15v2a2.97 2.97 0 0 1-.184 1H19a1 1 0 0 0 1-1v-1a5.006 5.006 0 0 0-5-5ZM6.5 9a4.5 4.5 0 1 0 0-9 4.5 4.5 0 0 0 0 9ZM8 10H5a5.006 5.006 0 0 0-5 5v2a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-2a5.006 5.006 0 0 0-5-5Z" />
                        </svg>
                        <span class="flex-1 ms-3 whitespace-nowrap">Users</span>
                    </a>
                </li>

                <li>
                    <a href="#"
                        class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                        <svg class="shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"
                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                            viewBox="0 0 18 20">
                            <path
                                d="M17 5.923A1 1 0 0 0 16 5h-3V4a4 4 0 1 0-8 0v1H2a1 1 0 0 0-1 .923L.086 17.846A2 2 0 0 0 2.08 20h13.84a2 2 0 0 0 1.994-2.153L17 5.923ZM7 9a1 1 0 1 1-2 0V7h2v2Zm0-5a2 2 0 1 1 4 0v1H7V4Zm6 5a1 1 0 1 1-2 0V7h2v2Z" />
                        </svg>
                        <span class="flex-1 ms-3 whitespace-nowrap">Products</span>
                    </a>
                </li>
            </ul>
        </div>

        <!-- FOOTER: Profil mobile (selalu di bawah, hanya tampil di < sm) -->
        <div class="p-3 sm:hidden">
            @include('components.sidebar-mobile-profile')
        </div>
    </div>
</aside>
