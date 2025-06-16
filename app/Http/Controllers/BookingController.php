<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Carbon;


class BookingController extends Controller
{
        public function index(Request $request)
    {
        $query = Booking::query();

        if ($request->filled('booking_date')) {
            $query->whereDate('booking_date', $request->booking_date);
        }

        if ($request->filled('booking_type')) {
            $query->where('booking_type', $request->booking_type);
        }

        if ($request->filled('customer')) {
            $query->where(function ($q) use ($request) {
                $q->where('customer_name', 'like', '%' . $request->customer . '%')
                  ->orWhere('customer_email', 'like', '%' . $request->customer . '%');
            });
        }

        $bookings = $query->orderByDesc('booking_date')->paginate(10);

        return view('bookings.index', compact('bookings'));
    }

    public function create()
    {
        return view('bookings.create');
    }

    public function store(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'booking_date' => 'required|date',
            'booking_type' => 'required|in:full_day,half_day,custom',
            'booking_slot' => 'required_if:booking_type,half_day|in:first_half,second_half|nullable',
            'from_time' => 'required_if:booking_type,custom|date_format:H:i|nullable',
            'to_time' => 'required_if:booking_type,custom|date_format:H:i|nullable|after:from_time',
        ])->validate();

        // Check for overlaps
        $date = $request->booking_date;
        $type = $request->booking_type;

        $overlapQuery = Booking::where('booking_date', $date);

        if ($type === 'full_day') {
            $exists = $overlapQuery->exists();
        } elseif ($type === 'half_day') {
            $slot = $request->booking_slot;
            $exists = $overlapQuery->where(function ($q) use ($slot) {
                $q->where('booking_type', 'full_day')
                  ->orWhere(function ($q2) use ($slot) {
                      $q2->where('booking_type', 'half_day')
                         ->where('booking_slot', $slot);
                  })
                  ->orWhere(function ($q3) use ($slot) {
                      if ($slot === 'first_half') {
                          $q3->whereBetween('from_time', ['08:00:00', '12:59:59']);
                      } else {
                          $q3->whereBetween('from_time', ['13:00:00', '17:59:59']);
                      }
                  });
            })->exists();
        } elseif ($type === 'custom') {
            $from = $request->from_time;
            $to = $request->to_time;

            $exists = $overlapQuery->where(function ($q) use ($from, $to) {
                $q->where('booking_type', 'full_day')
                  ->orWhere(function ($q2) {
                      $q2->where('booking_type', 'half_day');
                  })
                  ->orWhere(function ($q3) use ($from, $to) {
                      $q3->where('booking_type', 'custom')
                         ->where(function ($q4) use ($from, $to) {
                             $q4->whereBetween('from_time', [$from, $to])
                                ->orWhereBetween('to_time', [$from, $to])
                                ->orWhere(function ($q5) use ($from, $to) {
                                    $q5->where('from_time', '<=', $from)
                                       ->where('to_time', '>=', $to);
                                });
                         });
                  });
            })->exists();
        }

        if ($exists) {
            return back()->withErrors(['error' => 'Booking overlaps with an existing booking.'])->withInput();
        }

        Booking::create([
            'user_id' => Auth::id(),
            'customer_name' => $request->customer_name,
            'customer_email' => $request->customer_email,
            'booking_date' => $date,
            'booking_type' => $type,
            'booking_slot' => $request->booking_slot,
            'from_time' => $request->from_time,
            'to_time' => $request->to_time,
        ]);

        return redirect()->route('bookings.create')->with('success', 'Booking created successfully!');
    }
}
