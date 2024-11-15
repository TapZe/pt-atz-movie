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
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                                @forelse ($cinemas as $cinema)
                                    <div class="max-w-sm rounded-lg shadow-lg bg-white dark:bg-gray-800">
                                        <div class="px-6 py-4">
                                            <h3 class="font-bold text-lg mb-2 text-gray-800 dark:text-gray-200">
                                                {{ $cinema->title }}
                                            </h3>
                                            <p class="text-gray-600 dark:text-gray-300 text-sm mb-4">
                                                {{ $cinema->description }}
                                            </p>
                                            <div class="grid">
                                                @forelse ($cinema->auditorium as $auditorium)
                                                    <p
                                                        class="bg-blue-200 rounded-full px-3 py-1 text-xs font-semibold text-blue-700 mr-2 mb-2">
                                                        {{ $auditorium->name }}
                                                    </p>
                                                @empty
                                                    <span class="text-gray-500 dark:text-gray-400 text-sm">No
                                                        auditoriums available</span>
                                                @endforelse
                                            </div>
                                        </div>
                                    </div>
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
                                        class="max-w-sm rounded-lg overflow-hidden shadow-lg bg-white dark:bg-gray-800 hover:scale-105 transform transition-transform">
                                        <img class="w-full h-48 object-cover" src="{{ $promo->image }}"
                                            alt="{{ $promo->title }}">
                                        <div class="px-6 py-4">
                                            <h3 class="font-bold text-lg mb-2 text-gray-800 dark:text-gray-200">
                                                {{ $promo->title }}
                                            </h3>
                                            <p class="text-gray-600 dark:text-gray-300 text-sm mb-4">
                                                {{ $promo->description }}
                                            </p>
                                            <span
                                                class="inline-block bg-yellow-200 rounded-full px-3 py-1 text-xs font-semibold text-yellow-700">
                                                {{ $promo->type }}
                                            </span>
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-gray-500 dark:text-gray-400">No promos available.</p>
                                @endforelse
                            </div>
                        </section>

                        <!-- Movies Section -->
                        <section>
                            <h2 class="text-2xl font-semibold text-black dark:text-white mb-6">Movies</h2>
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                                @forelse ($movies as $movie)
                                    <div
                                        class="max-w-sm rounded-lg overflow-hidden shadow-lg bg-white dark:bg-gray-800 hover:scale-105 transform transition-transform">
                                        <img class="w-full h-48 object-cover"
                                            src="https://image.tmdb.org/t/p/original/{{ $movie->poster_path }}"
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
                                                        class="inline-block bg-red-200 rounded-full px-3 py-1 text-xs font-semibold text-red-700 mr-2 mb-2">
                                                        {{ $genre->name }}
                                                    </span>
                                                @empty
                                                    <span class="text-gray-500 dark:text-gray-400 text-sm">No genres
                                                        available</span>
                                                @endforelse
                                            </div>
                                        </div>
                                    </div>
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
