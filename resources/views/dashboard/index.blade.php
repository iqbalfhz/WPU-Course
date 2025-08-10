<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight pt-4">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mt-6">
        <div class="bg-white dark:bg-gray-700 p-6 rounded-lg shadow text-center">
            <p class="text-gray-500 dark:text-gray-300 text-sm">Total Users</p>
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white">1,240</h2>
        </div>
        <div class="bg-white dark:bg-gray-700 p-6 rounded-lg shadow text-center">
            <p class="text-gray-500 dark:text-gray-300 text-sm">New Orders</p>
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white">342</h2>
        </div>
        <div class="bg-white dark:bg-gray-700 p-6 rounded-lg shadow text-center">
            <p class="text-gray-500 dark:text-gray-300 text-sm">Visitors Today</p>
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white">2,176</h2>
        </div>
    </div>

</x-app-layout>
