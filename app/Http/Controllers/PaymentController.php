<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Booking;
use App\Models\Payment;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Transaction;

class PaymentController extends Controller
{
    public function __construct()
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$clientKey = config('midtrans.client_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');
    }

    public function getSnapToken(Request $request)
    {
        $params = [
          'transaction_details' => [
              'order_id' => $request->booking_id . '-' . rand(),
              'gross_amount' => $request->total,
          ],
          'customer_details' => [
              'first_name' => $request->customer_name,
              'email' => $request->customer_email,
              'phone' => $request->customer_phone,
          ],
          // 'callbacks' => [
          //   'finish' => url('/payment/success'),
          // ],
        ];

        try {
            $snapToken = Snap::getSnapToken($params);
            return $snapToken;
        } catch (\Exception $e) {
            return $e;
        }
    }

    public function handle(Request $request)
    {
      $serverKey = config('midtrans.server_key');
      $hashedKey = hash('sha512', $request->order_id . $request->status_code . $request->gross_amount . $serverKey);

      if ($hashedKey !== $request->signature_key) {
          return response()->json(['message' => 'Invalid signature key'], 403);
      }

      $transactionStatus = $request->transaction_status;
      $bookingId = explode('-', $request->order_id)[0];

      $booking = Booking::find($bookingId);
      if (!$booking) {
          return response()->json(['message' => 'Booking not found'], 404);
      }
      
      $payment = Payment::where('booking_id', $bookingId)->first();
      if (!$payment) {
          return response()->json(['message' => 'Payment not found'], 404);
      }

      $existingBooking = Booking::where([
          'service_id' => $booking->service_id,
          'booking_date' => $booking->booking_date,
          'session' => $booking->session,
          'status' => 'paid'
      ])->exists();

      if ($existingBooking) {
          Transaction::cancel($request->order_id);
          $payment->status = 'failed';
          $booking->status = 'cancelled';
          $booking->save();
          $payment->save();
          return response()->json(['message' => 'Session already booked'], 409);
      }

      DB::beginTransaction();
          try {
            switch($transactionStatus) {
              case 'settlement':
                  $booking->status = 'paid';
                  $payment->status = 'success';
                  break;
              case 'pending':
                  $booking->status = 'pending';
                  $payment->status = 'pending';
                  break;
              case 'cancel':
                  $booking->status = 'cancelled';
                  $payment->status = 'failed';
                  break;
          }
          $payment->save();
          $booking->save();
          DB::commit();
          return response()->json(['message' => 'Callback processed successfully']);
      }catch(\Exception $e) {
        DB::rollback();
        return response()->json(['message' => 'Callback processing failed'], 500);
      }
    }

    public function redirect()
    {
      return view('payment-success');
    }
}