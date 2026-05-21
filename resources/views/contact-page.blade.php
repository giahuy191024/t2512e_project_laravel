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

    {{-- ============================================ --}}
    {{-- 1. INFO + FORM                                --}}
    {{-- ============================================ --}}
    <section class="bg-gradient-to-b from-sky-50 to-white
                pt-32 md:pt-36 pb-16 md:pb-20
                px-4 md:px-8 lg:px-16">
        <div class="max-w-6xl mx-auto
                grid grid-cols-1 lg:grid-cols-2 gap-10 lg:gap-16 items-start">

            {{-- LEFT: Info --}}
            <div class="space-y-10">
                <div>
                <span class="inline-flex items-center gap-2 rounded-full
                             bg-sky-100 text-sky-700
                             px-4 py-1.5 text-xs font-bold tracking-wider uppercase mb-5">
                    <span class="w-2 h-2 rounded-full bg-sky-500"></span>
                    Liên hệ
                </span>
                    <h1 class="text-3xl md:text-4xl lg:text-5xl font-black text-slate-900
                           tracking-tight mb-4 leading-tight">
                        Liên hệ với
                        <span class="bg-gradient-to-r from-sky-500 to-cyan-500
                                 bg-clip-text text-transparent">MediConnect</span>
                    </h1>
                    <p class="text-slate-500 leading-relaxed max-w-md text-sm md:text-base">
                        Chúng tôi luôn sẵn sàng hỗ trợ, giải đáp thắc mắc và tư vấn lộ trình
                        chăm sóc răng miệng phù hợp nhất dành cho bạn.
                    </p>
                </div>

                {{-- Contact cards --}}
                <div class="space-y-4 grid gap-2">
                    <div class="group flex items-center gap-4 bg-white p-4 rounded-2xl
                            border border-slate-100 shadow-sm
                            hover:shadow-md hover:border-sky-200 hover:-translate-y-0.5
                            transition">
                        <div class="w-14 h-14 rounded-xl shrink-0
                                bg-gradient-to-br from-sky-500 to-cyan-500
                                text-white text-2xl
                                flex items-center justify-center
                                shadow-md shadow-sky-500/30">
                            📍
                        </div>
                        <div>
                            <h3 class="font-bold text-slate-800 text-sm md:text-base mb-0.5">
                                Địa chỉ
                            </h3>
                            <p class="text-slate-500 text-sm">
                                123 Trần Duy Hưng, Cầu Giấy, Hà Nội
                            </p>
                        </div>
                    </div>

                    <a href="tel:19001234"
                       class="group flex items-center gap-4 bg-white p-4 rounded-2xl
                          border border-slate-100 shadow-sm
                          hover:shadow-md hover:border-sky-200 hover:-translate-y-0.5
                          transition">
                        <div class="w-14 h-14 rounded-xl shrink-0
                                bg-gradient-to-br from-sky-500 to-cyan-500
                                text-white text-2xl
                                flex items-center justify-center
                                shadow-md shadow-sky-500/30">
                            📞
                        </div>
                        <div>
                            <h3 class="font-bold text-slate-800 text-sm md:text-base mb-0.5">
                                Hotline
                            </h3>
                            <p class="text-sky-600 text-base font-bold">1900 1234</p>
                        </div>
                    </a>

                    <a href="mailto:support@mediconnect.vn"
                       class="group flex items-center gap-4 bg-white p-4 rounded-2xl
                          border border-slate-100 shadow-sm
                          hover:shadow-md hover:border-sky-200 hover:-translate-y-0.5
                          transition">
                        <div class="w-14 h-14 rounded-xl shrink-0
                                bg-gradient-to-br from-sky-500 to-cyan-500
                                text-white text-2xl
                                flex items-center justify-center
                                shadow-md shadow-sky-500/30">
                            ✉️
                        </div>
                        <div>
                            <h3 class="font-bold text-slate-800 text-sm md:text-base mb-0.5">
                                Email
                            </h3>
                            <p class="text-slate-500 text-sm">support@mediconnect.vn</p>
                        </div>
                    </a>
                </div>
            </div>

            {{-- RIGHT: Form --}}
            <div class="bg-white rounded-3xl p-6 md:p-8
                    shadow-xl shadow-slate-200/50
                    border border-slate-100">
                <h2 class="text-2xl md:text-3xl font-black text-slate-900
                       mb-2 tracking-tight">
                    Gửi yêu cầu tư vấn
                </h2>
                <p class="text-slate-500 text-sm mb-6">
                    Để lại thông tin, chúng tôi sẽ liên hệ trong vòng 30 phút.
                </p>

                <form class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700
                                  uppercase tracking-wider mb-2">
                            Họ và tên
                        </label>
                        <input type="text" placeholder="Nguyễn Văn A"
                               class="w-full border border-slate-200 rounded-2xl
                                  px-4 py-3.5 text-sm outline-none
                                  bg-slate-50/50 focus:bg-white
                                  focus:border-sky-500 focus:ring-4 focus:ring-sky-500/10
                                  transition">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700
                                      uppercase tracking-wider mb-2">
                                Số điện thoại
                            </label>
                            <input type="tel" placeholder="09xxxxxxxx"
                                   class="w-full border border-slate-200 rounded-2xl
                                      px-4 py-3.5 text-sm outline-none
                                      bg-slate-50/50 focus:bg-white
                                      focus:border-sky-500 focus:ring-4 focus:ring-sky-500/10
                                      transition">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700
                                      uppercase tracking-wider mb-2">
                                Email
                            </label>
                            <input type="email" placeholder="name@email.com"
                                   class="w-full border border-slate-200 rounded-2xl
                                      px-4 py-3.5 text-sm outline-none
                                      bg-slate-50/50 focus:bg-white
                                      focus:border-sky-500 focus:ring-4 focus:ring-sky-500/10
                                      transition">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700
                                  uppercase tracking-wider mb-2">
                            Nội dung
                        </label>
                        <textarea rows="5" placeholder="Nội dung cần hỗ trợ..."
                                  class="w-full border border-slate-200 rounded-2xl
                                     px-4 py-3.5 text-sm resize-none outline-none
                                     bg-slate-50/50 focus:bg-white
                                     focus:border-sky-500 focus:ring-4 focus:ring-sky-500/10
                                     transition"></textarea>
                    </div>

                    <button type="submit"
                            class="w-full inline-flex items-center justify-center gap-2
                               bg-gradient-to-r from-sky-500 to-cyan-500
                               hover:from-sky-600 hover:to-cyan-600
                               text-white font-bold py-4 rounded-full
                               shadow-md hover:shadow-lg hover:-translate-y-0.5
                               transition text-sm tracking-wide uppercase">
                        Gửi thông tin
                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                             stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </section>

    {{-- ============================================ --}}
    {{-- 2. GIỜ LÀM VIỆC + HỖ TRỢ KHẨN CẤP             --}}
    {{-- ============================================ --}}
    <section class="py-16 md:py-20 px-4 md:px-8 lg:px-16 bg-white">
        <div class="max-w-7xl mx-auto
                grid grid-cols-1 lg:grid-cols-2 gap-6 lg:gap-8">

            {{-- Hours card --}}
            <div class="bg-gradient-to-br from-slate-50 to-sky-50/50
                    rounded-3xl p-8 md:p-10
                    border border-slate-100 flex flex-col">
                <div>
                <span class="inline-flex items-center gap-2 rounded-full
                             bg-sky-100 text-sky-700
                             px-4 py-1.5 text-xs font-bold tracking-wider uppercase mb-5">
                    <span class="w-2 h-2 rounded-full bg-sky-500"></span>
                    Giờ làm việc
                </span>
                    <h2 class="text-2xl md:text-3xl font-black text-slate-900
                           mb-6 md:mb-8 tracking-tight">
                        Luôn sẵn sàng phục vụ bạn
                    </h2>
                </div>

                <div class="space-y-1 flex-1">
                    <div class="flex justify-between items-center py-3.5
                            border-b border-slate-200/70">
                    <span class="text-slate-700 font-medium text-sm md:text-base">
                        Thứ 2 - Thứ 6
                    </span>
                        <span class="font-bold text-sky-600 text-sm md:text-base">
                        08:00 - 20:00
                    </span>
                    </div>
                    <div class="flex justify-between items-center py-3.5
                            border-b border-slate-200/70">
                    <span class="text-slate-700 font-medium text-sm md:text-base">
                        Thứ 7
                    </span>
                        <span class="font-bold text-sky-600 text-sm md:text-base">
                        08:00 - 18:00
                    </span>
                    </div>
                    <div class="flex justify-between items-center py-3.5">
                    <span class="text-slate-700 font-medium text-sm md:text-base">
                        Chủ nhật
                    </span>
                        <span class="font-bold text-sky-600 text-sm md:text-base">
                        08:00 - 17:00
                    </span>
                    </div>
                </div>
            </div>

            {{-- Emergency card --}}
            <div class="relative bg-gradient-to-br from-sky-500 to-cyan-500
                    rounded-3xl p-8 md:p-10 text-white
                    overflow-hidden flex flex-col">
                {{-- Blur decorations --}}
                <div class="absolute -top-16 -right-16 w-48 h-48 rounded-full bg-white/10"></div>
                <div class="absolute -bottom-16 -left-16 w-48 h-48 rounded-full bg-white/10"></div>

                <div class="relative z-10 flex flex-col flex-1">
                <span class="inline-flex items-center self-start gap-2
                             px-4 py-1.5 rounded-full bg-white/20 backdrop-blur
                             font-bold text-xs uppercase tracking-wider mb-5">
                    <span class="w-2 h-2 rounded-full bg-white animate-pulse"></span>
                    Hỗ trợ nhanh
                </span>
                    <h2 class="text-2xl md:text-3xl font-black mb-3 tracking-tight">
                        Cần hỗ trợ khẩn cấp?
                    </h2>
                    <p class="text-sky-50 leading-relaxed mb-6 text-sm md:text-base flex-1">
                        Đội ngũ MediConnect luôn sẵn sàng hỗ trợ nhanh chóng mọi vấn đề về
                        lịch hẹn, tư vấn điều trị hoặc chăm sóc sau điều trị.
                    </p>
                    <a href="tel:19006900"
                       class="inline-flex items-center justify-center gap-2
                          bg-white text-sky-600 font-bold
                          px-7 py-4 rounded-full
                          shadow-md hover:shadow-xl hover:scale-105
                          transition text-base
                          w-full md:w-auto self-start">
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
