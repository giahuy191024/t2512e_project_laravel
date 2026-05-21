<section class="relative py-24 md:py-32 overflow-hidden
                bg-linear-to-b from-white via-sky-50 to-white">

    <div class="max-w-7xl mx-auto px-6">

        {{-- ===== HEADER pill ===== --}}
        <div class="flex flex-col items-center text-center mb-12">
            <h2 class="inline-block rounded-full bg-sky-100
                       px-6 md:px-10 py-3 md:py-4
                       text-2xl md:text-3xl lg:text-4xl font-bold text-slate-800
                       mb-5 leading-tight">
                Hơn <span class="text-sky-600">15.000+</span> nụ cười hài lòng
            </h2>
            <p class="max-w-2xl mx-auto text-base md:text-lg text-slate-500 leading-8">
                Cảm nhận chân thực từ khách hàng đã tin tưởng và đồng hành cùng MediConnect.
            </p>
        </div>

        {{-- ===== STATS ROW ===== --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6">
            @php
                $stats = [
                    ['num' => '15K+',  'label' => 'Khách hàng'],
                    ['num' => '4.9/5', 'label' => 'Đánh giá'],
                    ['num' => '10',    'label' => 'Năm hoạt động'],
                    ['num' => '98%',   'label' => 'Hài lòng'],
                ];
            @endphp
            @foreach ($stats as $s)
                <div class="bg-white rounded-2xl border border-slate-100
                    p-6 shadow-sm text-center
                    flex flex-col items-center justify-center
                    min-h-32.5">
                    <div class="text-3xl md:text-4xl font-bold
                        bg-linear-to-br from-sky-500 to-cyan-500
                        bg-clip-text text-transparent
                        leading-none">
                        {{ $s['num'] }}
                    </div>
                    <div class="text-sm text-slate-500 mt-2">
                        {{ $s['label'] }}
                    </div>
                </div>
            @endforeach
        </div>
        {{-- Divider --}}
        <div class="flex items-center justify-center gap-3 my-16">
    <span class="h-px flex-1 max-w-30
                 bg-linear-to-r from-transparent to-sky-200"></span>
            <span class="text-sky-400 text-xl">✦</span>
            <span class="h-px flex-1 max-w-30
                 bg-linear-to-l from-transparent to-sky-200"></span>
        </div>
        {{-- ===== DỮ LIỆU TESTIMONIALS ===== --}}
        @php
            $testimonials = [
                [
                    'name'     => 'Nguyễn Minh Anh',
                    'initials' => 'MA',
                    'role'     => 'Khách hàng chỉnh nha',
                    'service'  => 'Invisalign',
                    'quote'    => 'Mình niềng Invisalign tại MediConnect hơn 8 tháng, bác sĩ tư vấn rất kỹ và luôn theo sát quá trình điều trị.',
                ],
                [
                    'name'     => 'Trần Quốc Bảo',
                    'initials' => 'QB',
                    'role'     => 'Khách hàng Implant',
                    'service'  => 'Cấy ghép Implant',
                    'quote'    => 'Không gian sạch sẽ, bác sĩ nhẹ nhàng, điều trị rất thoải mái và không đau như mình nghĩ lúc đầu.',
                ],
                [
                    'name'     => 'Lê Thu Hà',
                    'initials' => 'TH',
                    'role'     => 'Khách hàng tổng quát',
                    'service'  => 'Lấy cao răng',
                    'quote'    => 'Đặt lịch rất tiện, được nhắc lịch trước qua tin nhắn. Nhân viên hỗ trợ vô cùng nhiệt tình và chuyên nghiệp.',
                ],
            ];
        @endphp

        {{-- ===== TESTIMONIAL CARDS ===== --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach ($testimonials as $t)
                <div class="group relative bg-white rounded-2xl
                            p-6 md:p-8
                            border border-slate-100 shadow-sm
                            hover:shadow-2xl hover:-translate-y-2
                            transition-all duration-300
                            flex flex-col">

                    {{-- Dấu nháy lớn trang trí --}}
                    <svg class="absolute -top-3 -left-1 w-16 h-16 text-sky-200
                                group-hover:text-sky-300 transition"
                         fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M7.17 17q-1.21 0-2.04-.83Q4.3 15.34 4.3 14.13q0-.6.18-1.18.18-.58.55-1.11l3.13-4.49h2.43L8.45 11.5q.2-.1.4-.13.2-.04.4-.04 1.13 0 1.94.81.81.81.81 1.96 0 1.21-.83 2.06Q10.34 17 9.13 17H7.17Zm8.7 0q-1.21 0-2.04-.83-.83-.83-.83-2.04 0-.6.18-1.18.18-.58.55-1.11l3.13-4.49h2.43l-2.14 4.15q.2-.1.4-.13.2-.04.4-.04 1.13 0 1.94.81.81.81.81 1.96 0 1.21-.83 2.06Q19.04 17 17.83 17h-1.96Z"/>
                    </svg>

                    {{-- Badge dịch vụ --}}
                    <span class="inline-block self-start mb-4
                                 px-3 py-1 rounded-full
                                 bg-sky-50 text-sky-600
                                 text-xs font-semibold relative z-10">
                        {{ $t['service'] }}
                    </span>

                    {{-- Stars SVG --}}
                    <div class="flex gap-0.5 mb-4 relative z-10">
                        @for ($i = 0; $i < 5; $i++)
                            <svg class="w-5 h-5 text-amber-400" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.957a1 1 0 00.95.69h4.162c.969 0 1.371 1.24.588 1.81l-3.37 2.448a1 1 0 00-.363 1.118l1.287 3.957c.3.922-.755 1.688-1.54 1.118l-3.37-2.448a1 1 0 00-1.175 0l-3.37 2.448c-.784.57-1.838-.197-1.539-1.118l1.287-3.957a1 1 0 00-.363-1.118L2.07 9.384c-.783-.57-.38-1.81.588-1.81h4.162a1 1 0 00.95-.69l1.286-3.957z"/>
                            </svg>
                        @endfor
                    </div>

                    {{-- Quote --}}
                    <p class="text-slate-700 leading-relaxed mb-6 relative z-10 flex-1">
                        "{{ $t['quote'] }}"
                    </p>

                    {{-- Author --}}
                    <div class="flex items-center gap-3 pt-5 border-t border-slate-100 relative z-10">
                        <div class="w-12 h-12 rounded-full
                                    bg-linear-to-br from-sky-400 to-cyan-500
                                    text-white font-bold text-sm
                                    flex items-center justify-center
                                    shadow-md shadow-sky-500/30">
                            {{ $t['initials'] }}
                        </div>
                        <div>
                            <h3 class="font-bold text-slate-800 text-sm">{{ $t['name'] }}</h3>
                            <p class="text-xs text-slate-500">{{ $t['role'] }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
