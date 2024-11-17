<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'AtoZ Movie') }} - {{ $cinema->name }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-200">
    <div class="font-sans antialiased p-6 max-w-7xl mx-auto">
        <!-- Back to Home Button -->
        <div class="mb-6">
            <a href="{{ route('welcome') }}"
                class="btn btn-outline btn-primary dark:btn-secondary shadow-md hover:scale-105 transform transition-transform">
                ← Back to Home Page
            </a>
        </div>

        <!-- Cinema Info Card -->
        <div class="card shadow-xl bg-gray-100 dark:bg-gray-800 text-gray-800 dark:text-gray-200 mb-8">
            <div class="card-body">
                <h1 class="card-title text-4xl font-bold text-primary dark:text-primary-content mb-4">
                    {{ $cinema->name }}
                </h1>
                <div class="text-lg text-gray-600 dark:text-gray-400 mb-4">
                    <p class="mb-2"><span class="font-semibold">City:</span> {{ $cinema->city }}</p>
                    <p><span class="font-semibold">Address:</span> {{ $cinema->address }}</p>
                </div>
            </div>
        </div>

        <!-- Auditoriums Section -->
        <h2 class="text-3xl font-semibold text-secondary dark:text-secondary-content mb-6">Auditoriums</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach ($cinema->auditorium as $auditorium)
                <div
                    class="card bg-gray-100 dark:bg-gray-800 shadow-xl text-gray-800 dark:text-gray-200 rounded-lg p-4 hover:scale-105 transform transition-transform">
                    <div class="card-body">
                        <h3 class="card-title text-2xl font-bold text-secondary dark:text-secondary mb-4">
                            {{ $auditorium->name }}
                        </h3>

                        <!-- Movie Schedule Accordion -->
                        <div
                            class="collapse collapse-arrow border border-gray-300 dark:border-gray-600 bg-gray-100 dark:bg-gray-800 rounded-box">
                            <input type="checkbox" class="peer hidden" id="collapse-{{ $auditorium->id }}" />
                            <label for="collapse-{{ $auditorium->id }}"
                                class="collapse-title text-lg font-medium cursor-pointer">
                                Movie Schedules
                            </label>
                            <div class="collapse-content peer-checked:block hidden">
                                @php
                                    // Group movie schedules by date
                                    $groupedSchedules = $auditorium->movieSchedule->groupBy('date');
                                @endphp

                                <ul class="space-y-4">
                                    @foreach ($groupedSchedules as $date => $schedules)
                                        <li
                                            class="bg-gray-200 dark:bg-gray-700 p-4 rounded-lg shadow-md text-gray-800 dark:text-gray-200">
                                            <h4 class="font-bold text-lg text-primary dark:text-primary-content mb-2">
                                                {{ \Carbon\Carbon::parse($date)->format('l, d M Y') }}
                                            </h4>
                                            <ul class="pl-5 space-y-2">
                                                @foreach ($schedules as $schedule)
                                                    <li>
                                                        <a href="{{ route('schedule.detail', ['id' => $schedule->id]) }}"
                                                            onclick="event.stopPropagation()"
                                                            class="block bg-gray-100 dark:bg-gray-800 p-3 rounded-lg shadow hover:bg-primary hover:text-white transition-colors">
                                                            <h5 class="font-semibold">
                                                                {{ $schedule->movie->title }}
                                                            </h5>
                                                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                                                Showtime: {{ $schedule->show_start }} -
                                                                {{ $schedule->show_end }}
                                                            </p>
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer footer-center p-6 bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 mt-10">
        <div>
            <p>&copy; {{ date('Y') }} {{ config('app.name', 'AtoZ Movie') }}. All rights reserved.</p>
        </div>
    </footer>
</body>

</html>
