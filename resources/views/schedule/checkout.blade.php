<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'AtoZ Movie') }} - {{ $schedule->auditorium->cinema->name }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-200 min-h-screen flex flex-col">
    <div class="font-sans antialiased flex-1 p-6 max-w-6xl mx-auto">
        <!-- Back to Seat Selection -->
        <div class="mb-6">
            <a href="{{ route('schedule.detail', $schedule->id) }}" class="btn btn-outline btn-primary">
                ← Back to Seat Selection
            </a>
        </div>

        <!-- Movie and Schedule Details -->
        <div class="mb-10">
            <h1 class="text-5xl font-bold text-primary dark:text-primary-content mb-4">
                {{ $schedule->movie->title }}
            </h1>
            <p class="text-lg text-gray-600 dark:text-gray-400">
                Showing at <span class="font-bold">{{ $schedule->auditorium->cinema->name }}</span>,
                Auditorium <span class="font-bold">{{ $schedule->auditorium->name }}</span>
            </p>
            <p class="text-lg text-gray-600 dark:text-gray-400 mt-2">
                <span class="font-bold">Date:</span> {{ \Carbon\Carbon::parse($schedule->date)->format('l, F j, Y') }}
                <br>
                <span class="font-bold">Time:</span> {{ \Carbon\Carbon::parse($schedule->show_start)->format('H:i') }}
            </p>
        </div>

        <!-- Selected Seats -->
        <div class="mb-10">
            <h4 class="text-2xl font-semibold text-primary dark:text-primary-content mb-4">Selected Seats</h4>
            <ul class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @foreach ($seats as $seat)
                    <li class="text-gray-800 dark:text-gray-300">
                        Seat: <span class="font-bold">{{ $seat->seat_code }}</span>
                    </li>
                @endforeach
            </ul>
        </div>

        <!-- Promo Code -->
        <div class="mb-10">
            <h4 class="text-2xl font-semibold text-primary dark:text-primary-content mb-4">Promo Code</h4>

            <!-- Promo Code Form -->
            <form action="{{ route('checkout') }}" method="POST" class="flex items-center space-x-4">
                @csrf
                @method('POST')
                <input type="text" name="promo_code" placeholder="Enter Promo Code"
                    class="input input-bordered w-full max-w-xs dark:bg-gray-800 dark:text-white dark:border-gray-600"
                    value="{{ old('promo_code') }}">
                <input type="hidden" name="schedule_id" value="{{ $schedule->id }}">
                @foreach ($seats as $seat)
                    <input type="hidden" name="seats[]" value="{{ $seat->id }}">
                @endforeach
                <button type="submit" class="btn btn-primary dark:btn-secondary">
                    Apply
                </button>
            </form>

            <!-- Promo Code Applied / Error Message -->
            @if ($discount)
                <div class="mt-4 text-green-600 dark:text-green-400">
                    Promo Applied: <strong>{{ session('promo_code') }}</strong>
                    <br> Discount: Rp. {{ number_format($discount, 0, ',', '.') }}
                </div>
            @elseif(isset($message))
                <div class="mt-4 text-red-600 dark:text-red-400">
                    {{ $message }}
                </div>
            @endif
        </div>

        <!-- Total Price -->
        <div class="mb-10 bg-gray-100 dark:bg-gray-800 p-6 rounded-lg shadow-md">
            <h4 class="text-2xl font-semibold text-primary dark:text-primary-content mb-4">Total Price</h4>

            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-2">
                    <span class="text-gray-600 dark:text-gray-400 text-lg">Number of Seats:</span>
                </div>
                <span class="font-bold text-gray-800 dark:text-gray-200">{{ count($seats) }}</span>
            </div>

            <div class="flex items-center justify-between mt-2">
                <div class="flex items-center space-x-2">
                    <span class="text-gray-600 dark:text-gray-400 text-lg">Price per Seat:</span>
                </div>
                <span class="font-bold text-gray-800 dark:text-gray-200">Rp.
                    {{ number_format($schedule->price->number, 0, ',', '.') }}</span>
            </div>

            <hr class="my-4 border-gray-300 dark:border-gray-700">

            <!-- Before Discount (Original Total) -->
            @if ($discount > 0)
                <div class="flex items-center justify-between mt-2">
                    <div class="flex items-center space-x-2">
                        <span class="text-gray-600 dark:text-gray-400 text-lg">Total Before Discount:</span>
                    </div>
                    <span class="font-bold text-gray-800 dark:text-gray-200">Rp.
                        {{ number_format($totalPrice, 0, ',', '.') }}</span>
                </div>

                <!-- Show Discount if available -->
                <div class="flex items-center justify-between mt-2">
                    <div class="flex items-center space-x-2">
                        <span class="text-gray-600 dark:text-gray-400 text-lg">Discount:</span>
                    </div>
                    <span class="font-bold text-red-600 dark:text-red-400">- Rp.
                        {{ number_format($discount, 0, ',', '.') }}</span>
                </div>
            @endif

            <!-- Final Price -->
            <div class="flex items-center justify-between text-xl font-bold">
                <div class="flex items-center space-x-2">
                    <span>Total:</span>
                </div>
                <span class="text-primary dark:text-primary-content">Rp.
                    {{ number_format($finalPrice, 0, ',', '.') }}</span>
            </div>
        </div>

        <!-- Proceed to Payment -->
        <form action="{{ route('book.seats') }}" method="POST" class="mt-6">
            @csrf

            <input type="hidden" name="schedule_id" value="{{ $schedule->id }}">
            @foreach ($seats as $seat)
                <input type="hidden" name="seats[]" value="{{ $seat->id }}">
            @endforeach

            <button type="submit" class="btn btn-lg btn-primary dark:btn-secondary w-full py-4">
                Confirm and Pay
            </button>
        </form>
    </div>

    <!-- Footer -->
    <footer class="footer footer-center p-6 bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 mt-10">
        <div>
            <p>&copy; {{ date('Y') }} {{ config('app.name', 'AtoZ Movie') }}. All rights reserved.</p>
        </div>
    </footer>
</body>

</html>
