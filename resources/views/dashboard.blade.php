<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="alert alert-success p-4 rounded-lg mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 shadow-lg sm:rounded-lg overflow-hidden">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-2xl font-semibold mb-6 text-gray-800 dark:text-gray-200">Booking Table</h3>

                    @if ($bookings->isEmpty())
                        <p class="text-gray-600 dark:text-gray-400">Currently, there is no booking data available.</p>
                    @else
                        <!-- Loop through cinemas -->
                        @foreach ($bookings as $cinemaName => $cinemaGroup)
                            <div class="mb-8">
                                <h4 class="text-2xl font-bold text-primary mb-4">Cinema: {{ $cinemaName }}</h4>

                                <!-- Loop through auditoriums -->
                                @foreach ($cinemaGroup as $auditoriumName => $auditoriumGroup)
                                    <div class="mb-6">
                                        <h5 class="text-xl font-semibold text-secondary mb-3">Auditorium:
                                            {{ $auditoriumName }}</h5>

                                        <!-- Loop through movies -->
                                        @foreach ($auditoriumGroup as $movieTitle => $movieBookings)
                                            <div class="mb-4">
                                                <h6 class="text-lg font-medium text-accent mb-2">Movie:
                                                    {{ $movieTitle }}</h6>

                                                <div class="overflow-x-auto rounded-lg shadow-md">
                                                    <table
                                                        class="min-w-full table-auto border-collapse bg-gray-50 dark:bg-gray-700">
                                                        <thead class="bg-gray-100 dark:bg-gray-600">
                                                            <tr>
                                                                <th
                                                                    class="px-4 py-2 text-left text-sm font-medium text-gray-600 dark:text-gray-200">
                                                                    Customer Name
                                                                </th>
                                                                <th
                                                                    class="px-4 py-2 text-left text-sm font-medium text-gray-600 dark:text-gray-200">
                                                                    Date
                                                                </th>
                                                                <th
                                                                    class="px-4 py-2 text-left text-sm font-medium text-gray-600 dark:text-gray-200">
                                                                    Show Time
                                                                </th>
                                                                <th
                                                                    class="px-4 py-2 text-left text-sm font-medium text-gray-600 dark:text-gray-200">
                                                                    Seat Number
                                                                </th>
                                                                <th
                                                                    class="px-4 py-2 text-left text-sm font-medium text-gray-600 dark:text-gray-200">
                                                                    Action
                                                                </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($movieBookings as $booking)
                                                                <tr class="hover:bg-gray-100 dark:hover:bg-gray-600">
                                                                    <td
                                                                        class="border-t px-4 py-2 text-sm text-gray-800 dark:text-gray-100">
                                                                        {{ $booking->user->name }}
                                                                    </td>
                                                                    <td
                                                                        class="border-t px-4 py-2 text-sm text-gray-800 dark:text-gray-100">
                                                                        {{ \Carbon\Carbon::parse($booking->movieSchedule->date)->format('l, d M Y') }}
                                                                    </td>
                                                                    <td
                                                                        class="border-t px-4 py-2 text-sm text-gray-800 dark:text-gray-100">
                                                                        {{ \Carbon\Carbon::parse($booking->movieSchedule->show_start)->format('H:i') }}
                                                                        -
                                                                        {{ \Carbon\Carbon::parse($booking->movieSchedule->show_end)->format('H:i') }}
                                                                    </td>
                                                                    <td
                                                                        class="border-t px-4 py-2 text-sm text-gray-800 dark:text-gray-100">
                                                                        {{ $booking->seat->seat_code }}
                                                                    </td>
                                                                    <td
                                                                        class="border-t px-4 py-2 text-sm text-gray-800 dark:text-gray-100">
                                                                        @if ($booking->arrived)
                                                                            <span class="text-green-500">Arrived</span>
                                                                        @else
                                                                            <form
                                                                                action="{{ route('booking.arrive', $booking->id) }}"
                                                                                method="POST">
                                                                                @csrf
                                                                                @method('PATCH')
                                                                                <button type="submit"
                                                                                    class="px-4 py-2 text-white bg-blue-500 hover:bg-blue-700 rounded-lg">
                                                                                    Mark as Arrived
                                                                                </button>
                                                                            </form>
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
