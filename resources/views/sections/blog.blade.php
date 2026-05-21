<section class=" py-20 md:py-24 bg-slate-50 overflow-hidden">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">

        {{-- ===== HEADER pill ===== --}}
        <div class="flex flex-col items-center text-center mb-14">
            <h2 class="inline-block rounded-full bg-sky-100
                       px-6 md:px-10 py-3 md:py-4
                       text-2xl md:text-3xl lg:text-4xl font-bold text-slate-800
                       mb-5 leading-tight">
                Tin tức &amp; <span class="text-sky-600">kiến thức</span> nổi bật
            </h2>
            <p class="max-w-2xl mx-auto text-base md:text-lg text-slate-500 leading-8">
                Cập nhật kiến thức nha khoa, mẹo chăm sóc răng miệng và công nghệ
                điều trị mới nhất từ đội ngũ MediConnect.
            </p>
        </div>

        {{-- ===== DATA (sau đẩy sang controller) ===== --}}
        @php
            $featured = [
                'category' => 'IMPLANT',
                'date'     => '12 Tháng 5, 2026',
                'readTime' => '5 phút đọc',
                'image'    => 'blog4.png',
                'title'    => 'Chăm sóc răng sau Implant như thế nào để bền lâu?',
                'excerpt'  => 'Sau khi trồng Implant, việc chăm sóc đúng cách sẽ giúp tăng tuổi thọ răng, bảo vệ nướu chắc khỏe và hạn chế tối đa các biến chứng không đáng có. Quy trình vệ sinh hàng ngày quyết định tới 50% sự thành công lâu dài.',
                'slug'     => 'cham-soc-rang-sau-implant',
            ];

            $sideArticles = [
                ['category' => 'CHỈNH NHA', 'date' => '10 Tháng 5, 2026', 'image' => 'blog1.png',
                 'title' => 'Niềng Invisalign có đau không? Giải đáp từ chuyên gia chỉnh nha',
                 'slug' => 'nieng-invisalign-co-dau-khong'],
                ['category' => 'TỔNG QUÁT', 'date' => '08 Tháng 5, 2026', 'image' => 'blog5.png',
                 'title' => '5 dấu hiệu cho thấy bạn nên đi khám nha khoa ngay lập tức',
                 'slug' => '5-dau-hieu-can-kham-nha-khoa'],
                ['category' => 'THẨM MỸ', 'date' => '05 Tháng 5, 2026', 'image' => 'blog7.png',
                 'title' => 'Tẩy trắng răng tại nhà và tại phòng khám: Lựa chọn nào tốt hơn?',
                 'slug' => 'tay-trang-rang-tai-nha-vs-phong-kham'],
                ['category' => 'CHỈNH NHA', 'date' => '03 Tháng 5, 2026', 'image' => 'blog1.png',
                 'title' => 'Phân biệt niềng mắc cài và khay trong suốt — chọn loại nào?',
                 'slug' => 'phan-biet-nieng-rang'],
                ['category' => 'PHÒNG NGỪA', 'date' => '01 Tháng 5, 2026', 'image' => 'blog5.png',
                 'title' => 'Sâu răng ở trẻ em: nguyên nhân và cách phòng tránh hiệu quả',
                 'slug' => 'sau-rang-tre-em'],
                ['category' => 'IMPLANT', 'date' => '28 Tháng 4, 2026', 'image' => 'blog7.png',
                 'title' => 'Quy trình cấy ghép Implant chuẩn quốc tế gồm những bước nào?',
                 'slug' => 'quy-trinh-cay-ghep-implant'],
            ];
        @endphp

        {{-- ===== LAYOUT 12-col ===== --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-8 items-start">

            {{-- ===== FEATURED (col-span-7) ===== --}}
            <article class="lg:col-span-7 group bg-white rounded-3xl
                            border border-slate-100 shadow-sm
                            hover:shadow-xl transition-all duration-300
                            overflow-hidden flex flex-col">

                <a href="#" class="block relative overflow-hidden">
                    <img src="{{ asset('img/' . $featured['image']) }}"
                         alt="{{ $featured['title'] }}"
                         class="w-full h-80 md:h-105 object-cover
                                group-hover:scale-105 transition-transform duration-500">
                    <span class="absolute top-4 left-4
                                 bg-sky-500 text-white text-xs font-bold
                                 px-3 py-1.5 rounded-full shadow-md">
                        {{ $featured['category'] }}
                    </span>
                </a>

                <div class="p-6 md:p-8 flex flex-col flex-1">
                    <div class="flex items-center gap-3 text-slate-400 text-xs mb-3">
                        <span>{{ $featured['date'] }}</span>
                        <span class="w-1 h-1 rounded-full bg-slate-300"></span>
                        <span>{{ $featured['readTime'] }}</span>
                    </div>

                    <h3 class="text-xl md:text-2xl font-bold text-slate-800 mb-4
                               group-hover:text-sky-600 transition leading-tight">
                        <a href="#">{{ $featured['title'] }}</a>
                    </h3>

                    <p class="text-slate-500 leading-7 mb-6 line-clamp-3">
                        {{ $featured['excerpt'] }}
                    </p>

                    <a href="#" class="inline-flex items-center gap-2 text-sm font-bold
                                       text-sky-600 hover:text-sky-700
                                       hover:gap-3 transition-all
                                       mt-auto pt-4 border-t border-slate-100">
                    </a>
                </div>
            </article>

            {{-- ===== SIDE LIST (col-span-5) ===== --}}
            <div class="lg:col-span-5 rounded-none border border-slate-200 shadow-sm overflow-hidden"
                 style="background-color: #e2e8f0;">

                {{-- Header trắng --}}
                <div style="background-color: #ffffff;"
                     class="px-6 py-4 border-b border-slate-200">
                    <h4 class="font-bold text-slate-800 flex items-center gap-2">
                        <span class="w-1.5 h-5 rounded-sm bg-sky-500"></span>
                        Cập nhật tin tức mới...
                    </h4>
                </div>

                {{-- List scroll với padding để lộ màu nền slate quanh các card --}}
                <div class="max-h-[500px] overflow-y-auto custom-scrollbar"
                     style="padding: 12px;">

                    @foreach ($sideArticles as $a)
                        <a href="#"
                           style="background-color: #ffffff; margin-bottom: 12px; display: flex;"
                           class="gap-4 items-start p-3 rounded-xl
                      shadow-sm hover:shadow-md
                      hover:bg-sky-50 transition group">
                            <img src="{{ asset('img/' . $a['image']) }}"
                                 alt="{{ $a['title'] }}"
                                 class="w-24 h-24 object-cover rounded-xl shrink-0">
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-2 mb-1.5">
                                    <span class="text-[11px] font-bold text-sky-600">{{ $a['category'] }}</span>
                                    <span class="w-1 h-1 rounded-full bg-slate-300"></span>
                                    <span class="text-xs text-slate-400">{{ $a['date'] }}</span>
                                </div>
                                <h3 class="font-bold text-sm md:text-base text-slate-800
                               group-hover:text-sky-600 transition
                               line-clamp-2 leading-snug">
                                    {{ $a['title'] }}
                                </h3>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
