<section class="relative py-20 md:py-24 bg-cover bg-center bg-no-repeat"
         style="background-image:url('{{ asset('img/bg3.png') }}');">

    {{-- Overlay trắng để chữ rõ trên bg --}}
    <div class="absolute inset-0 bg-white/80"></div>

    <div class="relative max-w-7xl mx-auto px-6">

        {{-- ===== HEADER ===== --}}
        <div class="flex flex-col items-center text-center mb-20 px-6">
            <h2 class="inline-block w-200 rounded-full bg-sky-100
               px-6 md:px-10 py-3 md:py-4
               text-2xl md:text-3xl lg:text-4xl font-bold text-slate-800
               mb-8 leading-tight">
                Vì sao khách hàng <span class="text-sky-600">tin tưởng</span> MediConnect?
            </h2>
            <p class="max-w-2xl mx-auto text-base md:text-lg text-slate-500 leading-8">
                Chúng tôi không chỉ mang đến nụ cười đẹp,
                mà còn đem lại trải nghiệm điều trị an tâm.
            </p>
        </div>

        {{-- ===== DỮ LIỆU ===== --}}
        @php
            $reasons = [
                ['number' => '01', 'image' => 'why1.png',
                 'title' => 'Đội ngũ bác sĩ chuyên sâu',
                 'desc'  => 'Được đào tạo bài bản, nhiều năm kinh nghiệm trong điều trị nha khoa chuyên sâu.'],
                ['number' => '02', 'image' => 'why2.png',
                 'title' => 'Trang thiết bị hiện đại',
                 'desc'  => 'Ứng dụng công nghệ tiên tiến, hỗ trợ chẩn đoán và điều trị chính xác hơn.'],
                ['number' => '03', 'image' => 'why3.png',
                 'title' => 'Phác đồ cụ thể',
                 'desc'  => 'Mỗi khách hàng đều có kế hoạch điều trị phù hợp với tình trạng răng miệng.'],
                ['number' => '04', 'image' => 'why4.png',
                 'title' => 'Chi phí minh bạch',
                 'desc'  => 'Báo giá rõ ràng, không phát sinh chi phí ngoài dự kiến.'],
            ];
        @endphp

        {{-- ===== CARDS GRID ===== --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

            @foreach ($reasons as $r)
                <div class="group bg-white rounded-2xl
                            border border-slate-100
                            shadow-sm hover:shadow-2xl hover:-translate-y-2
                            transition-all duration-300 overflow-hidden">

                    {{-- Image với zoom on hover + number badge --}}
                    <div class="relative h-48 overflow-hidden">
                        <img src="{{ asset('img/' . $r['image']) }}"
                             alt="{{ $r['title'] }}"
                             class="w-full h-full object-cover
                                    group-hover:scale-110 transition duration-500">
                        {{-- Gradient overlay nhẹ --}}
                        <div class="absolute inset-0
                                    bg-gradient-to-t from-black/40 to-transparent"></div>
                        {{-- Number badge tròn ở góc --}}
                        <span class="absolute top-3 left-3 inline-flex items-center justify-center
                                     w-11 h-11 rounded-full
                                     bg-gradient-to-br from-sky-500 to-cyan-500
                                     text-white text-sm font-bold
                                     shadow-lg shadow-sky-500/40">
                            {{ $r['number'] }}
                        </span>
                    </div>

                    {{-- Body --}}
                    <div class="p-6 text-center">
                        <h3 class="font-bold text-lg text-slate-800 mb-2
                                   group-hover:text-sky-600 transition">
                            {{ $r['title'] }}
                        </h3>
                        <p class="text-slate-600 text-sm leading-relaxed">
                            {{ $r['desc'] }}
                        </p>
                    </div>
                </div>
            @endforeach
        </div>
        {{-- Divider --}}
        <div class="flex items-center justify-center gap-3 my-16">
    <span class="h-px flex-1 max-w-[120px]
                 bg-gradient-to-r from-transparent to-sky-200"></span>
            <span class="text-sky-400 text-xl">✦</span>
            <span class="h-px flex-1 max-w-[120px]
                 bg-gradient-to-l from-transparent to-sky-200"></span>
        </div>
        {{-- ===== CTA bottom ===== --}}
        <div class="text-center mt-14">
            <a href="{{ url('/about') }}"
               class="inline-flex items-center gap-2 px-7 py-3.5 rounded-full
                      bg-linear-to-r from-sky-500 to-cyan-500 text-white
                      font-semibold shadow-md hover:shadow-lg
                      hover:-translate-y-0.5 transition">
                Tìm hiểu thêm về chúng tôi
                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                     stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                </svg>
            </a>
        </div>
    </div>
</section>
