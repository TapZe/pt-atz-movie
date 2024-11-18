<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Schedule') }}
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
                Currently this page only shows the available data. Other features will be added at a later time.
                Sorry
                for
                the inconvenience.
            </div>

            <div class="alert alert-warning p-4 rounded-lg mb-4">
                <p>
                    The movie schedule is automatically updated every day between 08:30 and 08:45 GMT+8. This schedule
                    is based on the available auditoriums and the currently playing movies, which are fetched from
                    <a class="hover:underline text-blue-800" target="_blank" href="https://www.themoviedb.org">
                        The Movie Database (TMDB).
                    </a>
                </p>
            </div>

            <div class="bg-white dark:bg-gray-800 shadow-lg sm:rounded-lg overflow-hidden">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex flex-wrap justify-between mb-4">
                        <h3 class="text-2xl font-semibold mb-6 text-gray-800 dark:text-gray-200">Schedule Table</h3>
                        <button class="btn btn-primary">
                            + Add Cinema
                        </button>
                    </div>

                    @if ($groupedMovieSchedule->isEmpty())
                        <p class="text-gray-600 dark:text-gray-400">Currently, there is no schedule data available.</p>
                    @else
                        <div class="mb-8">
                            <div class="overflow-x-auto rounded-lg shadow-md">
                                @foreach ($groupedMovieSchedule as $cinemaAuditorium => $dateGroups)
                                    <h4 class="text-lg font-semibold mb-2 text-primary-content">{{ $cinemaAuditorium }}
                                    </h4>
                                    @foreach ($dateGroups as $date => $schedules)
                                        <h5 class="text-lg font-semibold mb-2">
                                            {{ \Carbon\Carbon::parse($date)->format('l, d M Y') }}</h5>
                                        <table
                                            class="min-w-full table-auto border-collapse bg-gray-50 dark:bg-gray-700 mb-4">
                                            <thead class="bg-gray-100 dark:bg-gray-600">
                                                <tr>
                                                    <th
                                                        class="px-4 py-2 text-left text-sm font-medium text-gray-600 dark:text-gray-200">
                                                        Movie Name</th>
                                                    <th
                                                        class="px-4 py-2 text-left text-sm font-medium text-gray-600 dark:text-gray-200">
                                                        Show Start</th>
                                                    <th
                                                        class="px-4 py-2 text-left text-sm font-medium text-gray-600 dark:text-gray-200">
                                                        Show End</th>
                                                    <th
                                                        class="px-4 py-2 text-left text-sm font-medium text-gray-600 dark:text-gray-200">
                                                        Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($schedules as $schedule)
                                                    <tr class="hover:bg-gray-100 dark:hover:bg-gray-600">
                                                        <td
                                                            class="border-t px-4 py-2 text-sm text-gray-800 dark:text-gray-100">
                                                            {{ $schedule->movie->title }}
                                                        </td>
                                                        <td
                                                            class="border-t px-4 py-2 text-sm text-gray-800 dark:text-gray-100">
                                                            {{ \Carbon\Carbon::parse($schedule->show_start)->format('H:i') }}
                                                        </td>
                                                        <td
                                                            class="border-t px-4 py-2 text-sm text-gray-800 dark:text-gray-100">
                                                            {{ \Carbon\Carbon::parse($schedule->show_end)->format('H:i') }}
                                                        </td>
                                                        <td
                                                            class="border-t px-4 py-2 text-sm text-gray-800 dark:text-gray-100">
                                                            <button class="btn btn-primary">Edit</button>
                                                            <button class="btn btn-error">Delete</button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    @endforeach
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
