<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Cinema') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="alert alert-success p-4 rounded-lg mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="alert alert-info p-4 rounded-lg mb-4">
                Currently this page only shows the available data. Other features will be added at a later time. Sorry
                for
                the inconvenience.
            </div>

            <div class="bg-white dark:bg-gray-800 shadow-lg sm:rounded-lg overflow-hidden">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex flex-wrap justify-between mb-4">
                        <h3 class="text-2xl font-semibold mb-6 text-gray-800 dark:text-gray-200">Cinema Table</h3>
                        <button class="btn btn-primary">
                            + Add Cinema
                        </button>
                    </div>

                    @if ($cinemas->isEmpty())
                        <p class="text-gray-600 dark:text-gray-400">Currently, there is no cinema data available.</p>
                    @else
                        <div class="mb-8">
                            <div class="overflow-x-auto rounded-lg shadow-md">
                                <table class="min-w-full table-auto border-collapse bg-gray-50 dark:bg-gray-700">
                                    <thead class="bg-gray-100 dark:bg-gray-600">
                                        <tr>
                                            <th
                                                class="px-4 py-2 text-left text-sm font-medium text-gray-600 dark:text-gray-200">
                                                Cinema Name
                                            </th>
                                            <th
                                                class="px-4 py-2 text-left text-sm font-medium text-gray-600 dark:text-gray-200">
                                                City
                                            </th>
                                            <th
                                                class="px-4 py-2 text-left text-sm font-medium text-gray-600 dark:text-gray-200">
                                                Address
                                            </th>
                                            <th
                                                class="px-4 py-2 text-left text-sm font-medium text-gray-600 dark:text-gray-200">
                                                Open Time
                                            </th>
                                            <th
                                                class="px-4 py-2 text-left text-sm font-medium text-gray-600 dark:text-gray-200">
                                                Closing Time
                                            </th>
                                            <th
                                                class="px-4 py-2 text-left text-sm font-medium text-gray-600 dark:text-gray-200">
                                                Action
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Loop through cinemas -->
                                        @foreach ($cinemas as $cinema)
                                            <tr class="hover:bg-gray-100 dark:hover:bg-gray-600">
                                                <td class="border-t px-4 py-2 text-sm text-gray-800 dark:text-gray-100">
                                                    {{ $cinema->name }}
                                                </td>
                                                <td class="border-t px-4 py-2 text-sm text-gray-800 dark:text-gray-100">
                                                    {{ $cinema->city }}
                                                </td>
                                                <td class="border-t px-4 py-2 text-sm text-gray-800 dark:text-gray-100">
                                                    {{ $cinema->address }}
                                                </td>
                                                <td class="border-t px-4 py-2 text-sm text-gray-800 dark:text-gray-100">
                                                    {{ \Carbon\Carbon::parse($cinema->open_time)->format('H:i') }}
                                                </td>
                                                <td class="border-t px-4 py-2 text-sm text-gray-800 dark:text-gray-100">
                                                    {{ \Carbon\Carbon::parse($cinema->close_time)->format('H:i') }}
                                                </td>
                                                <td class="border-t px-4 py-2 text-sm text-gray-800 dark:text-gray-100">
                                                    <button class="btn btn-primary">
                                                        Edit
                                                    </button>
                                                    <button class="btn btn-error">
                                                        Delete
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
