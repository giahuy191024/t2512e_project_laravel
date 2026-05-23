<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use App\Models\Booking;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    // Bước 1: Tạo giao dịch và chuyển hướng sang PayPal
    public function createPaypalPayment(Request $request, $booking_id)
    {
        $booking = Booking::findOrFail($booking_id);
        $paypal = new PayPalClient;
        $paypal->setApiCredentials(config('paypal'));
        $token = $paypal->getAccessToken();
        $paypal->setAccessToken($token);

        $order = [
            "intent" => "CAPTURE",
            "purchase_units" => [[
                "amount" => [
                    "currency_code" => config('paypal.currency', 'USD'),
                    "value" => $booking->deposit_amount ?? 10
                ],
                "description" => "Dat coc lich kham #{$booking->id}",
            ]],
            "application_context" => [
                "cancel_url" => route('payment.paypal.cancel', $booking->id),
                "return_url" => route('payment.paypal.return', $booking->id),
            ]
        ];
        $response = $paypal->createOrder($order);
        \Log::info('PayPal createOrder response', ['response' => $response]);
        \Log::info('PayPal access token', ['token' => $token]);
        if (isset($response['links'])) {
            foreach ($response['links'] as $link) {
                if ($link['rel'] === 'approve') {
                    return redirect()->away($link['href']);
                }
            }
        }
        $msg = 'Không tạo được giao dịch PayPal.';
        if (isset($response['name']) || isset($response['message'])) {
            $msg .= ' ' . ($response['name'] ?? '') . ' ' . ($response['message'] ?? '');
        }
        return back()->with('error', $msg);
    }

    // Bước 2: Xử lý khi PayPal redirect về (thành công)
    public function handlePaypalReturn(Request $request, $booking_id)
    {
        $paypal = new PayPalClient;
        $paypal->setApiCredentials(config('paypal'));
        $token = $paypal->getAccessToken();
        $paypal->setAccessToken($token);
        $orderId = $request->get('token');
        $response = $paypal->capturePaymentOrder($orderId);
        if (isset($response['status']) && $response['status'] === 'COMPLETED') {
            // Cập nhật trạng thái booking và transaction
            DB::transaction(function() use ($booking_id, $response) {
                $booking = Booking::findOrFail($booking_id);
                $booking->status = 'paid';
                $booking->save();
                Transaction::create([
                    'booking_id' => $booking->id,
                    'payment_method_id' => 3, // PayPal
                    'amount' => $response['purchase_units'][0]['payments']['captures'][0]['amount']['value'] ?? 0,
                    'currency' => $response['purchase_units'][0]['payments']['captures'][0]['amount']['currency_code'] ?? 'USD',
                    'transaction_code' => $response['id'],
                    'status' => 1,
                    'payment_date' => now(),
                    'gateway_response' => json_encode($response),
                ]);
            });
            return redirect()->route('patient.bookings')->with('success', 'Thanh toán thành công!');
        }
        return redirect()->route('patient.bookings')->with('error', 'Thanh toán thất bại!');
    }

    // Bước 3: Xử lý khi PayPal cancel
    public function handlePaypalCancel($booking_id)
    {
        return redirect()->route('patient.bookings')->with('error', 'Bạn đã hủy thanh toán.');
    }
}
