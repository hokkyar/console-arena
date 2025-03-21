<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Service;
use App\Models\Schedule;
use App\Models\Booking;
use App\Models\Payment;

class BookingController extends Controller
{
    public function index()
    {
        $availableDates = [];
        $currentYear = now()->year;
        $currentMonth = now()->month;

        $services = Service::all();
        $allSessions = ["Sesi 1", "Sesi 2", "Sesi 3"];

        for ($m = 0; $m < 12; $m++) {
            $date = now()->addMonths($m);
            $year = $date->year;
            $month = $date->month;
            $daysInMonth = $date->daysInMonth;

            for ($d = 1; $d <= $daysInMonth; $d++) {
                $dateString = "$year-$month-$d";

                foreach ($services as $service) {
                    $bookedSessions = Booking::where('service_id', $service->id)
                        ->whereDate('booking_date', "$year-$month-$d")
                        ->where('status', 'paid')
                        ->pluck('session')
                        ->toArray();

                    $availableSessions = array_values(array_diff($allSessions, $bookedSessions));
                    $availableDates[$dateString][$service->id] = $availableSessions;
                }
            }
        }

        return view('index', compact('availableDates', 'services'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'service_id' => 'required|exists:services,id',
            'booking_date' => 'required|date',
            'session' => 'required|string|in:Sesi 1,Sesi 2,Sesi 3',
            'customer_name' => 'required|string|min:3|max:50',
            'customer_email' => 'required|email|max:100',
            'customer_phone' => 'required|string|min:10|max:15',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 400);
        }

        $existingBooking = Booking::where([
            'service_id' => $request->service_id,
            'booking_date' => $request->booking_date,
            'session' => $request->session,
            'status' => 'paid'
        ])->exists();

        if ($existingBooking) return response()->json(['message' => 'Sesi sudah dibooking orang lain!'], 409);

        $amount = 0;
        $weekendSurcharge = 0;
        $service = Service::find($request->service_id);
        $amount += $service->base_price;

        $dayOfWeek = date('N', strtotime($request->booking_date));
        if ($dayOfWeek == 6 || $dayOfWeek == 7) {
            $weekendSurcharge = 50000;
            $amount += 50000;
        }

        DB::beginTransaction();
        try {
            $all = $request->all();
            $all['weekend_surcharge'] = $weekendSurcharge;
            $booking = Booking::create($all);
            $paymentController = new PaymentController();
            $snapToken = $paymentController->getSnapToken([
                'booking_id' => $booking->id,
                'total' => $amount,
                'service_name' => $service->name,
                'session' => $request->session,
                'customer_name' => $request->customer_name,
                'customer_email' => $request->customer_email,
                'customer_phone' => $request->customer_phone
            ]);

            Payment::create([
                'booking_id' => $booking->id,
                'amount' => $amount,
                'snap_token' => $snapToken
            ]);

            DB::commit();
            return response()->json(['message' => 'Booking berhasil', 'snap_token' => $snapToken], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Booking gagal', 'snap_token' => null], 500);
        }
    }
}
