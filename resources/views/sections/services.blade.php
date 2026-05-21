<section class="relative py-20 md:py-24 bg-cover bg-center bg-no-repeat"
         style="background-image:url('{{ asset('img/bg2.png') }}');">

    {{-- Overlay nhẹ để text rõ hơn --}}
    <div class="absolute inset-0 bg-white/70"></div>

    <div class="relative max-w-7xl mx-auto px-6">

        {{-- ===== HEADER ===== --}}
        <div class="flex flex-col items-center text-center mb-20 px-6">
            <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold text-sky-500 mb-5
               leading-tight">
                Dịch vụ <span class="text-sky-600">Nha khoa</span> toàn diện
            </h2>
            <p class="max-w-3xl text-base md:text-lg text-slate-500 leading-8">
                Chăm sóc sức khỏe răng miệng với công nghệ hiện đại
                và đội ngũ bác sĩ chuyên môn cao.
            </p>
        </div>

        {{-- ===== DỮ LIỆU DỊCH VỤ (gom 1 mảng để @foreach gọn) ===== --}}
        @php
            $services = [
                'implant' => [
                    'category' => 'PHỤC HÌNH RĂNG',
                    'title'    => 'Trồng Răng Implant',
                    'image'    => 'service2.png',
                    'intro'    => 'Công nghệ trồng răng Implant hiện đại giúp phục hồi răng đã mất một cách toàn diện và bền vững.',
                    'benefits' => [
                        'Phục hồi răng đã mất bằng trụ Implant cấy trực tiếp vào xương hàm.',
                        'Giúp ăn nhai chắc chắn, gần giống răng thật.',
                        'Ngăn tình trạng tiêu xương hàm do mất răng lâu ngày.',
                        'Tính thẩm mỹ cao, tuổi thọ lâu dài nếu chăm sóc tốt.',
                    ],
                ],
                'nguyen-ham' => [
                    'category' => 'PHỤC HÌNH RĂNG',
                    'title'    => 'Trồng Răng Nguyên Hàm',
                    'image'    => 'service2.png',
                    'intro'    => 'Giải pháp phục hồi toàn bộ răng mất trên một hàm bằng công nghệ hiện đại.',
                    'benefits' => [
                        'Phục hồi toàn bộ răng mất trên một hàm hiệu quả.',
                        'Phù hợp với người mất nhiều răng hoặc mất răng toàn hàm.',
                        'Khôi phục khả năng ăn nhai và cải thiện phát âm.',
                        'Mang lại hàm răng tự nhiên, chắc chắn và thẩm mỹ.',
                    ],
                ],
                'invisalign' => [
                    'category' => 'CHỈNH NHA',
                    'title'    => 'Niềng Răng Invisalign',
                    'image'    => 'service3.png',
                    'intro'    => 'Công nghệ chỉnh nha hiện đại bằng khay niềng trong suốt.',
                    'benefits' => [
                        'Sử dụng khay niềng trong suốt thay cho mắc cài.',
                        'Tính thẩm mỹ cao, khó nhận biết khi giao tiếp.',
                        'Có thể tháo lắp dễ dàng khi ăn uống.',
                        'Hiệu quả với răng lệch lạc, hô, móm.',
                    ],
                ],
                'mac-cai' => [
                    'category' => 'CHỈNH NHA',
                    'title'    => 'Niềng Răng Mắc Cài Tiết Kiệm',
                    'image'    => 'service4.png',
                    'intro'    => 'Giải pháp chỉnh nha hiệu quả với chi phí hợp lý.',
                    'benefits' => [
                        'Chi phí phù hợp với nhiều đối tượng.',
                        'Điều chỉnh răng hô, móm, lệch lạc hiệu quả.',
                        'Mắc cài cố định tạo lực kéo ổn định.',
                        'Giúp cải thiện thẩm mỹ và khớp cắn.',
                    ],
                ],
                'tre-em' => [
                    'category' => 'CHĂM SÓC ĐẶC BIỆT',
                    'title'    => 'Nha Khoa Trẻ Em',
                    'image'    => 'service5.png',
                    'intro'    => 'Dịch vụ chăm sóc răng miệng chuyên biệt dành cho trẻ nhỏ.',
                    'benefits' => [
                        'Theo dõi sự phát triển răng miệng của trẻ.',
                        'Phát hiện sớm các vấn đề nha khoa.',
                        'Hướng dẫn vệ sinh răng miệng đúng cách.',
                        'Môi trường thân thiện giúp trẻ thoải mái khi khám.',
                    ],
                ],
                'cao-rang' => [
                    'category' => 'NHA KHOA TỔNG QUÁT',
                    'title'    => 'Lấy Cao Răng',
                    'image'    => 'service6.png',
                    'intro'    => 'Làm sạch mảng bám và cao răng để bảo vệ sức khỏe răng miệng.',
                    'benefits' => [
                        'Loại bỏ mảng bám và cao răng lâu ngày.',
                        'Giảm nguy cơ viêm nướu và hôi miệng.',
                        'Giúp răng sạch sẽ và khỏe mạnh hơn.',
                        'Thực hiện nhanh chóng, ít gây khó chịu.',
                    ],
                ],
                'trong-suot' => [
                    'category' => 'CHỈNH NHA',
                    'title'    => 'Niềng Răng Trong Suốt',
                    'image'    => 'service7.png',
                    'intro'    => 'Giải pháp chỉnh nha thẩm mỹ bằng khay niềng trong suốt.',
                    'benefits' => [
                        'Chỉnh nha bằng khay niềng gần như vô hình.',
                        'Tăng tính thẩm mỹ trong suốt quá trình điều trị.',
                        'Dễ tháo lắp, thuận tiện khi sinh hoạt hằng ngày.',
                        'Phù hợp với người muốn niềng kín đáo.',
                    ],
                ],
                'rang-khon' => [
                    'category' => 'TIỂU PHẪU',
                    'title'    => 'Nhổ Răng Khôn',
                    'image'    => 'service8.png',
                    'intro'    => 'Giải pháp an toàn cho răng khôn mọc lệch hoặc gây đau nhức.',
                    'benefits' => [
                        'Loại bỏ răng khôn mọc lệch, mọc ngầm.',
                        'Giảm đau nhức và nguy cơ viêm nhiễm.',
                        'Hạn chế ảnh hưởng đến răng kế cận.',
                        'Thực hiện an toàn với công nghệ hiện đại.',
                    ],
                ],
                'rang-su' => [
                    'category' => 'THẨM MỸ',
                    'title'    => 'Răng Sứ Thẩm Mỹ',
                    'image'    => 'service9.png',
                    'intro'    => 'Giải pháp cải thiện thẩm mỹ nụ cười nhanh chóng.',
                    'benefits' => [
                        'Cải thiện màu sắc và hình dáng răng.',
                        'Khắc phục răng xỉn màu, sứt mẻ.',
                        'Mang lại nụ cười trắng sáng tự nhiên.',
                        'Độ bền cao và thẩm mỹ lâu dài.',
                    ],
                ],
                'tram-rang' => [
                    'category' => 'NHA KHOA TỔNG QUÁT',
                    'title'    => 'Hàn Trám Răng',
                    'image'    => 'service10.png',
                    'intro'    => 'Khôi phục răng tổn thương và bảo vệ răng thật.',
                    'benefits' => [
                        'Điều trị răng sâu, răng mẻ hiệu quả.',
                        'Bảo vệ cấu trúc răng thật.',
                        'Màu trám gần giống màu răng tự nhiên.',
                        'Quy trình nhanh chóng, ít đau.',
                    ],
                ],
            ];
            $first = array_key_first($services);
        @endphp

        {{-- ===== LAYOUT ===== --}}
        <div class="flex flex-col lg:flex-row gap-6 lg:gap-8 items-start">

            {{-- ===== LEFT: Service list ===== --}}
            <aside class="w-full lg:w-80 shrink-0 lg:sticky lg:top-24">
                <div class="bg-white rounded-2xl shadow-sm ring-1 ring-slate-100 overflow-hidden">
                    <div class="flex flex-col items-center text-center h-11 px-6 py-5 border-b border-slate-100
                                bg-gradient-to-r from-sky-50 to-cyan-50">
                        <h2 class="text-base font-bold text-slate-800">Danh sách dịch vụ</h2>
                    </div>

                    <div class="p-2 max-h-[600px] overflow-y-auto custom-scrollbar">
                        @foreach ($services as $key => $sv)
                            <button onclick="showService(this, '{{ $key }}')" class="service-tab {{ $key === $first ? 'active' : '' }}"
                                    data-target="{{ $key }}">
                                <span class="service-tab__icon">🦷</span>
                                <span class="service-tab__name">{{ $sv['title'] }}</span>
                                <span class="service-tab__arrow">›</span>
                            </button>
                        @endforeach
                    </div>
                </div>
            </aside>

            {{-- ===== RIGHT: Content ===== --}}
            <div class="flex-1 w-full">
                @foreach ($services as $key => $sv)
                    <div id="{{ $key }}"
                         class="service-content {{ $key === $first ? 'active-content' : '' }}">
                        <article class="bg-white rounded-2xl shadow-sm ring-1 ring-slate-100
                                        overflow-hidden">
                            {{-- HERO IMAGE với overlay title --}}
                            <div class="relative h-72 md:h-96">
                                <img src="{{ asset('img/' . $sv['image']) }}"
                                     alt="{{ $sv['title'] }}"
                                     class="w-full h-full object-cover">
                                <div class="absolute inset-0
                                            bg-gradient-to-t from-black/70 via-black/30 to-transparent"></div>
                                <div class="absolute bottom-6 left-6 right-6">
                                    <h3 class="text-2xl md:text-3xl lg:text-4xl
                                               font-bold text-white">
                                        {{ $sv['title'] }}
                                    </h3>
                                </div>
                            </div>

                            {{-- BODY --}}
                            <div class="p-6 md:p-8">
                                <p class="text-slate-600 leading-7 mb-6">
                                    {{ $sv['intro'] }}
                                </p>

                                <h4 class="font-bold text-slate-800 mb-4 flex items-center gap-2">
                                    <span class="w-1 h-5 rounded bg-sky-500"></span>
                                    Lợi ích nổi bật
                                </h4>
                                <ul class="space-y-3 mb-6">
                                    @foreach ($sv['benefits'] as $b)
                                        <li class="flex gap-3 items-start">
                                            <span class="flex-shrink-0 w-5 h-5 mt-0.5 rounded-full
                                                         bg-sky-100 flex items-center justify-center">
                                                <svg class="w-3 h-3 text-sky-600" fill="none"
                                                     stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                          d="M5 13l4 4L19 7"/>
                                                </svg>
                                            </span>
                                            <span class="text-slate-600">{{ $b }}</span>
                                        </li>
                                    @endforeach
                                </ul>

                                {{-- CTA --}}
                                <div class="flex flex-wrap gap-3 pt-6 border-t border-slate-100">
                                    <a href="{{ url('/booking?service=' . $key) }}"
                                       class="flex flex-col items-center text-center gap-2 px-6 py-3 w-35 rounded-full
                                              bg-gradient-to-r from-sky-500 to-cyan-500 text-white
                                              font-semibold shadow-md
                                              hover:shadow-lg hover:-translate-y-0.5 transition">
                                        Đặt lịch ngay
                                    </a>
                                    <a href="tel:19006900"
                                       class="inline-flex items-center gap-2 px-6 py-3 w-40 rounded-full
                                              border-2 border-sky-500 text-sky-600
                                              hover:bg-sky-50 font-semibold transition">
                                        📞 Tư vấn miễn phí
                                    </a>
                                </div>
                            </div>
                        </article>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
