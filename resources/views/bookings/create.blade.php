<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create Booking') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                @if(session('success'))
                    <div class="mb-4 text-green-600">{{ session('success') }}</div>
                @endif

                @if($errors->any())
                    <div class="mb-4 text-red-600">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('bookings.store') }}">
                    @csrf

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Customer Name</label>
                        <input type="text" name="customer_name" class="mt-1 block w-full" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Customer Email</label>
                        <input type="email" name="customer_email" class="mt-1 block w-full" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Booking Date</label>
                        <input type="date" name="booking_date" class="mt-1 block w-full" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Booking Type</label>
                        <select name="booking_type" id="booking_type" class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent" required>
                            <option value="">Select Type</option>
                            <option value="full_day">Full Day</option>
                            <option value="half_day">Half Day</option>
                            <option value="custom">Custom</option>
                        </select>
                    </div>

                    <div class="mb-4 hidden" id="slot_div">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Booking Slot</label>
                        <select name="booking_slot" class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                            <option value="first_half">First Half</option>
                            <option value="second_half">Second Half</option>
                        </select>
                    </div>

                    <div class="mb-4 hidden" id="custom_time_div">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">From Time</label>
                        <input type="time" name="from_time" class="mt-1 block w-full">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mt-2">To Time</label>
                        <input type="time" name="to_time" class="mt-1 block w-full">
                    </div>

                    <div>
                        <button type="submit" class="bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 text-white font-semibold py-2 px-4 rounded-lg shadow-md hover:shadow-lg transition duration-300">
                            Submit
                        </button>

                    </div>

                </form>

                <script>
                    document.getElementById('booking_type').addEventListener('change', function () {
                        let type = this.value;
                        document.getElementById('slot_div').classList.add('hidden');
                        document.getElementById('custom_time_div').classList.add('hidden');

                        if (type === 'half_day') {
                            document.getElementById('slot_div').classList.remove('hidden');
                        } else if (type === 'custom') {
                            document.getElementById('custom_time_div').classList.remove('hidden');
                        }
                    });
                </script>
            </div>
        </div>
    </div>
</x-app-layout>
