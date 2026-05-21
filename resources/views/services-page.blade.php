<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Services | MediConnect</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>
<body>
@include('components.header')
@include('components.auth-modal')

<main class="bg-slate-50 text-slate-800 antialiased overflow-x-hidden">
    {{-- 1. HERO    --}}
    <section class="bg-gradient-to-b from-sky-50 to-white pt-32 md:pt-36 pb-20 md:pb-24">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-0 items-center max-w-[1400px] mx-auto">

            <div class="lg:col-span-7 space-y-8 pl-4 md:pl-8 lg:pl-16 pr-4 md:pr-12">
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-black text-slate-900
                           leading-tight tracking-tight">
                    Dịch vụ nha khoa
                    <span class="bg-gradient-to-r from-sky-500 to-cyan-500
                                 bg-clip-text text-transparent">toàn diện</span>
                    dành riêng cho bạn
                </h1>

                <p class="text-slate-500 text-base md:text-lg leading-relaxed max-w-2xl">
                    Từ Implant, chỉnh nha Invisalign, phục hình thẩm mỹ đến điều trị tổng quát —
                    MediConnect mang đến giải pháp cá nhân hóa phù hợp với từng tình trạng răng miệng.
                </p>

                {{-- Search bar --}}
                <div class="bg-white rounded-3xl shadow-md p-2.5
                            flex items-center gap-3 border border-slate-200/80 max-w-2xl">
                    <div class="text-xl px-2 text-slate-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor"
                             stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/>
                        </svg>
                    </div>
                    <input type="text"
                           placeholder="Tìm dịch vụ như Implant, Invisalign..."
                           class="flex-1 outline-none text-slate-700 placeholder:text-slate-400
                                  bg-transparent text-sm md:text-base">
                    <button class="bg-gradient-to-r from-sky-500 to-cyan-500
                                   hover:from-sky-600 hover:to-cyan-600
                                   text-white font-semibold px-5 py-3 w-20 rounded-xl
                                   shadow-md hover:shadow-lg
                                   transition text-sm md:text-base whitespace-nowrap">
                        Tìm kiếm
                    </button>
                </div>

                {{-- Filter tags --}}
                <div class="flex flex-wrap gap-2.5">
                    @foreach (['Implant', 'Invisalign', 'Răng sứ', 'Tẩy trắng', 'Niềng mắc cài'] as $tag)
                        <span class="px-4 py-2 rounded-full bg-white shadow-sm
                                     border border-slate-100 text-slate-600
                                     text-xs md:text-sm font-medium
                                     hover:border-sky-500 hover:text-sky-600
                                     transition cursor-pointer">
                            {{ $tag }}
                        </span>
                    @endforeach
                </div>
            </div>

            <div class="lg:col-span-5 w-full h-full min-h-[400px] lg:min-h-[500px] relative">
                {{-- Blur decoration --}}
                <div class="absolute -top-12 -right-12 w-80 h-80 bg-sky-300
                            rounded-full blur-3xl opacity-20 pointer-events-none"></div>

                <div class="w-full h-full relative overflow-hidden
                            rounded-sm lg:rounded
                            shadow-xl bg-slate-100">
                    <img src="{{ asset('img/service1.png') }}"
                         alt="MediConnect Services"
                         class="w-full h-full object-cover
                                hover:scale-105 transition duration-700">
                </div>
            </div>
        </div>
    </section>
    {{-- 2. DANH MỤC DỊCH VỤ    --}}
    <section class="py-20 md:py-24 bg-white">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">

            <div class="flex flex-col items-center text-center mb-14">
                <h2 class="inline-block rounded-full bg-sky-100
                           px-6 md:px-10 py-3 md:py-4
                           text-2xl md:text-3xl lg:text-4xl font-bold text-slate-800
                           mb-5 leading-tight">
                    Danh mục <span class="text-sky-600">dịch vụ</span>
                </h2>
                <p class="max-w-2xl mx-auto text-slate-500 text-base md:text-lg">
                    6 lĩnh vực chuyên môn, đáp ứng mọi nhu cầu chăm sóc răng miệng.
                </p>
            </div>

            @php
                $categories = [
                    ['icon' => '🦷', 'name' => 'Trồng răng Implant',  'count' => '5 dịch vụ', 'color' => 'sky'],
                    ['icon' => '😁', 'name' => 'Chỉnh nha / Niềng',   'count' => '4 dịch vụ', 'color' => 'cyan'],
                    ['icon' => '✨', 'name' => 'Thẩm mỹ nha khoa',    'count' => '6 dịch vụ', 'color' => 'amber'],
                    ['icon' => '🩺', 'name' => 'Điều trị tổng quát',  'count' => '8 dịch vụ', 'color' => 'emerald'],
                    ['icon' => '👶', 'name' => 'Nha khoa trẻ em',     'count' => '3 dịch vụ', 'color' => 'pink'],
                    ['icon' => '🚨', 'name' => 'Cấp cứu nha khoa',    'count' => '24/7',      'color' => 'red'],
                ];
            @endphp

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4 md:gap-6">
                @foreach ($categories as $c)
                    <a href="#" class="group bg-white rounded-2xl p-5 md:p-6 text-center
                                       border border-slate-100 shadow-sm
                                       hover:shadow-xl hover:-translate-y-1
                                       hover:border-sky-200
                                       transition duration-300 block">
                        <div class="text-4xl md:text-5xl mb-3
                                    group-hover:scale-110 transition duration-300">
                            {{ $c['icon'] }}
                        </div>
                        <h3 class="font-bold text-slate-800 text-sm md:text-base mb-1">
                            {{ $c['name'] }}
                        </h3>
                        <p class="text-xs text-sky-600 font-semibold">{{ $c['count'] }}</p>
                    </a>
                @endforeach
            </div>
        </div>
    </section>
    {{-- ============================================ --}}
    {{-- DỊCH VỤ NỔI BẬT - layout horizontal 2 cột --}}
    {{-- ============================================ --}}
    <section class="py-20 md:py-24 bg-slate-100">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">

            <div class="flex flex-col items-center text-center mb-14">
                <h2 class="inline-block rounded-full bg-sky-100
                       px-6 md:px-10 py-3 md:py-4
                       text-2xl md:text-3xl lg:text-4xl font-bold text-slate-800
                       mb-5 leading-tight">
                    Dịch vụ <span class="text-sky-600">nổi bật</span>
                </h2>
                <p class="max-w-2xl mx-auto text-slate-500 text-base md:text-lg">
                    Những dịch vụ được khách hàng tin tưởng và lựa chọn nhiều nhất.
                </p>
            </div>

            @php
                $popular = [
                    ['badge' => 'Bán chạy',   'category' => 'PHỤC HÌNH RĂNG', 'title' => 'Trồng răng Implant',       'desc' => 'Phục hồi răng mất bằng trụ titanium chuẩn quốc tế, độ bền 25+ năm.', 'image' => 'service2.png', 'price' => 'Từ 15.000.000 đ'],
                    ['badge' => 'Khuyến nghị','category' => 'CHỈNH NHA',     'title' => 'Niềng răng Invisalign',    'desc' => 'Khay niềng trong suốt, thẩm mỹ cao, tháo lắp dễ dàng.',              'image' => 'service3.png', 'price' => 'Từ 50.000.000 đ'],
                    ['badge' => null,         'category' => 'CHỈNH NHA',     'title' => 'Niềng mắc cài tiết kiệm',  'desc' => 'Giải pháp chỉnh nha hiệu quả với chi phí hợp lý.',                    'image' => 'service4.png', 'price' => 'Từ 20.000.000 đ'],
                    ['badge' => 'Mới',        'category' => 'THẨM MỸ',       'title' => 'Răng sứ thẩm mỹ',          'desc' => 'Mang lại nụ cười trắng sáng tự nhiên, độ bền 10-15 năm.',             'image' => 'service9.png', 'price' => 'Từ 3.000.000 đ'],
                    ['badge' => null,         'category' => 'CHĂM SÓC',      'title' => 'Lấy cao răng',             'desc' => 'Loại bỏ mảng bám, giúp răng sạch sẽ và khỏe mạnh.',                   'image' => 'service6.png', 'price' => 'Từ 300.000 đ'],
                    ['badge' => null,         'category' => 'TIỂU PHẪU',     'title' => 'Nhổ răng khôn',            'desc' => 'Loại bỏ răng khôn mọc lệch, an toàn với công nghệ hiện đại.',         'image' => 'service8.png', 'price' => 'Từ 1.500.000 đ'],
                ];
                // Chia 6 dịch vụ thành 2 cột, mỗi cột 3
                $columns = array_chunk($popular, 3);
            @endphp

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 lg:gap-8">
                @foreach ($columns as $col)
                    <div class="flex flex-col gap-6 md:gap-8">
                        @foreach ($col as $p)
                            <a href="#"
                               class="group flex gap-4 bg-white rounded-2xl overflow-hidden
                                  border border-slate-100 shadow-sm
                                  hover:shadow-xl hover:border-sky-200 hover:-translate-y-0.5
                                  transition duration-300">

                                {{-- Ảnh bên trái --}}
                                <div class="relative w-32 sm:w-40 shrink-0 overflow-hidden">
                                    <img src="{{ asset('img/' . $p['image']) }}"
                                         alt="{{ $p['title'] }}"
                                         class="w-full h-full object-cover
                                            group-hover:scale-110 transition duration-500">

                                    @if ($p['badge'])
                                        <span class="absolute top-2 left-2
                                                 bg-gradient-to-r from-amber-400 to-orange-500
                                                 text-white text-[10px] font-bold
                                                 px-2 py-0.5 rounded-full shadow">
                                        {{ $p['badge'] }}
                                    </span>
                                    @endif
                                </div>

                                {{-- Content bên phải --}}
                                <div class="flex-1 py-4 pr-4 min-w-0 flex flex-col justify-between">
                                    <div>
                                    <span class="text-[10px] font-bold text-sky-600 tracking-wider uppercase">
                                        {{ $p['category'] }}
                                    </span>
                                        <h3 class="font-bold text-base text-slate-800 mt-1 mb-1.5
                                               group-hover:text-sky-600 transition
                                               line-clamp-1">
                                            {{ $p['title'] }}
                                        </h3>
                                        <p class="text-xs text-slate-500 leading-relaxed line-clamp-2">
                                            {{ $p['desc'] }}
                                        </p>
                                    </div>

                                    <div class="flex items-center justify-between mt-3
                                            pt-3 border-t border-slate-100">
                                        <div>
                                            <div class="text-[9px] text-slate-400 uppercase tracking-wider">
                                                Giá từ
                                            </div>
                                            <div class="font-bold text-sky-600 text-sm whitespace-nowrap">
                                                {{ $p['price'] }}
                                            </div>
                                        </div>
                                        <span class="inline-flex items-center gap-1
                                                 text-sky-600 text-xs font-semibold
                                                 group-hover:gap-2 transition-all">
                                        Xem chi tiết
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor"
                                             stroke-width="2.5" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                        </svg>
                                    </span>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{--  QUY TRÌNH ĐIỀU TRỊ  --}}
    <section class="py-20 md:py-24 bg-white">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">

            <div class="flex flex-col items-center text-center mb-16">
                <h2 class="inline-block rounded-full bg-sky-100
                           px-6 md:px-10 py-3 md:py-4
                           text-2xl md:text-3xl lg:text-4xl font-bold text-slate-800
                           mb-5 leading-tight">
                    Quy trình <span class="text-sky-600">điều trị</span>
                </h2>
                <p class="max-w-2xl mx-auto text-slate-500 text-base md:text-lg">
                    5 bước rõ ràng, minh bạch để bạn yên tâm trong suốt hành trình.
                </p>
            </div>

            <div class="relative">
                <div class="hidden lg:block absolute top-12 left-[10%] right-[10%]
                            border-t-2 border-dashed border-sky-300"></div>

                @php
                    $steps = [
                        ['title' => 'Tư vấn ban đầu',  'desc' => 'Bác sĩ thăm khám, lắng nghe nhu cầu của bạn.'],
                        ['title' => 'Chụp X-quang',    'desc' => 'Phân tích chi tiết tình trạng răng và xương hàm.'],
                        ['title' => 'Lên phác đồ',     'desc' => 'Xây dựng kế hoạch điều trị và báo giá rõ ràng.'],
                        ['title' => 'Tiến hành',       'desc' => 'Thực hiện điều trị bằng công nghệ hiện đại.'],
                        ['title' => 'Theo dõi sau',    'desc' => 'Tái khám miễn phí, hỗ trợ 24/7.'],
                    ];
                @endphp

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-6">
                    @foreach ($steps as $i => $s)
                        <div class="text-center group">
                            <div class="relative mx-auto mb-5 w-24 h-24 rounded-full
                                        bg-gradient-to-br from-sky-500 to-cyan-500
                                        shadow-lg shadow-sky-500/30
                                        flex items-center justify-center z-10
                                        ring-4 ring-white
                                        group-hover:scale-110 group-hover:rotate-6
                                        transition-all duration-300">
                                <span class="text-white text-3xl font-bold">
                                    0{{ $i + 1 }}
                                </span>
                            </div>
                            <div class="bg-white rounded-2xl p-5 border border-slate-100
                                        shadow-sm group-hover:shadow-xl group-hover:border-sky-200
                                        group-hover:-translate-y-1 transition duration-300">
                                <h3 class="font-bold text-slate-800 mb-2">{{ $s['title'] }}</h3>
                                <p class="text-sm text-slate-500 leading-relaxed">
                                    {{ $s['desc'] }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    {{-- BẢO HÀNH & CAM KẾT  --}}
    <section class="py-20 md:py-24 bg-white">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">

            <div class="flex flex-col items-center text-center mb-14">
                <h2 class="inline-block rounded-full bg-sky-100
                           px-6 md:px-10 py-3 md:py-4
                           text-2xl md:text-3xl lg:text-4xl font-bold text-slate-800
                           mb-5 leading-tight">
                    Bảo hành &amp; <span class="text-sky-600">cam kết</span>
                </h2>
                <p class="max-w-2xl mx-auto text-slate-500 text-base md:text-lg">
                    Mỗi dịch vụ tại MediConnect đều được bảo hành bằng văn bản.
                </p>
            </div>

            @php
                $warranties = [
                    ['icon' => '🛡️', 'value' => '25 năm', 'label' => 'Bảo hành Implant', 'desc' => 'Trụ Implant Straumann chính hãng từ Thụy Sĩ.'],
                    ['icon' => '✨', 'value' => '15 năm', 'label' => 'Bảo hành răng sứ', 'desc' => 'Răng sứ thẩm mỹ cao cấp, không xỉn màu.'],
                    ['icon' => '🦷', 'value' => '5 năm',  'label' => 'Bảo hành niềng',   'desc' => 'Cam kết kết quả sau quá trình điều trị.'],
                    ['icon' => '♾️', 'value' => 'Trọn đời','label' => 'Tái khám miễn phí','desc' => 'Theo dõi sức khỏe răng miệng định kỳ.'],
                ];
            @endphp

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach ($warranties as $w)
                    <div class="group relative bg-gradient-to-br from-white to-sky-50/50
                                rounded-2xl p-6 text-center
                                border border-slate-100
                                hover:shadow-xl hover:border-sky-200
                                transition duration-300">
                        <div class="text-4xl mb-3
                                    group-hover:scale-110 transition duration-300">
                            {{ $w['icon'] }}
                        </div>
                        <div class="text-2xl md:text-3xl font-black
                                    bg-gradient-to-br from-sky-500 to-cyan-600
                                    bg-clip-text text-transparent">
                            {{ $w['value'] }}
                        </div>
                        <h3 class="font-bold text-slate-800 mt-1 mb-2">{{ $w['label'] }}</h3>
                        <p class="text-xs text-slate-500 leading-relaxed">{{ $w['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    {{-- FAQ --}}
    <section class="py-20 md:py-24 bg-white">
        <div class="max-w-3xl mx-auto px-6">

            <div class="flex flex-col items-center text-center mb-14">
                <h2 class="inline-block rounded-full bg-sky-100
                           px-6 md:px-10 py-3 md:py-4
                           text-2xl md:text-3xl lg:text-4xl font-bold text-slate-800
                           mb-5 leading-tight">
                    Câu hỏi <span class="text-sky-600">thường gặp</span>
                </h2>
                <p class="text-slate-500 text-base md:text-lg">
                    Giải đáp các thắc mắc phổ biến của khách hàng.
                </p>
            </div>

            @php
                $faqs = [
                    ['q' => 'Niềng Invisalign mất bao lâu?', 'a' => 'Thời gian niềng Invisalign trung bình từ 12-24 tháng tùy mức độ lệch lạc của răng. Bác sĩ sẽ đánh giá cụ thể trong buổi tư vấn đầu tiên và đưa ra mốc thời gian chính xác cho từng trường hợp.'],
                    ['q' => 'Trồng Implant có đau không?', 'a' => 'Quy trình cấy ghép Implant được thực hiện dưới gây tê tại chỗ nên khách hàng hoàn toàn không cảm thấy đau trong lúc làm. Sau khi hết thuốc tê, có thể có cảm giác hơi ê nhẹ trong 1-2 ngày đầu, dễ kiểm soát bằng thuốc giảm đau thông thường.'],
                    ['q' => 'Tôi có thể trả góp dịch vụ không?', 'a' => 'MediConnect liên kết với các ngân hàng và công ty tài chính uy tín, hỗ trợ trả góp 0% lãi suất từ 3-12 tháng cho các dịch vụ trên 10 triệu đồng. Vui lòng liên hệ trực tiếp với nhân viên tư vấn để biết thêm chi tiết.'],
                    ['q' => 'Răng sứ thẩm mỹ có bền không?', 'a' => 'Răng sứ thẩm mỹ tại MediConnect có tuổi thọ trung bình 10-15 năm, một số loại sứ cao cấp có thể đạt 20 năm nếu được chăm sóc đúng cách. Chúng tôi bảo hành chính thức 15 năm bằng văn bản.'],
                    ['q' => 'Có cần đặt lịch trước không?', 'a' => 'Có. Vì các bác sĩ thường có lịch khám kín, bạn nên đặt lịch trước qua website, hotline 1900 6900 hoặc app MediConnect ít nhất 1-2 ngày để được phục vụ tốt nhất. Trường hợp khẩn cấp, vui lòng gọi hotline để được hỗ trợ ngay.'],
                ];
            @endphp

            <div class="space-y-3">
                @foreach ($faqs as $faq)
                    <details class="group bg-white rounded-2xl border border-slate-100
                                    overflow-hidden hover:border-sky-200 transition">
                        <summary class="flex items-center justify-between cursor-pointer
                                        p-5 md:p-6 font-semibold text-slate-800
                                        list-none [&::-webkit-details-marker]:hidden">
                            <span class="flex-1 pr-4">{{ $faq['q'] }}</span>
                            <span class="w-8 h-8 shrink-0 rounded-full bg-sky-100 text-sky-600
                                         flex items-center justify-center transition
                                         group-open:rotate-180 group-open:bg-sky-500 group-open:text-white">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                     stroke-width="2.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M19.5 8.25l-7.5 7.5-7.5-7.5"/>
                                </svg>
                            </span>
                        </summary>
                        <div class="px-5 md:px-6 pb-5 md:pb-6 text-slate-600 leading-relaxed">
                            {{ $faq['a'] }}
                        </div>
                    </details>
                @endforeach
            </div>
        </div>
    </section>
</main>

@include('components.footer')
<script src="{{ asset('js/auth.js') }}" defer></script>
</body>
</html>
