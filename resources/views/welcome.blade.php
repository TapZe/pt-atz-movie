<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'AtoZ Movie') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased dark:bg-black dark:text-white/50">
    <div class="bg-gray-50 text-black/50 dark:bg-black dark:text-white/50">
        <img id="background" class="absolute -left-20 top-0 max-w-[877px]"
            src="https://laravel.com/assets/img/welcome/background.svg" alt="background" />
        <div
            class="relative min-h-screen flex flex-col items-center justify-center selection:bg-[#FF2D20] selection:text-white">
            <div class="relative w-full max-w-2xl p-6 lg:max-w-7xl">
                <header class="flex flex-grow justify-end">
                    @if (Route::has('login'))
                        <nav class="-mx-3 flex flex-1 justify-end">
                            @auth
                                @if (auth()->user()->isAdmin())
                                    <a href="{{ url('/dashboard') }}"
                                        class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
                                        Admin Dashboard
                                    </a>
                                @else
                                    <a href="{{ route('profile.edit') }}"
                                        class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
                                        Profile
                                    </a>
                                @endif
                                <a href="{{ route('profile.history') }}"
                                    class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
                                    Your Ticket
                                </a>
                            @else
                                <a href="{{ route('login') }}"
                                    class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
                                    Log in
                                </a>

                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}"
                                        class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
                                        Register
                                    </a>
                                @endif
                            @endauth
                        </nav>
                    @endif
                </header>

                <main class="mt-6 overflow-x-hidden px-4">
                    <div class="grid grid-cols-1 gap-6">
                        <!-- Cinema Section -->
                        <section>
                            <h2 class="text-2xl font-semibold text-black dark:text-white mb-6">Our Cinemas!</h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                @forelse ($cinemas as $cinema)
                                    <a href={{ route('cinema.detail', $cinema->id) }}
                                        class="block max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                                        <h1
                                            class="mb-2 text-xl font-semibold tracking-tight text-gray-900 dark:text-white">
                                            {{ $cinema->name }}</h1>
                                        <h2 class="mb-2 text-l tracking-tight text-gray-900 dark:text-white">
                                            {{ $cinema->city }}</h2>
                                        <p class="font-normal text-gray-700 dark:text-gray-400">{{ $cinema->address }}
                                        </p>
                                        <p class="font-normal text-small text-gray-700 dark:text-gray-400">Auditorium:
                                        </p>
                                        <div class="flex flex-col">
                                            @forelse ($cinema->auditorium as $auditorium)
                                                <span
                                                    class="bg-blue-100 text-blue-800 text-md font-medium my-1 px-2.5 py-0.5 rounded-full dark:bg-blue-900 dark:text-blue-300">
                                                    {{ $auditorium->name }}
                                                </span>
                                            @empty
                                                <span class="text-gray-500 dark:text-gray-400 text-sm">No
                                                    auditoriums available</span>
                                            @endforelse
                                        </div>
                                    </a>
                                @empty
                                    <p class="text-gray-500 dark:text-gray-400">No cinemas available.</p>
                                @endforelse
                            </div>
                        </section>

                        <!-- Promo Section -->
                        <section>
                            <h2 class="text-2xl font-semibold text-black dark:text-white mb-6">Get Your Promo!</h2>
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                                @forelse ($promos as $promo)
                                    <div
                                        class="max-w-sm bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                                        <img class="rounded-t-lg object-cover h-40 w-full" src="{{ $promo->image }}"
                                            alt="{{ $promo->name }}" />
                                        <div class="p-5">
                                            <h5
                                                class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                                                {{ $promo->name }}</h5>
                                            <p class="mb-4 font-normal text-gray-700 dark:text-gray-400">
                                                {{ $promo->description }}</p>
                                            <p class="mb-4">
                                                <span
                                                    class="bg-blue-100 text-blue-800 text-md font-medium my-1 px-2.5 py-0.5 rounded-full capitalize dark:bg-blue-900 dark:text-blue-300">
                                                    {{ $promo->type }}
                                                </span>
                                            </p>
                                            <p class="mb-2">
                                                Usage Date:
                                            </p>
                                            <p class="mb-4">
                                                <span
                                                    class="bg-green-100 text-green-800 text-sm font-medium me-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">
                                                    {{ $promo->start_date }}
                                                </span>
                                                until
                                                <span
                                                    class="bg-yellow-100 text-yellow-800 text-sm font-medium m-1 px-2.5 py-0.5 rounded dark:bg-yellow-900 dark:text-yellow-300">
                                                    {{ $promo->end_date }}
                                                </span>
                                            </p>
                                            <p class="mb-2">
                                                Code:
                                            </p>
                                            <input type="text"
                                                class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                value="{{ $promo->code }}" readonly>
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-gray-500 dark:text-gray-400">No promos available.</p>
                                @endforelse
                            </div>
                        </section>

                        <!-- Movies Section -->
                        <section>
                            <h2 class="text-2xl font-semibold text-black dark:text-white mb-6">Now Playing!</h2>
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                                @forelse ($movies as $movie)
                                    <a href={{ route('movie.detail', $movie->id) }}
                                        class="max-w-sm rounded-lg overflow-hidden shadow-lg bg-white dark:bg-gray-800 hover:scale-105 transform transition-transform">
                                        <img class="w-full h-60 object-cover"
                                            src="{{ env('TMDB_IMG_PATH') }}{{ $movie->poster_path }}"
                                            alt="{{ $movie->title }}">
                                        <div class="px-6 py-4">
                                            <h3 class="font-bold text-lg mb-2 text-gray-800 dark:text-gray-200">
                                                {{ $movie->title }}
                                            </h3>
                                            <p class="text-gray-600 dark:text-gray-300 text-sm mb-4">
                                                {{ $movie->description }}
                                            </p>
                                            <div class="flex flex-wrap">
                                                @forelse ($movie->genre as $genre)
                                                    <span
                                                        class="bg-purple-100 text-purple-800 text-sm font-medium me-2 px-2.5 py-0.5 rounded-full dark:bg-purple-900 dark:text-purple-300">
                                                        {{ $genre->name }}
                                                    </span>
                                                @empty
                                                    <span class="text-gray-500 dark:text-gray-400 text-sm">No genres
                                                        available</span>
                                                @endforelse
                                            </div>
                                        </div>
                                    </a>
                                @empty
                                    <p class="text-gray-500 dark:text-gray-400">No movies available.</p>
                                @endforelse
                            </div>
                        </section>
                    </div>
                </main>

                <footer class="py-10 text-center text-sm text-black dark:text-white/70">
                    AtoZ Movies
                </footer>
            </div>
        </div>
    </div>
</body>

</html>
