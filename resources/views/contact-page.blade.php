<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact | MediConnect</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>
<body>
@include('components.header')
@include('components.auth-modal')

<main class="bg-slate-50 text-slate-800 antialiased overflow-x-hidden">

    {{-- 1. INFO + FORM --}}
    <section class="relative pt-32 md:pt-40 lg:pt-44 pb-20 md:pb-28 overflow-hidden">
        {{-- Background image --}}
        <div class="absolute inset-0 z-0">
            <img src="https://images.unsplash.com/photo-1629909613654-28e377c37b09?auto=format&fit=crop&w=1920&q=80"
                 alt="Contact MediConnect background"
                 class="w-full h-full object-cover">
            {{-- Overlay tối để text dễ đọc --}}
            <div class="absolute inset-0"
                 style="background: linear-gradient(to right, rgba(15,23,42,0.85) 0%, rgba(15,23,42,0.7) 50%, rgba(15,23,42,0.6) 100%);"></div>
        </div>

        {{-- Content --}}
        <div class="relative z-10 max-w-6xl mx-auto px-6 lg:px-8
                grid grid-cols-1 lg:grid-cols-2 gap-10 lg:gap-16 items-start">

            {{-- LEFT: Info --}}
            <div class="space-y-10">
                <div>
                    <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-white
                           tracking-tight mb-4 leading-tight"
                        style="font-family: 'Lora', serif;">
                        Liên hệ với
                        <span class="block mt-2 bg-gradient-to-r from-sky-300 to-cyan-300
                                 bg-clip-text text-transparent">
                        MediConnect
                    </span>
                    </h1>
                    <p class="text-slate-100 leading-relaxed max-w-md text-sm md:text-base">
                        Chúng tôi luôn sẵn sàng hỗ trợ, giải đáp thắc mắc và tư vấn lộ trình
                        chăm sóc răng miệng phù hợp nhất dành cho bạn.
                    </p>
                </div>

                {{-- Contact cards (dark theme với backdrop-blur) --}}
                <div style="display: flex; flex-direction: column; gap: 14px;">
                    <div class="group flex items-center gap-4
                            bg-white/15 backdrop-blur p-4 rounded-2xl
                            border border-white/30
                            hover:bg-white/25 hover:-translate-y-0.5
                            transition">
                        <div class="w-14 h-14 rounded-xl shrink-0
                                bg-gradient-to-br from-sky-500 to-cyan-500
                                text-white text-2xl
                                flex items-center justify-center
                                shadow-md shadow-sky-500/30">
                            📍
                        </div>
                        <div>
                            <h3 class="font-bold text-white text-sm md:text-base mb-0.5">
                                Địa chỉ
                            </h3>
                            <p class="text-slate-200 text-sm">
                                13 Phan Tây Nhạc, Xuân Phương, Hà Nội
                            </p>
                        </div>
                    </div>

                    <a href="tel:19001234"
                       class="group flex items-center gap-4
                          bg-white/15 backdrop-blur p-4 rounded-2xl
                          border border-white/30
                          hover:bg-white/25 hover:-translate-y-0.5
                          transition">
                        <div class="w-14 h-14 rounded-xl shrink-0
                                bg-gradient-to-br from-sky-500 to-cyan-500
                                text-white text-2xl
                                flex items-center justify-center
                                shadow-md shadow-sky-500/30">
                            📞
                        </div>
                        <div>
                            <h3 class="font-bold text-white text-sm md:text-base mb-0.5">
                                Hotline
                            </h3>
                            <p class="text-sky-300 text-base font-bold">1900 1234</p>
                        </div>
                    </a>

                    <a href="mailto:support@mediconnect.vn"
                       class="group flex items-center gap-4
                          bg-white/15 backdrop-blur p-4 rounded-2xl
                          border border-white/30
                          hover:bg-white/25 hover:-translate-y-0.5
                          transition">
                        <div class="w-14 h-14 rounded-xl shrink-0
                                bg-gradient-to-br from-sky-500 to-cyan-500
                                text-white text-2xl
                                flex items-center justify-center
                                shadow-md shadow-sky-500/30">
                            ✉️
                        </div>
                        <div>
                            <h3 class="font-bold text-white text-sm md:text-base mb-0.5">
                                Email
                            </h3>
                            <p class="text-slate-200 text-sm">support@mediconnect.vn</p>
                        </div>
                    </a>
                </div>
            </div>

            {{-- RIGHT: Form (vẫn white background, nổi bật trên dark BG) --}}
            <div class="bg-white rounded-3xl
            shadow-2xl shadow-sky-900/30
            border border-white/50 relative overflow-hidden"
                 style="padding: 40px 44px;">

                {{-- Decorative gradient blur top-right --}}
                <div class="absolute -top-12 -right-12 w-40 h-40
                bg-gradient-to-br from-sky-200 to-cyan-200
                rounded-full blur-3xl opacity-50"></div>

                <div class="relative z-10">
                    {{-- Header với icon --}}
                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-sky-500 to-cyan-500
                        flex items-center justify-center shrink-0
                        shadow-md shadow-sky-500/30">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                 stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/>
                            </svg>
                        </div>
                        <h2 class="text-2xl md:text-3xl font-bold text-slate-900 tracking-tight"
                            style="font-family: 'Lora', serif;">
                            Gửi yêu cầu tư vấn
                        </h2>
                    </div>
                    <p class="text-slate-500 text-sm mb-7">
                        Phản hồi miễn phí trong vòng <strong class="text-sky-600">30 phút</strong>.
                    </p>

                    <form style="display: flex; flex-direction: column; gap: 28px;">
                        {{-- Họ tên --}}
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                                👤 Họ và tên <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" placeholder="Nguyễn Văn A"
                                   class="w-full border border-slate-200 rounded-2xl
                                           text-base outline-none
                                           bg-slate-50/50 focus:bg-white
                                           focus:border-sky-500 focus:ring-4 focus:ring-sky-500/10
                                           transition"
                                   style="padding: 18px 22px;">
                        </div>

                        {{-- Số điện thoại --}}
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                                📞 Số điện thoại <span class="text-rose-500">*</span>
                            </label>
                            <input type="tel" placeholder="09xxxxxxxx"
                                   class="w-full border border-slate-200 rounded-2xl
                                           text-base outline-none
                                           bg-slate-50/50 focus:bg-white
                                           focus:border-sky-500 focus:ring-4 focus:ring-sky-500/10
                                           transition"
                                   style="padding: 18px 22px;">
                        </div>

                        {{-- Email --}}
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                                ✉️ Email
                            </label>
                            <input type="email" placeholder="name@email.com"
                                   class="w-full border border-slate-200 rounded-2xl
                                       text-base outline-none
                                       bg-slate-50/50 focus:bg-white
                                       focus:border-sky-500 focus:ring-4 focus:ring-sky-500/10
                                       transition"
                                   style="padding: 18px 22px;">
                        </div>
                        {{-- Dịch vụ quan tâm (MỚI) --}}
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                                🦷 Dịch vụ quan tâm
                            </label>
                            <select class="w-full border border-slate-200 rounded-2xl
                                       text-base outline-none
                                       bg-slate-50/50 focus:bg-white
                                       focus:border-sky-500 focus:ring-4 focus:ring-sky-500/10
                                       transition"
                                    style="padding: 18px 22px;">
                                <option value="">-- Chọn dịch vụ --</option>
                                <option value="implant">Trồng răng Implant</option>
                                <option value="invisalign">Niềng răng Invisalign</option>
                                <option value="braces">Niềng mắc cài</option>
                                <option value="veneer">Răng sứ thẩm mỹ</option>
                                <option value="cleaning">Lấy cao răng</option>
                                <option value="whitening">Tẩy trắng răng</option>
                                <option value="extraction">Nhổ răng khôn</option>
                                <option value="other">Khác / Tư vấn tổng quát</option>
                            </select>
                        </div>

                        {{-- Nội dung --}}
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                                💬 Nội dung
                            </label>
                            <textarea rows="4" placeholder="Mô tả tình trạng răng miệng hoặc câu hỏi của bạn..."
                                      class="w-full border border-slate-200 rounded-2xl
                                           text-base outline-none
                                           bg-slate-50/50 focus:bg-white
                                           focus:border-sky-500 focus:ring-4 focus:ring-sky-500/10
                                           transition"
                                      style="padding: 18px 22px;"></textarea>
                        </div>

                        {{-- Privacy checkbox (MỚI) --}}
                        <label class="flex items-start gap-3 cursor-pointer">
                            <input type="checkbox"
                                   class="mt-1 w-4 h-4 rounded text-sky-500
                              focus:ring-2 focus:ring-sky-500/30 cursor-pointer">
                            <span class="text-xs text-slate-500 leading-relaxed">
                    Tôi đồng ý với
                    <a href="#" class="text-sky-600 hover:underline font-semibold">chính sách bảo mật</a>
                    và cho phép MediConnect liên hệ qua điện thoại / email.
                </span>
                        </label>

                        {{-- Button với arrow animate --}}
                        <button type="submit"
                                class="w-full group inline-flex items-center justify-center gap-2
                           bg-gradient-to-r from-sky-500 to-cyan-500
                           hover:from-sky-600 hover:to-cyan-600
                           text-white font-bold py-4 rounded-full
                           shadow-lg shadow-sky-500/30 hover:shadow-xl hover:-translate-y-0.5
                           transition text-sm tracking-wide uppercase">
                            Gửi yêu cầu ngay
                            <svg class="w-4 h-4 group-hover:translate-x-1 transition" fill="none" stroke="currentColor"
                                 stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                            </svg>
                        </button>

                        {{-- Trust badge (MỚI) --}}
                        <p class="text-center text-xs text-slate-400">
                            🔒 Thông tin của bạn được bảo mật tuyệt đối
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </section>

    {{-- ============================================ --}}
    {{-- 2. GIỜ LÀM VIỆC + HỖ TRỢ KHẨN CẤP             --}}
    {{-- ============================================ --}}
    <section class="py-20 md:py-28 px-4 md:px-8 lg:px-16 bg-white">
        <div class="max-w-7xl mx-auto
                grid grid-cols-1 lg:grid-cols-2 gap-8">

            {{-- Hours card --}}
            <div class="bg-gradient-to-br from-slate-50 to-sky-50/50
                    rounded-3xl
                    border border-slate-100 flex flex-col
                    hover:shadow-xl hover:-translate-y-1 transition duration-300"
                 style="padding: 44px 48px;">
                <div>
                    <h2 class="text-2xl md:text-3xl lg:text-4xl font-bold text-slate-900
                           mb-8 tracking-tight leading-tight"
                        style="font-family: 'Lora', serif;">
                        Luôn sẵn sàng phục vụ bạn
                    </h2>
                </div>

                <div class="space-y-1 flex-1">
                    <div class="flex justify-between items-center py-4
                            border-b border-slate-200/70">
                    <span class="text-slate-700 font-medium text-base">
                        Thứ 2 - Thứ 6
                    </span>
                        <span class="font-bold text-sky-600 text-base">
                        08:00 - 20:00
                    </span>
                    </div>
                    <div class="flex justify-between items-center py-4
                            border-b border-slate-200/70">
                    <span class="text-slate-700 font-medium text-base">
                        Thứ 7
                    </span>
                        <span class="font-bold text-sky-600 text-base">
                        08:00 - 18:00
                    </span>
                    </div>
                    <div class="flex justify-between items-center py-4">
                    <span class="text-slate-700 font-medium text-base">
                        Chủ nhật
                    </span>
                        <span class="font-bold text-sky-600 text-base">
                        08:00 - 17:00
                    </span>
                    </div>
                </div>
            </div>

            {{-- Emergency card --}}
            <div class="relative bg-gradient-to-br from-sky-500 to-cyan-500
                    rounded-3xl text-white
                    overflow-hidden flex flex-col
                    hover:shadow-2xl hover:-translate-y-1 transition duration-300"
                 style="padding: 44px 48px;">
                {{-- Blur decorations --}}
                <div class="absolute -top-16 -right-16 w-48 h-48 rounded-full bg-white/10"></div>
                <div class="absolute -bottom-16 -left-16 w-48 h-48 rounded-full bg-white/10"></div>

                <div class="relative z-10 flex flex-col flex-1">
                    <h2 class="text-2xl md:text-3xl lg:text-4xl font-bold
                           mb-4 tracking-tight leading-tight"
                        style="font-family: 'Lora', serif;">
                        Cần hỗ trợ khẩn cấp?
                    </h2>
                    <p class="text-sky-50 leading-relaxed mb-8 text-base flex-1">
                        Đội ngũ MediConnect luôn sẵn sàng hỗ trợ nhanh chóng mọi vấn đề về
                        lịch hẹn, tư vấn điều trị hoặc chăm sóc sau điều trị.
                    </p>
                    <a href="tel:19006900"
                       class="inline-flex items-center justify-center gap-2
                          bg-white text-sky-600 font-bold
                          rounded-full
                          shadow-md hover:shadow-xl hover:scale-105
                          transition text-base
                          w-full md:w-auto self-start"
                       style="padding: 16px 32px;">
                        📞 Gọi ngay 1900 6900
                    </a>
                </div>
            </div>
        </div>
    </section>

</main>

@include('components.footer')
<script src="{{ asset('js/auth.js') }}" defer></script>
</body>
</html>
