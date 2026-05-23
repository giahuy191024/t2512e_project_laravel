<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Đặt lịch nhanh — Dành cho khách chưa có tài khoản</title>

    {{-- Tailwind qua Vite (Laravel 12 default). Nếu setup khác, đổi sang CDN ở cuối comment. --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Ion-icon (giống auth-modal) --}}
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</head>
<body class="min-h-screen bg-gradient-to-br from-sky-50 via-white to-cyan-50 py-10 px-4">

<div class="max-w-2xl mx-auto">

    {{-- ===== HEADER ===== --}}
    <div class="text-center mb-8">
        <span class="inline-block px-4 py-1.5 bg-sky-100 text-sky-700 text-xs font-bold uppercase tracking-wider rounded-full mb-3">
            Dành cho khách vãng lai
        </span>
        <h1 class="text-3xl sm:text-4xl font-bold text-slate-800 mb-2">Đặt lịch nhanh</h1>
        <p class="text-slate-600 text-sm leading-relaxed">
            Bạn chưa có tài khoản? Không sao — chỉ cần để lại thông tin,<br class="hidden sm:block">
            đội ngũ tư vấn sẽ gọi lại xác nhận lịch hẹn trong thời gian sớm nhất.
        </p>
    </div>

    {{-- ===== FORM CARD ===== --}}
    <div class="bg-white rounded-2xl shadow-md p-6 sm:p-8">

        {{-- Hiển thị lỗi tổng quát --}}
        @if ($errors->any())
            <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
                <p class="text-red-700 font-semibold mb-1 flex items-center gap-2">
                    <ion-icon name="alert-circle-outline" class="text-lg"></ion-icon>
                    Vui lòng kiểm tra lại thông tin:
                </p>
                <ul class="text-sm text-red-600 list-disc list-inside space-y-0.5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('booking-requests.store') }}" method="POST" class="space-y-5" autocomplete="off">
            @csrf

            {{-- === Họ và tên === --}}
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">
                    Họ và tên <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 flex pointer-events-none">
                        <ion-icon name="person-outline" class="text-lg"></ion-icon>
                    </span>
                    <input type="text" name="full_name"
                           value="{{ old('full_name') }}"
                           placeholder="Nguyễn Văn A"
                           class="w-full pl-10 pr-3 py-2.5 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500 @error('full_name') border-red-400 bg-red-50 @else border-slate-300 @enderror">
                </div>
                @error('full_name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            {{-- === SĐT + Email (2 cột) === --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">
                        Số điện thoại <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 flex pointer-events-none">
                            <ion-icon name="call-outline" class="text-lg"></ion-icon>
                        </span>
                        <input type="tel" name="phone_number"
                               value="{{ old('phone_number') }}"
                               placeholder="09xx xxx xxx"
                               inputmode="tel"
                               class="w-full pl-10 pr-3 py-2.5 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500 @error('phone_number') border-red-400 bg-red-50 @else border-slate-300 @enderror">
                    </div>
                    @error('phone_number')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">
                        Email <span class="text-slate-400 font-normal text-xs">(không bắt buộc)</span>
                    </label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 flex pointer-events-none">
                            <ion-icon name="mail-outline" class="text-lg"></ion-icon>
                        </span>
                        <input type="email" name="email_contact"
                               value="{{ old('email_contact') }}"
                               placeholder="you@example.com"
                               class="w-full pl-10 pr-3 py-2.5 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500 @error('email_contact') border-red-400 bg-red-50 @else border-slate-300 @enderror">
                    </div>
                    @error('email_contact')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
            </div>

            {{-- === Chuyên khoa === --}}
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">
                    Chuyên khoa quan tâm <span class="text-slate-400 font-normal text-xs">(không bắt buộc)</span>
                </label>
                <div class="relative">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 flex pointer-events-none">
                        <ion-icon name="medkit-outline" class="text-lg"></ion-icon>
                    </span>
                    <select name="specialty"
                            class="w-full pl-10 pr-3 py-2.5 border rounded-lg text-sm bg-white focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500 @error('specialty') border-red-400 bg-red-50 @else border-slate-300 @enderror">
                        <option value="">— Để admin tư vấn —</option>
                        @php
                            $specialties = [
                                'Chỉnh nha','Cấy ghép Implant','Phục hình răng','Nội nha / Chữa tủy',
                                'Nha chu','Phẫu thuật miệng','Nha khoa trẻ em','Nha khoa thẩm mỹ','Nha khoa tổng quát',
                                'Khác (ghi rõ ở ghi chú)',
                            ];
                        @endphp
                        @foreach ($specialties as $sp)
                            <option value="{{ $sp }}" {{ old('specialty') === $sp ? 'selected' : '' }}>{{ $sp }}</option>
                        @endforeach
                    </select>
                </div>
                @error('specialty')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            {{-- === Ngày mong muốn === --}}
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">
                    Ngày mong muốn <span class="text-slate-400 font-normal text-xs">(không bắt buộc)</span>
                </label>
                <div class="relative">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 flex pointer-events-none">
                        <ion-icon name="calendar-outline" class="text-lg"></ion-icon>
                    </span>
                    <input type="date" name="preferred_date"
                           value="{{ old('preferred_date') }}"
                           min="{{ date('Y-m-d') }}"
                           class="w-full pl-10 pr-3 py-2.5 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500 @error('preferred_date') border-red-400 bg-red-50 @else border-slate-300 @enderror">
                </div>
                @error('preferred_date')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            {{-- === Ghi chú === --}}
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">
                    Ghi chú thêm <span class="text-slate-400 font-normal text-xs">(không bắt buộc)</span>
                </label>
                <textarea name="note" rows="3"
                          placeholder="Triệu chứng, bác sĩ cụ thể muốn gặp, yêu cầu đặc biệt..."
                          class="w-full px-3 py-2.5 border rounded-lg text-sm resize-y focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500 @error('note') border-red-400 bg-red-50 @else border-slate-300 @enderror">{{ old('note') }}</textarea>
                @error('note')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            {{-- === Đồng ý chính sách === --}}
            <label class="flex items-start gap-2.5 text-sm text-slate-600">
                <input type="checkbox" name="consent" value="1"
                       {{ old('consent') ? 'checked' : '' }}
                       required
                       class="mt-1 w-4 h-4 accent-sky-500 flex-shrink-0">
                <span>
                    Tôi đồng ý để cơ sở y tế liên hệ qua thông tin đã cung cấp và đồng ý với
                    <a href="#" class="text-sky-600 underline">chính sách bảo mật</a>.
                    <span class="text-red-500">*</span>
                </span>
            </label>
            @error('consent')<p class="text-red-500 text-xs">{{ $message }}</p>@enderror

            {{-- === Submit button — cùng gradient với button trang chủ === --}}
            <button type="submit"
                    class="w-full inline-flex items-center justify-center gap-2 px-6 py-3 rounded-full bg-gradient-to-r from-sky-500 to-cyan-500 text-white font-semibold shadow-md hover:shadow-lg hover:-translate-y-0.5 transition">
                Gửi yêu cầu đặt lịch
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                </svg>
            </button>

            <p class="text-center text-xs text-slate-500 flex items-center justify-center gap-1.5">
                <ion-icon name="time-outline"></ion-icon>
                Phản hồi trong 15–30 phút (giờ làm việc)
            </p>
        </form>
    </div>

    {{-- ===== LOGIN PROMPT ===== --}}
    <div class="text-center mt-6 text-sm text-slate-600">
        Bạn đã có tài khoản? <a href="/login" class="text-sky-600 font-semibold hover:underline">Đăng nhập tại đây</a>
    </div>
</div>

</body>
</html>
