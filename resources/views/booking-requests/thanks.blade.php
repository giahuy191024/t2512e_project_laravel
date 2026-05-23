<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đã ghi nhận yêu cầu — Cảm ơn bạn!</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</head>
<body class="min-h-screen bg-gradient-to-br from-sky-50 via-white to-cyan-50 flex items-center justify-center py-10 px-4">

<div class="max-w-lg w-full">
    <div class="bg-white rounded-2xl shadow-md p-8 sm:p-10 text-center">

        {{-- Success icon --}}
        <div class="w-20 h-20 mx-auto mb-5 rounded-full bg-gradient-to-br from-sky-100 to-cyan-100 flex items-center justify-center text-sky-600">
            <ion-icon name="checkmark-outline" class="text-5xl"></ion-icon>
        </div>

        <h1 class="text-2xl sm:text-3xl font-bold text-slate-800 mb-2">
            Đã ghi nhận yêu cầu của bạn!
        </h1>

        <p class="text-slate-600 text-sm leading-relaxed mb-6">
            @if ($info && !empty($info['full_name']))
                Cảm ơn <strong class="text-slate-800">{{ $info['full_name'] }}</strong>.
                Chúng tôi sẽ liên hệ qua số
                <strong class="text-slate-800">{{ $info['phone_number'] }}</strong>
                trong thời gian sớm nhất để xác nhận lịch hẹn.
            @else
                Cảm ơn bạn đã đặt lịch. Chúng tôi sẽ liên hệ trong thời gian sớm nhất.
            @endif
        </p>

        {{-- Booking code --}}
        <div class="bg-gradient-to-br from-sky-50 to-cyan-50 border border-dashed border-sky-300 rounded-xl p-4 mb-6">
            <div class="text-xs text-slate-500 uppercase tracking-widest mb-1">Mã yêu cầu của bạn</div>
            <div class="text-2xl sm:text-3xl font-bold text-sky-600 font-mono tracking-wider">
                {{ $code }}
            </div>
        </div>

        {{-- Info list --}}
        <ul class="text-left bg-slate-50 rounded-xl p-4 mb-6 text-sm text-slate-600 space-y-2">
            <li class="flex items-start gap-2.5">
                <ion-icon name="time-outline" class="text-sky-500 text-base flex-shrink-0 mt-0.5"></ion-icon>
                <span>Phản hồi <strong class="text-slate-800">trong 15–30 phút</strong> (giờ làm việc).</span>
            </li>
            <li class="flex items-start gap-2.5">
                <ion-icon name="bookmark-outline" class="text-sky-500 text-base flex-shrink-0 mt-0.5"></ion-icon>
                <span><strong class="text-slate-800">Lưu lại mã trên</strong> để tiện tra cứu khi cần.</span>
            </li>
            <li class="flex items-start gap-2.5">
                <ion-icon name="call-outline" class="text-sky-500 text-base flex-shrink-0 mt-0.5"></ion-icon>
                <span>Cần gấp? Gọi tổng đài: <strong class="text-slate-800">1900 xxxx</strong></span>
            </li>
        </ul>

        {{-- Actions --}}
        <div class="flex flex-col sm:flex-row gap-3 justify-center">
            <a href="{{ route('booking-requests.create') }}"
               class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-full border border-sky-500 text-sky-600 font-semibold hover:bg-sky-50 transition">
                Gửi yêu cầu khác
            </a>
            <a href="/"
               class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-full bg-gradient-to-r from-sky-500 to-cyan-500 text-white font-semibold shadow-md hover:shadow-lg hover:-translate-y-0.5 transition">
                Về trang chủ
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                </svg>
            </a>
        </div>
    </div>
</div>

</body>
</html>
