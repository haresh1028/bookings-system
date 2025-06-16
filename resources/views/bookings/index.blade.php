<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Bookings') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">

                <form method="GET" action="{{ route('bookings.index') }}" class="mb-6 flex flex-wrap gap-4">
                    <input type="date" name="booking_date" value="{{ request('booking_date') }}"
                        class="border rounded p-2">

                    <select name="booking_type" class="border rounded p-2">
                        <option value="">All Types</option>
                        <option value="full_day" @selected(request('booking_type') == 'full_day')>Full Day</option>
                        <option value="half_day" @selected(request('booking_type') == 'half_day')>Half Day</option>
                        <option value="custom" @selected(request('booking_type') == 'custom')>Custom</option>
                    </select>

                    <input type="text" name="customer" placeholder="Customer name or email"
                        value="{{ request('customer') }}" class="border rounded p-2">

                    <button type="submit" class="btn btn-primary">Filter</button>
                </form>

                <table class="w-full table-auto text-sm">
                    <thead>
                        <tr class="text-left border-b dark:border-gray-700">
                            <th class="py-2">Customer</th>
                            <th>Email</th>
                            <th>Booking Date</th>
                            <th>Type</th>
                            <th>Slot</th>
                            <th>From</th>
                            <th>To</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bookings as $booking)
                            <tr class="border-b dark:border-gray-700">
                                <td class="py-2">{{ $booking->customer_name }}</td>
                                <td>{{ $booking->customer_email }}</td>
                                <td>{{ \Carbon\Carbon::parse($booking->booking_date)->format('Y-m-d') }}</td>
                                <td>{{ ucfirst(str_replace('_', ' ', $booking->booking_type)) }}</td>
                                <td>{{ $booking->booking_slot ?? '-' }}</td>
                                <td>{{ $booking->from_time ?? '-' }}</td>
                                <td>{{ $booking->to_time ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-4 text-center">No bookings found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-4">
                    {{ $bookings->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
