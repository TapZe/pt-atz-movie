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
    <div class="font-sans antialiased p-6 max-w-7xl mx-auto">
        <!-- Back to Home Button -->
        <div class="mb-6">
            <a href="{{ route('movie.detail', ['id' => $movie->id]) }}"
                class="btn btn-outline btn-primary dark:btn-secondary shadow-md hover:scale-105 transform transition-transform">
                ← Back to Movie Details
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

        <!-- Movie Schedule Section -->
        <h1 class="text-4xl font-bold text-primary dark:text-primary-content mt-8 mb-4">The Schedule</h1>

        @if (!$schedule)
            <div class="alert alert-warning shadow-lg">
                <div>
                    <span>No schedules available for this movie in the upcoming week.</span>
                </div>
            </div>
        @else
            <div class="card shadow-xl bg-gray-100 dark:bg-gray-800 text-gray-800 dark:text-gray-200 mb-8">
                <div class="card-body">
                    <div class="mb-4">
                        <h4 class="text-xl font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            {{ \Carbon\Carbon::parse($schedule->date)->format('l, d M Y') }}
                        </h4>
                        <ul class="space-y-4">
                            <li
                                class="block bg-gray-200 dark:bg-gray-700 p-4 rounded-lg shadow-md text-gray-800 dark:text-gray-200">
                                <p>
                                    <span class="font-bold">Showtime:</span>
                                    {{ $schedule->show_start }} -
                                    {{ $schedule->show_end }}
                                </p>
                            </li>
                        </ul>
                    </div>

                    <!-- Seating Section -->
                    <h4 class="text-2xl font-semibold text-primary dark:text-primary-content mb-4">Seats</h4>
                    <form action="{{ route('checkout') }}" method="POST">
                        @csrf
                        @method('POST')
                        <input type="hidden" name="schedule_id" value="{{ $schedule->id }}">
                        <div class="overflow-x-scroll p-5">
                            <div class="grid grid-cols-4 gap-x-4 md:gap-x-8 gap-y-2 min-w-max xl:min-w-full">
                                @foreach ($seats as $index => $seat)
                                    <!-- Start a new row every 5 seats -->
                                    @if ($index % 5 == 0)
                                        <div class="grid grid-cols-5">
                                    @endif
                                    <div class="flex justify-center items-center">
                                        @if ($schedule->seat()->wherePivot('seat_id', $seat->id)->wherePivot('user_id', '!=', null)->exists())
                                            <span class="btn btn-sm btn-error">{{ $seat->seat_code }}</span>
                                        @else
                                            <label for="seat_{{ $seat->id }}" class="cursor-pointer">
                                                <input type="checkbox" id="seat_{{ $seat->id }}" name="seats[]"
                                                    value="{{ $seat->id }}" class="hidden peer"
                                                    {{ old('seats') && in_array($seat->id, old('seats')) ? 'checked' : '' }} />
                                                <span
                                                    class="peer-checked:bg-green-500 peer-checked:text-black text-green-500 btn btn-outline btn-sm">
                                                    {{ $seat->seat_code }}
                                                </span>
                                            </label>
                                        @endif
                                    </div>
                                    <!-- Close the grid row after 5 seats -->
                                    @if (($index + 1) % 5 == 0 || $loop->last)
                            </div>
        @endif
        @endforeach
    </div>
    </div>

    <!-- Screen Section -->
    <div
        class="mt-10 text-3xl font-bold text-center border-2 border-gray-400 rounded-lg p-4 bg-gray-200 dark:bg-gray-700 shadow-lg w-full">
        <div class="flex justify-center items-center mb-2">
            <svg class="w-8 h-8 text-primary dark:text-primary-content mr-2" xmlns="http://www.w3.org/2000/svg"
                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v8m4-4H8" />
            </svg>
            <span>Cinema Display</span>
            <svg class="w-8 h-8 text-primary dark:text-primary-content ml-2" xmlns="http://www.w3.org/2000/svg"
                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v8m4-4H8" />
            </svg>
        </div>
        <p class="text-lg text-gray-600 dark:text-gray-300">Experience the thrill of watching your favorite movies on
            the big screen!</p>
    </div>

    <!-- Submit Button -->
    <div class="mt-6 flex justify-center">
        <button type="submit" class="btn btn-primary dark:btn-secondary">Book Selected Seats</button>
    </div>
    </form>
    </div>
    </div>
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
