<section class="relative w-full overflow-hidden -mt-22.5">

    {{-- Background image trải full section (chui sau header) --}}
    <div class="absolute inset-0 bg-cover bg-center"
         style="background-image:url('{{ asset('img/section_about1.png') }}');"></div>

    {{-- Overlay nhẹ giữ nguyên --}}
    <div class="absolute inset-0 bg-white/15"></div>

    {{-- Container: pt lớn để chừa chỗ cho header, min-h đủ cao để cards xuống đáy --}}
    <div class="relative z-10 px-6 md:px-10 lg:px-[10%]
                pt-32 md:pt-44 pb-12 md:pb-16
                min-h-170 md:min-h-195
                flex flex-col lg:flex-row gap-10 lg:gap-16">

        {{-- ===== LEFT - Text (giữ nguyên như cũ) ===== --}}
        <div class="w-full lg:w-[40%]">

            <h2 class="text-blue-700 text-4xl md:text-5xl font-semibold mb-6">
                <span class="font-bold">MediConnect</span> xin chào
            </h2>

            <div class="text-blue-700 leading-8 text-lg space-y-5">
                <p>
                    <strong>MediConnect</strong> là hệ thống nha khoa hiện đại,
                    mang đến giải pháp chăm sóc
                    <strong>sức khỏe răng miệng toàn diện</strong>
                    cho mọi khách hàng.
                </p>
                <p>
                    Với đội ngũ bác sĩ giàu kinh nghiệm cùng công nghệ tiên tiến,
                    chúng tôi cam kết đem lại trải nghiệm điều trị
                    an toàn, thoải mái và hiệu quả nhất.
                </p>
                <p>
                    Chúng tôi cung cấp đa dạng dịch vụ như
                    <strong>niềng răng, cấy ghép Implant, răng sứ thẩm mỹ</strong>
                    và chăm sóc nha khoa tổng quát,
                    giúp khách hàng tự tin với nụ cười khỏe đẹp.
                </p>
            </div>
        </div>

        {{-- ===== RIGHT - Cards style cũ, dán đáy ===== --}}
        <div class="flex-1 flex flex-wrap justify-center items-end gap-4">

            {{-- CARD 1 --}}
            <div class="relative w-44 h-32
                        bg-white/95 border border-blue-500
                        rounded-2xl shadow-md
                        flex flex-col justify-center items-center">
                <div class="absolute -top-5 left-1/2 -translate-x-1/2
                            w-10 h-10 bg-contain bg-no-repeat"
                     style="background-image:url('{{ asset('img/icon.png') }}')"></div>
                <span class="text-5xl font-light text-blue-700">15</span>
                <span class="text-lg text-blue-700">năm</span>
                <span class="text-base text-blue-700">kinh nghiệm</span>
            </div>

            {{-- CARD 2 --}}
            <div class="relative w-44 h-32
                        bg-white/95 border border-blue-500
                        rounded-2xl shadow-md
                        flex flex-col justify-center items-center">
                <div class="absolute -top-5 left-1/2 -translate-x-1/2
                            w-10 h-10 bg-contain bg-no-repeat"
                     style="background-image:url('{{ asset('img/icon.png') }}')"></div>
                <span class="text-5xl font-light text-blue-700">10</span>
                <span class="text-base text-blue-700 text-center">
                    chi nhánh <br> toàn quốc
                </span>
            </div>

            {{-- CARD 3 --}}
            <div class="relative w-44 h-32
                        bg-white/95 border border-blue-500
                        rounded-2xl shadow-md
                        flex flex-col justify-center items-center">
                <div class="absolute -top-5 left-1/2 -translate-x-1/2
                            w-10 h-10 bg-contain bg-no-repeat"
                     style="background-image:url('{{ asset('img/icon.png') }}')"></div>
                <span class="text-5xl font-light text-blue-700">15K+</span>
                <span class="text-base text-blue-700 text-center">nụ cười</span>
            </div>
        </div>
    </div>
</section>
