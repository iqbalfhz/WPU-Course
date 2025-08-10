@php($user = Auth::user())
<div class="rounded-2xl bg-white p-4 dark:bg-gray-800">
    {{-- Header: avatar, nama, email --}}
    <div class="text-center">
        <img class="w-14 h-14 rounded-full mx-auto mb-3 ring-2 ring-gray-200 dark:ring-gray-700"
            src="{{ $user->avatar ? asset('storage/' . $user->avatar) : asset('images/default-avatar.png') }}"
            alt="{{ $user->name }}">
        {{-- Nama --}}
        <p class="text-base font-semibold text-gray-900 dark:text-white leading-tight">
            {{ $user->name }}
        </p>
        <p class="text-xs text-gray-500 dark:text-gray-400 truncate">
            {{ $user->email }}
        </p>
    </div>

    {{-- Menu (reuse) --}}
    <div class="mt-3">
        @include('components.user-menu')
    </div>

    {{-- Toolbar ikon --}}
    <div class="mt-4 flex items-center justify-center gap-6 text-gray-400">
        <button type="button" class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700">
            <svg class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                <path
                    d="M3 3h4v4H3V3zm0 6h4v4H3V9zm6-6h4v4H9V3zm6 0h4v4h-4V3zM9 9h4v4H9V9zm6 6h4v4h-4v-4zM9 15h4v4H9v-4zM3 15h4v4H3v-4z" />
            </svg>
        </button>
        <button type="button" class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700">
            <svg class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                <path
                    d="M10 2a6 6 0 00-6 6v3.586L2.707 13.88A1 1 0 003 15h14a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zm0 16a3 3 0 01-3-3h6a3 3 0 01-3 3z" />
            </svg>
        </button>
        <button type="button" class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700">
            <svg class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                <path
                    d="M10 18a8 8 0 110-16 8 8 0 010 16zm-.25-5.5h1.5v1.5h-1.5v-1.5zM10 5a3 3 0 00-3 3h1.5a1.5 1.5 0 112.81.66c-.2.47-.67.77-1.13 1.06-.62.38-1.18.73-1.18 1.78V13h1.5v-.5c0-.45.26-.66.81-.99.65-.39 1.94-1.17 1.94-2.76A3 3 0 0010 5z" />
            </svg>
        </button>
    </div>
</div>
