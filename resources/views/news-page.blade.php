<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>News | MediConnect</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>
<body>
@include('components.header')
@include('components.auth-modal')

<main class="bg-slate-50 text-slate-800 antialiased overflow-x-hidden">
    {{-- 1. HERO  --}}
    <section class="bg-gradient-to-b from-sky-50 to-white pt-32 md:pt-36 pb-16 md:pb-20 w-full">
        <div class="max-w-4xl mx-auto px-6 lg:px-8
                flex flex-col items-center text-center w-full">
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-black text-slate-900
                   leading-tight tracking-tight mb-5">
                Chăm sóc răng miệng
                <span class="bg-gradient-to-r from-sky-500 to-cyan-500
                         bg-clip-text text-transparent">đúng cách</span>
            </h1>

            <p class="text-slate-500 text-base md:text-lg leading-relaxed max-w-2xl">
                Kiến thức nha khoa, tin tức mới nhất, ưu đãi và chia sẻ từ các bác sĩ chuyên gia MediConnect.
            </p>

            <div class="mt-8 w-full max-w-xl
                    bg-white rounded-3xl shadow-md p-2.5
                    flex items-center gap-3 border border-slate-200/80">
                <div class="text-slate-400 pl-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor"
                         stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/>
                    </svg>
                </div>
                <input type="text"
                       placeholder="Tìm bài viết, chủ đề..."
                       class="flex-1 outline-none text-slate-700 placeholder:text-slate-400
                          bg-transparent text-sm md:text-base">
                <button class="bg-gradient-to-r from-sky-500 to-cyan-500
                           hover:from-sky-600 hover:to-cyan-600
                           text-white font-semibold px-5 py-3 rounded-2xl
                           shadow-md hover:shadow-lg transition text-sm">
                    Tìm kiếm
                </button>
            </div>
        </div>
    </section>
    {{-- 2. DANH MỤC (filter pills)  --}}
    <section class="py-8 md:py-10 bg-white border-b border-slate-100">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">

            @php
                $categories = [
                    ['name' => 'Tất cả',              'count' => 48, 'active' => true],
                    ['name' => 'Kiến thức nha khoa',  'count' => 18],
                    ['name' => 'Tin tức MediConnect', 'count' => 9],
                    ['name' => 'Ưu đãi',              'count' => 6],
                    ['name' => 'Chuyên gia chia sẻ',  'count' => 10],
                    ['name' => 'Khách hàng',          'count' => 5],
                ];
            @endphp

            <div class="flex flex-wrap items-center justify-center gap-2 md:gap-3">
                @foreach ($categories as $c)
                    <button class="inline-flex items-center gap-2 px-4 md:px-5 py-2 md:py-2.5
                                   rounded-full text-sm font-semibold transition
                                   {{ ($c['active'] ?? false)
                                        ? 'bg-gradient-to-r from-sky-500 to-cyan-500 text-white shadow-md shadow-sky-500/30'
                                        : 'bg-slate-100 text-slate-600 hover:bg-sky-100 hover:text-sky-700' }}">
                        {{ $c['name'] }}
                        <span class="text-xs opacity-75">({{ $c['count'] }})</span>
                    </button>
                @endforeach
            </div>
        </div>
    </section>
    {{-- 3. BÀI VIẾT NỔI BẬT (1 to + 2 nho) --}}
    <section class="py-16 md:py-20 bg-slate-50">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">

            <div class="flex items-end justify-between mb-10">
                <div>
                    <h2 class="inline-block rounded-full bg-sky-100
                               px-5 md:px-8 py-2.5 md:py-3
                               text-xl md:text-2xl lg:text-3xl font-bold text-slate-800
                               leading-tight">
                        Bài viết <span class="text-sky-600">nổi bật</span>
                    </h2>
                </div>
                <a href="#" class="hidden md:inline-flex items-center gap-1 text-sky-600 text-sm font-semibold hover:gap-2 transition-all">
                    Xem tất cả
                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                         stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                    </svg>
                </a>
            </div>

            @php
                $featured = [
                    'image'    => 'blog1.png',
                    'category' => 'KIẾN THỨC',
                    'title'    => 'Hướng dẫn chăm sóc răng miệng sau khi trồng Implant',
                    'desc'     => 'Sau khi cấy ghép Implant, việc chăm sóc đúng cách trong 7 ngày đầu là rất quan trọng. Bài viết này sẽ hướng dẫn chi tiết từng bước để bảo vệ trụ Implant.',
                    'date'     => '21/05/2026',
                    'readtime' => '7 phút đọc',
                ];
                $highlights = [
                    ['image' => 'blog2.png', 'category' => 'TIN TỨC', 'title' => 'MediConnect khai trương chi nhánh thứ 10', 'date' => '18/05/2026', 'readtime' => '3 phút'],
                    ['image' => 'blog3.png', 'category' => 'ƯU ĐÃI',   'title' => 'Ưu đãi 30% cho dịch vụ niềng Invisalign trong tháng 6', 'date' => '15/05/2026', 'readtime' => '2 phút'],
                ];
            @endphp

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
                {{-- Bài viết nổi bật to --}}
                <a href="#" class="lg:col-span-7 group bg-white rounded-3xl overflow-hidden
                                   border border-slate-100 shadow-sm
                                   hover:shadow-2xl hover:-translate-y-1
                                   transition duration-300 flex flex-col">
                    <div class="relative h-64 md:h-80 lg:h-[420px] overflow-hidden">
                        <img src="{{ asset('img/' . $featured['image']) }}"
                             alt="{{ $featured['title'] }}"
                             class="w-full h-full object-cover
                                    group-hover:scale-105 transition duration-500">
                        <span class="absolute top-5 left-5
                                     bg-gradient-to-r from-sky-500 to-cyan-500
                                     text-white text-xs font-bold
                                     px-3 py-1.5 rounded-full shadow-md">
                            {{ $featured['category'] }}
                        </span>
                    </div>
                    <div class="p-6 md:p-8 flex flex-col flex-1">
                        <div class="flex items-center gap-4 text-xs text-slate-400 mb-3">
                            <span>📅 {{ $featured['date'] }}</span>
                            <span>⏱ {{ $featured['readtime'] }}</span>
                        </div>
                        <h3 class="text-xl md:text-2xl font-bold text-slate-800 mb-3
                                   group-hover:text-sky-600 transition leading-snug">
                            {{ $featured['title'] }}
                        </h3>
                        <p class="text-slate-500 leading-relaxed line-clamp-3">
                            {{ $featured['desc'] }}
                        </p>
                        <span class="inline-flex items-center gap-1 text-sky-600 font-semibold mt-4
                                     group-hover:gap-2 transition-all text-sm">
                            Đọc thêm
                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                 stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                            </svg>
                        </span>
                    </div>
                </a>

                {{-- 2 bài viết nhỏ --}}
                <div class="lg:col-span-5 flex flex-col gap-6">
                    @foreach ($highlights as $h)
                        <a href="#" class="group flex gap-4 bg-white rounded-2xl overflow-hidden
                                           border border-slate-100 shadow-sm
                                           hover:shadow-xl hover:border-sky-200 hover:-translate-y-0.5
                                           transition duration-300 flex-1">
                            <div class="relative w-32 sm:w-40 shrink-0 overflow-hidden">
                                <img src="{{ asset('img/' . $h['image']) }}"
                                     alt="{{ $h['title'] }}"
                                     class="w-full h-full object-cover
                                            group-hover:scale-110 transition duration-500">
                            </div>
                            <div class="flex-1 py-4 pr-4 min-w-0 flex flex-col justify-center">
                                <span class="text-[10px] font-bold text-sky-600 tracking-wider">
                                    {{ $h['category'] }}
                                </span>
                                <h3 class="font-bold text-slate-800 mt-1 mb-2
                                           group-hover:text-sky-600 transition
                                           line-clamp-2 leading-snug">
                                    {{ $h['title'] }}
                                </h3>
                                <div class="flex items-center gap-3 text-[10px] text-slate-400">
                                    <span>📅 {{ $h['date'] }}</span>
                                    <span>⏱ {{ $h['readtime'] }}</span>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    {{-- 4. TẤT CẢ BÀI VIẾT (grid 3x2)   --}}
    <section class="py-16 md:py-20 bg-white">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">

            <div class="flex flex-col items-center text-center mb-12">
                <h2 class="inline-block rounded-full bg-sky-100
                           px-6 md:px-10 py-3 md:py-4
                           text-2xl md:text-3xl lg:text-4xl font-bold text-slate-800
                           mb-4 leading-tight">
                    Bài viết <span class="text-sky-600">mới nhất</span>
                </h2>
                <p class="max-w-2xl mx-auto text-slate-500 text-base md:text-lg">
                    Cập nhật kiến thức và tin tức nha khoa hằng tuần.
                </p>
            </div>

            @php
                $articles = [
                    ['image' => 'blog4.png', 'category' => 'KIẾN THỨC', 'title' => 'Niềng răng Invisalign có thực sự hiệu quả?', 'desc' => 'Phân tích chi tiết về phương pháp niềng răng trong suốt.',     'date' => '20/05/2026', 'readtime' => '5 phút'],
                    ['image' => 'blog5.png', 'category' => 'KIẾN THỨC', 'title' => 'Tẩy trắng răng tại nhà: nên hay không?',     'desc' => 'Các phương pháp tẩy trắng răng tại nhà và rủi ro cần biết.',     'date' => '17/05/2026', 'readtime' => '4 phút'],
                    ['image' => 'blog6.png', 'category' => 'CHUYÊN GIA','title' => 'BS. Đào Hồng Luyến chia sẻ về Implant All-on-4', 'desc' => 'Phương pháp phục hình toàn hàm bằng 4 trụ Implant.',           'date' => '15/05/2026', 'readtime' => '6 phút'],
                    ['image' => 'blog7.png', 'category' => 'ƯU ĐÃI',    'title' => 'Khuyến mãi sinh nhật MediConnect 15 năm',     'desc' => 'Hàng loạt ưu đãi hấp dẫn nhân dịp kỷ niệm 15 năm.',             'date' => '12/05/2026', 'readtime' => '3 phút'],
                    ['image' => 'blog2.png', 'category' => 'KHÁCH HÀNG','title' => 'Hành trình lấy lại nụ cười của chị Mai 35 tuổi','desc' => 'Câu chuyện thật về quá trình điều trị tại MediConnect.',         'date' => '10/05/2026', 'readtime' => '5 phút'],
                    ['image' => 'blog3.png', 'category' => 'KIẾN THỨC', 'title' => 'Khi nào cần nhổ răng khôn?',                   'desc' => 'Dấu hiệu và thời điểm phù hợp để nhổ răng khôn.',                 'date' => '08/05/2026', 'readtime' => '4 phút'],
                ];
            @endphp

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
                @foreach ($articles as $a)
                    <a href="#" class="group bg-white rounded-2xl overflow-hidden
                                       border border-slate-100 shadow-sm
                                       hover:shadow-xl hover:-translate-y-1 hover:border-sky-200
                                       transition duration-300 flex flex-col">
                        <div class="relative h-48 overflow-hidden">
                            <img src="{{ asset('img/' . $a['image']) }}"
                                 alt="{{ $a['title'] }}"
                                 class="w-full h-full object-cover
                                        group-hover:scale-110 transition duration-500">
                            <span class="absolute top-3 left-3
                                         bg-white/95 backdrop-blur
                                         text-sky-600 text-[10px] font-bold tracking-wider
                                         px-2.5 py-1 rounded-full">
                                {{ $a['category'] }}
                            </span>
                        </div>
                        <div class="p-5 flex flex-col flex-1">
                            <div class="flex items-center gap-3 text-[11px] text-slate-400 mb-2">
                                <span>📅 {{ $a['date'] }}</span>
                                <span>⏱ {{ $a['readtime'] }}</span>
                            </div>
                            <h3 class="font-bold text-slate-800 mb-2 leading-snug
                                       group-hover:text-sky-600 transition
                                       line-clamp-2">
                                {{ $a['title'] }}
                            </h3>
                            <p class="text-sm text-slate-500 leading-relaxed line-clamp-2 mb-4 flex-1">
                                {{ $a['desc'] }}
                            </p>
                            <span class="inline-flex items-center gap-1 text-sky-600 text-sm font-semibold
                                         group-hover:gap-2 transition-all">
                                Đọc thêm
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                     stroke-width="2.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                </svg>
                            </span>
                        </div>
                    </a>
                @endforeach
            </div>

            {{-- Pagination --}}
            <div class="flex items-center justify-center gap-2 mt-12">
                <button class="w-10 h-10 rounded-full bg-slate-100 text-slate-400
                               hover:bg-sky-100 hover:text-sky-600 transition
                               flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                         stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                    </svg>
                </button>
                @foreach ([1, 2, 3, '...', 8] as $page)
                    <button class="min-w-[40px] h-10 rounded-full font-semibold text-sm transition
                                   {{ $page === 1
                                        ? 'bg-gradient-to-r from-sky-500 to-cyan-500 text-white shadow-md'
                                        : 'bg-slate-100 text-slate-600 hover:bg-sky-100 hover:text-sky-600' }}">
                        {{ $page }}
                    </button>
                @endforeach
                <button class="w-10 h-10 rounded-full bg-slate-100 text-slate-600
                               hover:bg-sky-100 hover:text-sky-600 transition
                               flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                         stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                    </svg>
                </button>
            </div>
        </div>
    </section>
</main>
@include('components.footer')
<script src="{{ asset('js/auth.js') }}" defer></script>
</body>
</html>
