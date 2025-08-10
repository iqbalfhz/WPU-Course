<ul class="py-1 text-sm text-gray-700 dark:text-gray-200">
    <li>
        <a href="{{ route('profile.edit') }}"
            class="block px-4 py-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition">
            Profile
        </a>
    </li>
    <li>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();"
                class="block px-4 py-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition text-red-600 dark:text-red-400">
                Sign out
            </a>
        </form>
    </li>
</ul>
