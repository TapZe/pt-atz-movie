<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'AtoZ Movie') }} - {{ $movie->title }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-200">
    <div class="font-sans antialiased p-6 max-w-5xl mx-auto">
        <!-- Back to Home Button -->
        <div class="mb-6">
            <a href="{{ route('welcome') }}"
                class="btn btn-outline btn-primary dark:btn-secondary shadow-md hover:scale-105 transform transition-transform">
                ← Back to Home Page
            </a>
        </div>

        <!-- Movie Details Section -->
        <div class="card shadow-xl bg-gray-100 dark:bg-gray-800 text-gray-800 dark:text-gray-200">
            <div class="card-body flex flex-col md:flex-row">
                <!-- Movie Poster -->
                <div class="w-full md:w-1/3 mb-6 md:mb-0">
                    <img src="{{ env('TMDB_IMG_PATH') }}{{ $movie->poster_path }}" alt="{{ $movie->title }} Poster"
                        class="rounded-lg shadow-lg w-full h-auto">
                </div>

                <!-- Movie Info -->
                <div class="w-full md:w-2/3 md:pl-8">
                    <h1 class="text-4xl font-bold text-primary dark:text-primary-content mb-4">
                        {{ $movie->title }}
                    </h1>
                    <p class="text-lg text-gray-600 dark:text-gray-400 mb-4">
                        {{ $movie->overview }}
                    </p>

                    <ul class="text-lg text-gray-800 dark:text-gray-300 space-y-2">
                        <li><span class="font-semibold">Original Title:</span> {{ $movie->original_title }}</li>
                        <li><span class="font-semibold">Language:</span> {{ strtoupper($movie->original_language) }}
                        </li>
                        <li><span class="font-semibold">Release Date:</span>
                            {{ \Carbon\Carbon::parse($movie->release_date)->format('d M Y') }}</li>
                        <li><span class="font-semibold">Runtime:</span> {{ $movie->runtime }} mins</li>
                        <li><span class="font-semibold">Vote Average:</span> {{ $movie->vote_average }} / 10</li>
                        <li><span class="font-semibold">Vote Count:</span> {{ $movie->vote_count }}</li>
                        <!-- Display Genres -->
                        <li><span class="font-semibold">Genres:</span>
                            @foreach ($movie->genre as $genre)
                                <span>{{ $genre->name }}{{ !$loop->last ? ', ' : '' }}</span>
                            @endforeach
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Backdrop Section -->
        @if ($movie->backdrop_path)
            <div class="mt-10">
                <h2 class="text-3xl font-semibold text-secondary dark:text-secondary-content mb-4">Movie Backdrop</h2>
                <div class="rounded-lg overflow-hidden shadow-xl">
                    <img src="{{ env('TMDB_IMG_PATH') }}{{ $movie->backdrop_path }}"
                        alt="{{ $movie->title }} Backdrop" class="w-full h-auto">
                </div>
            </div>
        @endif

        <!-- Movie Schedule Section -->
        <h1 class="text-4xl font-bold text-primary dark:text-primary-content mt-8 mb-4">Movie Schedules</h1>

        @if ($schedule->isEmpty())
            <div class="alert alert-warning shadow-lg">
                <div>
                    <span>No schedules available for this movie in the upcoming week.</span>
                </div>
            </div>
        @else
            @php
                // Group schedules by cinema
                $groupedByCinema = $schedule->groupBy('auditorium.cinema.name');
            @endphp

            @foreach ($groupedByCinema as $cinemaName => $cinemaSchedules)
                <!-- Cinema Card -->
                <div class="card shadow-xl bg-gray-100 dark:bg-gray-800 text-gray-800 dark:text-gray-200 mb-8">
                    <div class="card-body">
                        <h2 class="text-3xl font-bold text-secondary dark:text-secondary-content mb-4">
                            {{ $cinemaName }}
                        </h2>

                        @php
                            // Group schedules by auditorium
                            $groupedByAuditorium = $cinemaSchedules->groupBy('auditorium.name');
                        @endphp

                        @foreach ($groupedByAuditorium as $auditoriumName => $auditoriumSchedules)
                            <div class="mb-6">
                                <h3 class="text-2xl font-semibold text-primary dark:text-primary-content mb-2">
                                    Auditorium: {{ $auditoriumName }}
                                </h3>

                                @php
                                    // Group schedules by date
                                    $groupedByDate = $auditoriumSchedules->groupBy(function ($item) {
                                        return \Carbon\Carbon::parse($item->date)->format('Y-m-d'); // Format as 'YYYY-MM-DD'
                                    });
                                @endphp

                                @foreach ($groupedByDate as $date => $dateSchedules)
                                    <div class="mb-4">
                                        <h4 class="text-xl font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                            {{ \Carbon\Carbon::parse($date)->format('l, d M Y') }}
                                        </h4>
                                        <ul class="space-y-4">
                                            @foreach ($dateSchedules as $scheduleItem)
                                                <li>
                                                    <a href="{{ route('schedule.detail', ['id' => $scheduleItem->id]) }}"
                                                        class="block bg-gray-200 dark:bg-gray-700 p-4 rounded-lg shadow-md text-gray-800 dark:text-gray-200 hover:bg-primary hover:text-white transition-colors">
                                                        <p>
                                                            <span class="font-bold">Showtime:</span>
                                                            {{ $scheduleItem->show_start }} -
                                                            {{ $scheduleItem->show_end }}
                                                        </p>
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        @endif
    </div>

    <!-- Footer -->
    <footer class="footer footer-center p-6 bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 mt-10">
        <div>
            <p>&copy; {{ date('Y') }} {{ config('app.name', 'AtoZ Movie') }}. All rights reserved.</p>
        </div>
    </footer>
</body>

</html>
