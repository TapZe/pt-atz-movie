<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'AtoZ Movie') }} - Your Ticket</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-200 flex flex-col min-h-screen">
    <div class="font-sans antialiased p-6 max-w-7xl mx-auto flex-grow">
        <!-- Back to Home Button -->
        <div class="mb-6">
            <a href="{{ route('welcome') }}"
                class="btn btn-outline btn-primary dark:btn-secondary shadow-md hover:scale-105 transform transition-transform">
                ← Back to Home Page
            </a>
        </div>

        <!-- Display Message if Available -->
        @if (session('message'))
            <div class="flex justify-center mb-6">
                <p class="text-lg text-green-600 dark:text-green-400">{{ session('message') }}</p>
            </div>
        @endif

        <!-- Booking History Title -->
        <h1 class="text-4xl font-bold text-primary dark:text-primary-content mb-6">
            Your Ticket Booking History
        </h1>

        <!-- Group Tickets by Date -->
        @if ($history->ticket->isEmpty())
            <p class="text-lg text-gray-600 dark:text-gray-400">You haven't made any bookings yet.</p>
        @else
            @php
                $groupedByDate = $history->ticket->groupBy(function ($ticket) {
                    return \Carbon\Carbon::parse($ticket->movieSchedule->date)->format('l, d M Y');
                });
            @endphp

            <!-- Render Grouped Tickets by Date -->
            @foreach ($groupedByDate as $date => $tickets)
                <div class="mb-8">
                    <h2 class="text-3xl font-bold text-secondary dark:text-secondary-content mb-4">{{ $date }}
                    </h2>
                    <div class="flex flex-wrap gap-4 justify-between">
                        @foreach ($tickets as $ticket)
                            <div
                                class="card shadow-xl bg-gray-100 dark:bg-gray-800 text-gray-800 dark:text-gray-200 p-4 rounded-lg hover:shadow-2xl transition-all">
                                <div class="card-body">
                                    <h3
                                        class="card-title text-2xl font-bold text-secondary dark:text-secondary-content mb-4">
                                        {{ $ticket->movieSchedule->movie->title }}
                                    </h3>

                                    <div class="text-lg text-gray-600 dark:text-gray-400 mb-4">
                                        <p><span class="font-semibold">Showtime:</span>
                                            {{ $ticket->movieSchedule->show_start }} -
                                            {{ $ticket->movieSchedule->show_end }}</p>
                                        <p><span class="font-semibold">Seats Booked:</span>
                                            {{ $ticket->seat->seat_code }}</p>
                                        <p><span class="font-semibold">Cinema:</span>
                                            {{ $ticket->movieSchedule->auditorium->cinema->name }}</p>
                                        <p><span class="font-semibold">City Location:</span>
                                            {{ $ticket->movieSchedule->auditorium->cinema->city }}</p>
                                        <p><span class="font-semibold">Address:</span>
                                            {{ $ticket->movieSchedule->auditorium->cinema->address }}</p>
                                        <p><span class="font-semibold">Ticket ID:</span>
                                            {{ $ticket->id }}</p>
                                    </div>

                                    <!-- Booking Status -->
                                    <div class="mt-4 space-y-2">
                                        <p class="text-xl font-semibold">
                                            Payment Status:
                                            @if ($ticket->payyed)
                                                <span class="text-green-500">Payyed</span>
                                            @else
                                                <span class="text-red-500">Not Payyed</span>
                                            @endif
                                        </p>
                                        <p class="text-xl font-semibold">
                                            Arrival Status:
                                            @if ($ticket->arrived)
                                                <span class="text-green-500">Confirmed</span>
                                            @else
                                                <span class="text-red-500">Not Confirmed</span>
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        @endif
    </div>

    <footer class="footer footer-center p-6 bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 mt-10">
        <div>
            <p>&copy; {{ date('Y') }} {{ config('app.name', 'AtoZ Movie') }}. All rights reserved.</p>
        </div>
    </footer>
</body>

</html>
