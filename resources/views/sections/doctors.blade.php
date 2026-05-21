<section class="py-24 bg-slate-50 overflow-hidden">

    {{-- ===== HEADING ===== --}}
    <div class="flex flex-col items-center text-center mb-20 px-6">
        <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold text-sky-500 mb-5
               leading-tight">
            Gặp gỡ đội ngũ bác sĩ
            <span class="text-cyan-400">chuyên môn cao</span>
        </h2>
        <p class="max-w-3xl text-base md:text-lg text-slate-500 leading-8">
            MediConnect tự hào sở hữu đội ngũ bác sĩ giàu kinh nghiệm,
            tận tâm và luôn cập nhật công nghệ điều trị tiên tiến.
        </p>
    </div>

    {{-- ===== FEATURED DOCTOR — IMAGE LEFT, INFO RIGHT ===== --}}
    <div class="px-6 md:px-8 lg:px-20 mb-24 md:mb-32 lg:mb-40 flex justify-center items-center">
        <div class="max-w-5xl mx-auto bg-white
                    rounded-3xl shadow-xl ring-1 ring-sky-200
                    hover:shadow-2xl hover:ring-sky-300
                    transition duration-300
                    overflow-hidden
                    grid grid-cols-1 lg:grid-cols-2">

            {{-- ẢNH BÊN TRÁI - fix bằng cách dùng min-h thay vì absolute --}}
            <div class="relative">
                <img src="{{ asset('img/bsDaoHongLuyen.png') }}"
                     alt="BS. Đào Hồng Luyến"
                     class="w-full h-full min-h-72 sm:min-h-96 lg:min-h-[520px]
                            object-cover object-top">
                <span class="absolute top-5 left-5 inline-flex items-center gap-2
                             rounded-full bg-white/90 backdrop-blur
                             px-3 py-1.5 text-xs font-bold text-sky-600 shadow">
                    ⭐ BÁC SĨ ĐẦU NGÀNH
                </span>
            </div>

            {{-- INFO BÊN PHẢI --}}
            <div class="p-8 lg:p-12 flex flex-col justify-center">
                <span class="text-sky-600 font-semibold text-sm tracking-wider mb-3">
                    IMPLANT &amp; PHỤC HÌNH RĂNG
                </span>
                <h3 class="text-3xl lg:text-4xl font-bold text-slate-800 mb-3">
                    BS. Đào Hồng Luyến
                </h3>
                <p class="text-lg text-sky-600 font-medium mb-6">
                    10 năm kinh nghiệm
                </p>

                <ul class="space-y-3 mb-6 text-slate-600">
                    <li class="flex gap-2"><span class="text-sky-500 font-bold">✓</span>
                        Chuyên sâu Implant &amp; phục hình răng</li>
                    <li class="flex gap-2"><span class="text-sky-500 font-bold">✓</span>
                        Hơn 10 năm kinh nghiệm điều trị</li>
                    <li class="flex gap-2"><span class="text-sky-500 font-bold">✓</span>
                        Hàng nghìn khách hàng tin tưởng</li>
                </ul>

                <p class="text-slate-500 leading-8 mb-8">
                    Với nhiều năm kinh nghiệm, đội ngũ bác sĩ tại MediConnect
                    luôn mang đến trải nghiệm chăm sóc nha khoa an tâm,
                    hiện đại và cá nhân hóa.
                </p>

                <div class="flex flex-wrap gap-3">
                    <button
                        onclick="openDoctorModal('BS. Đào Hồng Luyến', 'Chuyên khoa Implant, hơn 10 năm kinh nghiệm.')"
                        class="px-6 py-3 w-30 rounded-full bg-slate-100 text-slate-700
                               font-semibold hover:bg-slate-200 transition">
                        Xem thêm
                    </button>
                    <a href="{{ route('booking-requests.create') }}"
                       class="iflex flex-col items-center text-center gap-2 px-4 py-2 w-45 rounded-full
                              bg-linear-to-r from-sky-500 to-cyan-500 text-white
                              font-semibold shadow-md hover:shadow-lg
                              hover:-translate-y-0.5 transition">
                        Đặt lịch ngay
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Header phụ ngăn cách trực quan giữa featured & tabs --}}
    <div class="text-center mb-8 px-6">
        <span class="inline-block w-12 h-0.5 bg-sky-400 mb-4"></span>
        <h3 class="text-2xl md:text-3xl font-bold text-slate-800 mb-2">
            Bác sĩ theo khu vực
        </h3>
        <p class="text-slate-500 text-sm md:text-base">
            Chọn khu vực để xem đội ngũ bác sĩ gần bạn nhất
        </p>
    </div>
    {{-- ===== REGION TABS (cách card đầu ngành) ===== --}}
    <div class="flex justify-center mb-12 md:mb-16 px-4">
        <div class="flex w-full max-w-md bg-sky-100 rounded-full p-1.5 gap-1 shadow-inner">
            <button data-region="mien-bac"
                    class="doctor-tab active flex-1 py-2.5 rounded-full
                       text-sm font-semibold transition">Miền Bắc</button>
            <button data-region="mien-trung"
                    class="doctor-tab flex-1 py-2.5 rounded-full
                       text-sm font-semibold transition">Miền Trung</button>
            <button data-region="mien-nam"
                    class="doctor-tab flex-1 py-2.5 rounded-full
                       text-sm font-semibold transition">Miền Nam</button>
        </div>
    </div>
    <div>
        {{-- ===== MIỀN BẮC ===== --}}
        <div id="mien-bac" class="doctor-region block relative pt-6 md:pt-8">

            {{-- Prev / Next --}}
            <div class="flex justify-end gap-2 mb-6 px-8 lg:px-20">
                <button class="doctor-prev w-10 h-10 rounded-full bg-white border border-slate-200
                           shadow-sm flex items-center justify-center text-slate-600
                           hover:bg-sky-500 hover:text-white hover:border-sky-500
                           transition">❮</button>
                <button class="doctor-next w-10 h-10 rounded-full bg-white border border-slate-200
                           shadow-sm flex items-center justify-center text-slate-600
                           hover:bg-sky-500 hover:text-white hover:border-sky-500
                           transition">❯</button>
            </div>

            {{-- Slider --}}
            <div class="doctor-slider flex flex-nowrap gap-6
                    overflow-x-auto scroll-smooth px-8 lg:px-20 pb-10 justify-center
                    [&::-webkit-scrollbar]:hidden [scrollbar-width:none]">

                @php
                    $doctorsMienBac = [
                        ['name' => 'BS. Bùi Gia Huy',      'img' => 'bsMienBac2.png', 'spec' => 'Chỉnh nha / Niềng răng', 'years' => 6,  'desc' => 'Chuyên gia chỉnh nha tăng trưởng.'],
                        ['name' => 'BS. Nguyễn Tuấn Việt', 'img' => 'bsMienBac3.png', 'spec' => 'Chỉnh nha / Niềng răng', 'years' => 8,  'desc' => 'Chuyên gia chỉnh nha 8 năm.'],
                        ['name' => 'BS. Đức Nam',          'img' => 'bsMienBac4.png', 'spec' => 'Răng sứ thẩm mỹ',       'years' => 12, 'desc' => 'Chuyên khoa răng sứ thẩm mỹ.'],
                    ];
                @endphp

                @foreach ($doctorsMienBac as $bs)
                    <div class="group min-w-[280px] max-w-[280px] bg-white rounded-3xl
                            shadow-md hover:shadow-xl hover:-translate-y-2
                            transition-all duration-300 overflow-hidden shrink-0">

                        {{-- Ảnh --}}
                        <div class="relative overflow-hidden">
                            <img src="{{ asset('img/' . $bs['img']) }}"
                                 alt="{{ $bs['name'] }}"
                                 class="w-full h-72 object-cover object-top
                                    group-hover:scale-105 transition-transform duration-500">
                        </div>

                        {{-- Thông tin --}}
                        <div class="p-6 text-center">
                            <h4 class="text-lg font-bold text-slate-800 mb-1">
                                {{ $bs['name'] }}
                            </h4>
                            <p class="text-sky-600 text-sm font-medium mb-4">
                                {{ $bs['spec'] }}
                            </p>

                            <a href="#"
                               onclick="event.preventDefault(); openDoctorModal('{{ $bs['name'] }}', '{{ $bs['desc'] }}')"
                               class="inline-flex items-center gap-1.5
                                  px-5 py-2 rounded-full
                                  bg-sky-50 text-sky-600 text-sm font-semibold
                                  hover:bg-sky-500 hover:text-white transition">
                                Xem thêm
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                     viewBox="0 0 24 24" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- ===== MIỀN TRUNG ===== --}}
        <div id="mien-trung" class="doctor-region hidden pt-6 md:pt-8">
            <div class="px-8 lg:px-20">
                <div class="bg-white rounded-3xl border border-dashed border-slate-300
                        py-16 px-8 text-center max-w-2xl mx-auto">
                    <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-sky-100
                            flex items-center justify-center">
                        <svg class="w-8 h-8 text-sky-500" fill="none" stroke="currentColor"
                             stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-slate-700 mb-2">Đang cập nhật</h3>
                    <p class="text-slate-500">Đội ngũ bác sĩ khu vực Miền Trung sẽ sớm có mặt.</p>
                </div>
            </div>
        </div>

        {{-- ===== MIỀN NAM ===== --}}
        <div id="mien-nam" class="doctor-region hidden pt-6 md:pt-8">
            <div class="px-8 lg:px-20">
                <div class="bg-white rounded-3xl border border-dashed border-slate-300
                        py-16 px-8 text-center max-w-2xl mx-auto">
                    <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-sky-100
                            flex items-center justify-center">
                        <svg class="w-8 h-8 text-sky-500" fill="none" stroke="currentColor"
                             stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-slate-700 mb-2">Đang cập nhật</h3>
                    <p class="text-slate-500">Đội ngũ bác sĩ khu vực Miền Nam sẽ sớm có mặt.</p>
                </div>
            </div>
        </div>
    </div>
    {{-- ===== MODAL ===== --}}
    <div id="doctorModal"
         class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm z-[9999]
                items-center justify-center p-5">
        <div class="bg-white rounded-3xl p-8 max-w-xl w-full relative shadow-2xl">
            <button onclick="closeDoctorModal()"
                    class="absolute right-5 top-4 w-9 h-9 rounded-full bg-slate-100
                           text-slate-600 text-2xl flex items-center justify-center
                           hover:bg-red-500 hover:text-white transition">×</button>
            <h3 id="modalDoctorName" class="text-2xl font-bold mb-5 text-slate-800"></h3>
            <p id="modalDoctorInfo" class="text-slate-600 leading-8"></p>
        </div>
    </div>
</section>
