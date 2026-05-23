<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BookingRequest extends Model
{
    use HasFactory;

    // === Hằng số trạng thái — viết rõ ràng thay vì viết số trần trong code ===
    const STATUS_PENDING   = 0;  // Chờ xử lý
    const STATUS_CONTACTED = 1;  // Đã liên hệ khách
    const STATUS_CONVERTED = 2;  // Đã chuyển thành booking thật
    const STATUS_CANCELLED = 3;  // Đã hủy

    /**
     * Các cột được phép mass-assign qua ::create() / ::update()
     */
    protected $fillable = [
        'full_name',
        'phone_number',
        'email_contact',
        'specialty',
        'preferred_doctor',
        'preferred_date',
        'preferred_time_range',
        'note',
        'status',
        'admin_note',
        'handled_by',
        'converted_booking_id',
        'ip_address',
    ];

    /**
     * Tự ép kiểu khi đọc/ghi
     */
    protected $casts = [
        'preferred_date' => 'date',
        'status'         => 'integer',
    ];

    /**
     * Accessor: lấy nhãn trạng thái dạng text (tiện hiển thị ở admin)
     * Cách dùng: $bookingRequest->status_label
     */
    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            self::STATUS_PENDING   => 'Chờ xử lý',
            self::STATUS_CONTACTED => 'Đã liên hệ',
            self::STATUS_CONVERTED => 'Đã chuyển thành lịch khám',
            self::STATUS_CANCELLED => 'Đã hủy',
            default                => 'Không xác định',
        };
    }

    /**
     * Accessor: mã hiển thị cho khách (vd: BK-000123)
     * Cách dùng: $bookingRequest->reference_code
     */
    public function getReferenceCodeAttribute(): string
    {
        return 'BK-' . str_pad((string) $this->id, 6, '0', STR_PAD_LEFT);
    }

    // ============================================================
    //  QUAN HỆ
    // ============================================================

    /**
     * Admin (user) tiếp nhận yêu cầu này
     */
    public function handler(): BelongsTo
    {
        return $this->belongsTo(User::class, 'handled_by');
    }

    /**
     * Booking thật đã được tạo từ yêu cầu này (nếu đã convert)
     *
     * ⚠️ Lưu ý: cần có App\Models\Booking. Nếu model của bạn đặt tên khác
     * (vd Appointment) thì sửa lại class reference bên dưới.
     */
    public function convertedBooking(): BelongsTo
    {
        return $this->belongsTo(Booking::class, 'converted_booking_id');
    }
}
