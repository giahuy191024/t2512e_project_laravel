<section class="relative py-20 md:py-24 overflow-hidden
                bg-gradient-to-b from-sky-50 via-white to-white">

    <div class="max-w-7xl mx-auto px-6">

        {{-- ===== HEADER pill ===== --}}
        <div class="flex flex-col items-center text-center mb-16">
            <h2 class="inline-block rounded-full bg-sky-100
                       px-6 md:px-10 py-3 md:py-4
                       text-2xl md:text-3xl lg:text-4xl font-bold text-slate-800
                       mb-5 leading-tight">
                Quy trình <span class="text-sky-600">thăm khám</span>
            </h2>
            <p class="max-w-2xl mx-auto text-base md:text-lg text-slate-500 leading-8">
                Chỉ với vài bước đơn giản, khách hàng sẽ được trải nghiệm
                dịch vụ nha khoa hiện đại, nhanh chóng và an tâm.
            </p>
        </div>

        {{-- ===== DỮ LIỆU ===== --}}
        @php
            $steps = [
                ['title' => 'Đặt lịch khám',     'desc' => 'Điền thông tin và lựa chọn thời gian khám phù hợp.'],
                ['title' => 'Xác nhận lịch hẹn', 'desc' => 'Hệ thống hoặc nhân viên xác nhận lịch khám nhanh chóng.'],
                ['title' => 'Thăm khám',         'desc' => 'Bác sĩ kiểm tra, tư vấn tình trạng răng miệng cụ thể.'],
                ['title' => 'Điều trị',          'desc' => 'Tiến hành điều trị bằng công nghệ nha khoa hiện đại.'],
                ['title' => 'Chăm sóc sau khám', 'desc' => 'Theo dõi và hướng dẫn chăm sóc để duy trì kết quả tốt nhất.'],
            ];
        @endphp

        {{-- ===== STEPS ===== --}}
        <div class="relative mb-16">

            {{-- Đường nối dashed (chỉ hiện desktop) --}}
            <div class="hidden lg:block absolute top-12 left-[10%] right-[10%]
                        border-t-2 border-dashed border-sky-300"></div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5
                        gap-8 lg:gap-4 relative">

                @foreach ($steps as $i => $step)
                    <div class="text-center group">

                        {{-- Vòng tròn số --}}
                        <div class="relative mx-auto mb-6 w-24 h-24 rounded-full
                                    bg-gradient-to-br from-sky-500 to-cyan-500
                                    shadow-lg shadow-sky-500/40
                                    flex items-center justify-center
                                    group-hover:scale-110 group-hover:rotate-6
                                    transition-all duration-300 z-10
                                    ring-4 ring-white">
                            <span class="text-white text-3xl font-bold tracking-wide">
                                0{{ $i + 1 }}
                            </span>
                        </div>

                        {{-- Card text --}}
                        <div class="bg-white rounded-2xl p-5
                                    border border-slate-100 shadow-sm
                                    group-hover:shadow-xl group-hover:border-sky-200
                                    group-hover:-translate-y-1
                                    transition-all duration-300">
                            <h3 class="font-bold text-lg text-slate-800 mb-2">
                                {{ $step['title'] }}
                            </h3>
                            <p class="text-slate-600 text-sm leading-relaxed">
                                {{ $step['desc'] }}
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        {{-- Divider --}}
        <div class="flex items-center justify-center gap-3 my-16">
    <span class="h-px flex-1 max-w-30
                 bg-linear-to-r from-transparent to-sky-200"></span>
            <span class="text-sky-400 text-xl">...</span>
            <span class="h-px flex-1 max-w-30
                 bg-linear-to-l from-transparent to-sky-200"></span>
        </div>
        {{-- ===== CTA ===== --}}
        <div class="text-center mt-16">
            <a href="{{ route('booking-requests.create') }}"
               class="inline-flex items-center gap-2 px-7 py-3.5 rounded-full
                      bg-gradient-to-r from-sky-500 to-cyan-500 text-white
                      font-semibold shadow-md hover:shadow-lg
                      hover:-translate-y-0.5 transition">
                Đặt lịch khám ngay

            </a>
        </div>
    </div>
</section>
