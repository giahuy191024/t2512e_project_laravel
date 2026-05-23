<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>News | MediConnect</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lora:wght@400;500;700&display=swap" rel="stylesheet">
</head>
<body>
@include('components.header')
@include('components.auth-modal')

<main class="bg-slate-50 text-slate-800 antialiased overflow-x-hidden">
    {{-- 1. HERO --}}
    <section class="relative pt-32 md:pt-40 lg:pt-44 pb-20 md:pb-28 overflow-hidden">
        {{-- Background image --}}
        <div class="absolute inset-0 z-0">
            <img src="{{asset('img/section_hero.png')}}"
                 alt="MediConnect News background"
                 class="w-full h-full object-cover">
            {{-- Overlay tối để text dễ đọc --}}
            <div class="absolute inset-0"
                 style="background: linear-gradient(to bottom, rgba(15,23,42,0.7) 0%, rgba(15,23,42,0.85) 100%);"></div>
        </div>

        {{-- Content --}}
        <div class="relative z-10 max-w-4xl mx-auto px-6 lg:px-8
                flex flex-col items-center text-center w-full">
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold leading-tight tracking-tight text-white mb-5"
                style="font-family: 'Lora', serif;">
                Chăm sóc răng miệng
                <span class="block mt-2 bg-gradient-to-r from-sky-300 to-cyan-300
                         bg-clip-text text-transparent">
                đúng cách
            </span>
            </h1>

            <p class="text-slate-100 text-base md:text-lg leading-relaxed max-w-2xl">
                Kiến thức nha khoa, tin tức mới nhất, ưu đãi và chia sẻ từ các bác sĩ chuyên gia MediConnect.
            </p>

            {{-- Search bar --}}
            <div class="mt-10 w-full max-w-xl
                    bg-white rounded-3xl shadow-lg
                    flex items-center gap-3 border border-slate-200/80"
                 style="padding: 12px;">
                <div class="text-slate-400 pl-3">
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
                           text-white font-semibold rounded-2xl
                           shadow-md hover:shadow-lg transition whitespace-nowrap"
                        style="padding: 12px 24px;">
                    Tìm kiếm
                </button>
            </div>
        </div>
    </section>
    {{-- 3. BÀI VIẾT NỔI BẬT (1 to + 2 nho) --}}
    <section class="py-16 md:py-20 bg-slate-50">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">

            <div class="flex flex-col items-center text-center" style="margin-bottom: 56px;">
                <h2 class="inline-block rounded-full bg-sky-100
               text-xl md:text-2xl lg:text-3xl font-bold text-slate-800
               leading-tight"
                    style="padding: 18px 44px;">
                    Bài viết <span class="text-sky-600">nổi bật</span>
                </h2>
            </div>

            @php
                $featured = [
                    'image'    => 'https://images.unsplash.com/photo-1588776814546-1ffcf47267a5?auto=format&fit=crop&w=900&q=80',
                    'title'    => 'Chăm sóc và vệ sinh răng miệng hàng ngày',
                    'desc'     => 'Hướng dẫn chi tiết các biện pháp chăm sóc và vệ sinh răng miệng đúng cách, giúp duy trì hàm răng khỏe mạnh, hơi thở thơm tho mỗi ngày. Bài viết tổng hợp các thói quen vàng được bác sĩ khuyên dùng để bảo vệ răng và nướu lâu dài.',
                    'date'     => '21/05/2026',
                    'readtime' => '6 phút đọc',
                    'source'   => 'https://medlatec.vn/tin-tuc/nhung-bien-phap-cham-soc-va-ve-sinh-rang-mieng-hang-ngay-s99-n31619',
                ];
                $highlights = [
                    [
                        'image'    => 'https://images.unsplash.com/photo-1571772996211-2f02c9727629?auto=format&fit=crop&w=600&q=80',
                        'title'    => 'Niềng răng trong suốt Invisalign — và những điều cần biết',
                        'date'     => '18/05/2026',
                        'readtime' => '5 phút',
                        'source'   => 'https://www.vinmec.com/vie/bai-viet/nieng-rang-trong-suot-invisalign-va-nhung-dieu-can-biet-vi',
                    ],
                    [
                        'image'    => 'https://images.unsplash.com/photo-1606811971618-4486d14f3f99?auto=format&fit=crop&w=600&q=80',
                        'title'    => 'Lấy cao răng có cần thiết không và khi nào nên lấy?',
                        'date'     => '15/05/2026',
                        'readtime' => '4 phút',
                        'source'   => 'https://medlatec.vn/tin-tuc/lay-cao-rang-co-can-thiet-khong-va-khi-nao-nen-lay-s99-n27934',
                    ],
                ];
            @endphp
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
                {{-- Bài viết nổi bật to --}}
                <a href="{{ $featured['source'] }}" target="_blank" rel="noopener noreferrer"
                   class="lg:col-span-7 group bg-white rounded-3xl overflow-hidden
              border border-slate-100 shadow-sm
              hover:shadow-2xl hover:-translate-y-1
              transition duration-300 flex flex-col">
                    <div class="relative h-64 md:h-80 lg:h-[420px] overflow-hidden">
                        <img src="{{ $featured['image'] }}"
                             alt="{{ $featured['title'] }}"
                             class="w-full h-full object-cover
                        group-hover:scale-105 transition duration-500">
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
                    </div>
                </a>

                {{-- 2 bài viết nhỏ --}}
                <div class="lg:col-span-5 flex flex-col gap-6">
                    @foreach ($highlights as $h)
                        <a href="{{ $h['source'] }}" target="_blank" rel="noopener noreferrer"
                           class="group flex gap-4 bg-white rounded-2xl overflow-hidden
                      border border-slate-100 shadow-sm
                      hover:shadow-xl hover:border-sky-200 hover:-translate-y-0.5
                      transition duration-300 flex-1">
                            <div class="relative w-32 sm:w-40 shrink-0 overflow-hidden">
                                <img src="{{ $h['image'] }}"
                                     alt="{{ $h['title'] }}"
                                     class="w-full h-full object-cover
                                group-hover:scale-110 transition duration-500">
                            </div>
                            <div class="flex-1 py-4 pr-4 min-w-0 flex flex-col justify-center">
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
                <h2 class="inline-block w-90 rounded-full bg-sky-100
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
                    [
                        'image'    => 'https://cdn.nhathuoclongchau.com.vn/v1/static/cach_ve_sinh_ham_duy_tri_trong_suot_dung_chuan_ban_nen_biet4_60d2702393.jpg',
                        'title'    => 'Cách vệ sinh hàm duy trì bằng nhựa trong suốt không bị ố vàng',
                        'desc'     => 'Bí quyết vệ sinh hàm duy trì bằng nhựa trong suốt giúp giữ độ trong, tránh ố vàng và kéo dài tuổi thọ.',
                        'date'     => '12/05/2026',
                        'readtime' => '4 phút',
                        'source'   => 'https://nhakhoabaoviet.com/ve-sinh-ham-duy-tri-bang-nhua-trong-suot/',
                    ],
                    [
                        'image'    => 'https://images.unsplash.com/photo-1609840114035-3c981b782dfe?auto=format&fit=crop&w=600&q=80',
                        'title'    => 'So sánh hàm duy trì cố định và tháo lắp: Loại nào tốt hơn?',
                        'desc'     => 'Phân tích ưu nhược điểm của hàm duy trì cố định và tháo lắp — loại nào phù hợp với bạn sau niềng răng?',
                        'date'     => '10/05/2026',
                        'readtime' => '5 phút',
                        'source'   => 'https://nhakhoabaoviet.com/so-sanh-ham-duy-tri-co-dinh-va-thao-lap/',
                    ],
                    [
                        'image'    => 'https://niengrangtot.com/wp-content/uploads/2022/03/nieng-rang-xong-co-nen-tay-trang-rang-1.jpg',
                        'title'    => 'Sau niềng răng có nên tẩy trắng răng không?',
                        'desc'     => 'Thời điểm thích hợp để tẩy trắng răng sau khi tháo niềng và các phương pháp an toàn được bác sĩ khuyên dùng.',
                        'date'     => '08/05/2026',
                        'readtime' => '4 phút',
                        'source'   => 'https://nhakhoabaoviet.com/sau-nieng-rang-nen-tay-trang-rang-ngay-khong/',
                    ],
                    [
                        'image'    => 'https://nhakhoabaoviet.com/wp-content/uploads/2026/05/Nha-khoa-Bao-Viet-3-7.jpg',
                        'title'    => '5 lý do quan trọng khi đã tháo niềng răng vẫn phải tái khám',
                        'desc'     => 'Vì sao sau khi tháo niềng vẫn cần tái khám định kỳ? 5 lý do quan trọng giúp duy trì kết quả chỉnh nha lâu dài.',
                        'date'     => '05/05/2026',
                        'readtime' => '5 phút',
                        'source'   => 'https://nhakhoabaoviet.com/5-ly-do-da-thao-nieng-rang-van-phai-tai-kham/',
                    ],
                    [
                        'image'    => 'https://cdn.nhathuoclongchau.com.vn/unsafe/800x0/bung_mac_cai_nieng_rang_nguyen_nhan_va_cach_xu_ly_1_d04f65220e.jpg',
                        'title'    => 'Bung mắc cài niềng răng do đâu?',
                        'desc'     => 'Phân tích 5 nguyên nhân thường gặp khiến mắc cài bị bung khi niềng răng và cách xử lý đúng cách.',
                        'date'     => '03/05/2026',
                        'readtime' => '4 phút',
                        'source'   => 'https://nhakhoabaoviet.com/5-ly-do-bung-mac-cai-khi-nieng-rang/',
                    ],
                    [
                        'image'    => 'https://nhakhoatoancau.vn/wp-content/uploads/2025/04/nhung-sai-lam-khi-nieng-rang-1.jpg',
                        'title'    => 'Sai lầm phổ biến khi niềng răng khiến bạn mất thời gian và tiền bạc',
                        'desc'     => 'Tổng hợp những sai lầm phổ biến nhất trong quá trình niềng răng và cách tránh để tiết kiệm chi phí, thời gian.',
                        'date'     => '01/05/2026',
                        'readtime' => '5 phút',
                        'source'   => 'https://nhakhoabaoviet.com/sai-lam-pho-bien-khi-nieng-rang/',
                    ],
                ];
            @endphp

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
                @foreach ($articles as $a)
                    <a href="{{ $a['source'] }}" target="_blank" rel="noopener noreferrer"
                       class="group bg-white rounded-2xl overflow-hidden
                                       border border-slate-100 shadow-sm
                                       hover:shadow-xl hover:-translate-y-1 hover:border-sky-200
                                       transition duration-300 flex flex-col">
                        <div class="relative h-48 overflow-hidden">
                            <img src="{{ $a['image'] }}"
                                 alt="{{ $a['title'] }}"
                                 class="w-full h-full object-cover
                                        group-hover:scale-110 transition duration-500">
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
