<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Auditorium') }}
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
                        <h3 class="text-2xl font-semibold mb-6 text-gray-800 dark:text-gray-200">Auditorium Table</h3>
                        <button class="btn btn-primary">
                            + Add Auditorium
                        </button>
                    </div>

                    @if ($groupedAuditoriums->isEmpty())
                        <p class="text-gray-600 dark:text-gray-400">Currently, there is no auditorium data available.
                        </p>
                    @else
                        <div class="mb-8">
                            <div class="overflow-x-auto rounded-lg shadow-md">
                                <table class="min-w-full table-auto border-collapse bg-gray-50 dark:bg-gray-700">
                                    <thead class="bg-gray-100 dark:bg-gray-600">
                                        <tr>
                                            <th
                                                class="px-4 py-2 text-left text-sm font-medium text-gray-600 dark:text-gray-200">
                                                Auditorium Name
                                            </th>
                                            <th
                                                class="px-4 py-2 text-left text-sm font-medium text-gray-600 dark:text-gray-200">
                                                Cinema Name
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
                                        @foreach ($groupedAuditoriums as $cinemaName => $auditoriums)
                                            <tr class="bg-gray-200 dark:bg-gray-600">
                                                <td colspan="5"
                                                    class="px-4 py-2 text-lg font-semibold text-primary-content">
                                                    {{ $cinemaName }}
                                                </td>
                                            </tr>
                                            @foreach ($auditoriums as $auditorium)
                                                <tr class="hover:bg-gray-100 dark:hover:bg-gray-600">
                                                    <td
                                                        class="border-t px-4 py-2 text-sm text-gray-800 dark:text-gray-100">
                                                        {{ $auditorium->name }}
                                                    </td>
                                                    <td
                                                        class="border-t px-4 py-2 text-sm text-gray-800 dark:text-gray-100">
                                                        {{ $auditorium->cinema->name }}
                                                    </td>
                                                    <td
                                                        class="border-t px-4 py-2 text-sm text-gray-800 dark:text-gray-100">
                                                        {{ \Carbon\Carbon::parse($auditorium->cinema->open_time)->format('H:i') }}
                                                    </td>
                                                    <td
                                                        class="border-t px-4 py-2 text-sm text-gray-800 dark:text-gray-100">
                                                        {{ \Carbon\Carbon::parse($auditorium->cinema->close_time)->format('H:i') }}
                                                    </td>
                                                    <td
                                                        class="border-t px-4 py-2 text-sm text-gray-800 dark:text-gray-100">
                                                        <button class="btn btn-primary">
                                                            Edit
                                                        </button>
                                                        <button class="btn btn-error">
                                                            Delete
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
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
