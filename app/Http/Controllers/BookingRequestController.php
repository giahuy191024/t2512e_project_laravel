<?php

namespace App\Http\Controllers;

use App\Models\BookingRequest;
use Illuminate\Http\Request;

class BookingRequestController extends Controller
{
    /**
     * Hiển thị form đặt lịch cho khách vãng lai (không cần đăng nhập).
     *
     * GET /dat-lich-nhanh
     */
    public function create()
    {
        return view('booking-requests.create');
    }

    /**
     * Tiếp nhận và lưu yêu cầu từ khách.
     *
     * POST /dat-lich-nhanh
     */
    public function store(Request $request)
    {
        // === 1. Validate đầu vào ===
        $validated = $request->validate([
            'full_name'            => ['required', 'string', 'max:150', 'min:2'],
            'phone_number'         => ['required', 'string', 'regex:/^(0|\+84)[\s.\-]?\d{2,3}[\s.\-]?\d{3}[\s.\-]?\d{3,4}$/'],
            'email_contact'        => ['nullable', 'email', 'max:255'],
            'specialty'            => ['nullable', 'string', 'max:100'],
            'preferred_doctor'     => ['nullable', 'string', 'max:150'],
            'preferred_date'       => ['nullable', 'date', 'after_or_equal:today'],
            'preferred_time_range' => ['nullable', 'string', 'max:30'],
            'note'                 => ['nullable', 'string', 'max:1000'],
            'consent'              => ['accepted'], // checkbox đồng ý chính sách
        ], [
            'full_name.required'            => 'Vui lòng nhập họ và tên.',
            'full_name.min'                 => 'Họ tên quá ngắn.',
            'phone_number.required'         => 'Vui lòng nhập số điện thoại.',
            'phone_number.regex'            => 'Số điện thoại không hợp lệ.',
            'email_contact.email'           => 'Email không hợp lệ.',
            'preferred_date.after_or_equal' => 'Ngày khám phải từ hôm nay trở đi.',
            'consent.accepted'              => 'Vui lòng đồng ý với chính sách bảo mật.',
        ]);

        // === 2. Chuẩn hóa số điện thoại (bỏ space / dấu chấm / gạch) ===
        $validated['phone_number'] = preg_replace('/[\s.\-]/', '', $validated['phone_number']);

        // === 3. Bỏ field consent ra (chỉ dùng để validate, không lưu DB) ===
        unset($validated['consent']);

        // === 4. Bổ sung dữ liệu hệ thống ===
        $validated['ip_address'] = $request->ip();
        $validated['status']     = BookingRequest::STATUS_PENDING;

        // === 5. Lưu DB ===
        $bookingRequest = BookingRequest::create($validated);

        // === 6. Chuyển sang trang cảm ơn (Post/Redirect/Get pattern) ===
        return redirect()
            ->route('booking-requests.thanks', ['code' => $bookingRequest->reference_code])
            ->with('booking_request', [
                'full_name'    => $bookingRequest->full_name,
                'phone_number' => $bookingRequest->phone_number,
                'code'         => $bookingRequest->reference_code,
            ]);
    }

    /**
     * Trang cảm ơn sau khi gửi yêu cầu thành công.
     *
     * GET /dat-lich-nhanh/thanks/{code}
     *
     * Lưu ý: chỉ hiển thị mã yêu cầu. KHÔNG load chi tiết từ DB để tránh
     * lộ thông tin khi người khác đoán mã (vd BK-000124).
     */
    public function thanks(string $code)
    {
        // Lấy thông tin từ session flash (chỉ có ngay sau redirect)
        $info = session('booking_request');

        return view('booking-requests.thanks', [
            'code' => $code,
            'info' => $info,
        ]);
    }
}
