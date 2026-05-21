<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us | MediConnect</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>
<body>
@include('components.header')
@include('components.auth-modal')

<main class="bg-slate-50 text-slate-800 antialiased overflow-x-hidden">
    {{-- 1. HERO  --}}
    <section class="bg-white py-16 md:py-20 lg:py-24 border-b border-slate-100">
        <div class="max-w-7xl mx-auto px-6 lg:px-8
                    grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-16 items-center">

            <div class="lg:col-span-7 space-y-6">

                <h1 class="text-3xl md:text-4xl lg:text-5xl font-black text-slate-900
                           leading-tight tracking-tight">
                    Kiến tạo nụ cười,
                    <span class="bg-gradient-to-r from-sky-500 to-cyan-500
                                 bg-clip-text text-transparent">gửi trao hạnh phúc</span>
                </h1>

                <div class="space-y-4 text-slate-600 text-base md:text-lg leading-relaxed">
                    <p>
                        Được thành lập với sứ mệnh mang lại giải pháp chăm sóc răng miệng toàn diện,
                        <strong class="text-slate-900">MediConnect</strong> đã và đang khẳng định
                        vị thế là hệ thống nha khoa uy tín hàng đầu Việt Nam.
                    </p>
                    <p>
                        Chúng tôi tin rằng một nụ cười khỏe đẹp không chỉ mang lại sự tự tin,
                        mà còn là chìa khóa nâng tầm chất lượng cuộc sống.
                    </p>
                </div>

                {{-- Stats inline --}}
                <div class="grid grid-cols-3 gap-4 pt-8 border-t border-slate-100">
                    @php
                        $heroStats = [
                            ['num' => '15+', 'label' => 'Năm kinh nghiệm'],
                            ['num' => '10+', 'label' => 'Chi nhánh'],
                            ['num' => '15K+', 'label' => 'Khách hàng'],
                        ];
                    @endphp
                    @foreach ($heroStats as $st)
                        <div>
                            <span class="block text-3xl lg:text-4xl font-black
                                         bg-gradient-to-br from-sky-500 to-cyan-600
                                         bg-clip-text text-transparent">
                                {{ $st['num'] }}
                            </span>
                            <span class="text-[11px] font-bold text-slate-400
                                         uppercase tracking-wider block mt-1">
                                {{ $st['label'] }}
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="lg:col-span-5 relative">
                <div class="aspect-[4/5] rounded-3xl overflow-hidden shadow-xl">
                    <img src="https://images.unsplash.com/photo-1588776814546-1ffcf47267a5?auto=format&fit=crop&w=900&q=80"
                         alt="MediConnect"
                         class="w-full h-full object-cover hover:scale-105 transition duration-700">
                </div>
                {{-- Decorative badge --}}
                <div class="absolute -bottom-6 -left-6 bg-white rounded-2xl shadow-xl p-5
                            flex items-center gap-3 max-w-[240px]">
                    <div class="w-12 h-12 rounded-full bg-gradient-to-br from-sky-500 to-cyan-500
                                flex items-center justify-center text-white text-xl shrink-0">
                        ⭐
                    </div>
                    <div>
                        <div class="font-bold text-slate-900">4.9/5</div>
                        <div class="text-xs text-slate-500">Đánh giá từ khách hàng</div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- 2. CÂU CHUYỆN THƯƠNG HIỆU  --}}
    <section class="py-20 md:py-24 bg-slate-50">
        <div class="max-w-7xl mx-auto px-6 lg:px-8
                    grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 items-center">

            {{-- Image với layered decoration --}}
            <div class="relative order-2 lg:order-1">
                <div class="aspect-[5/4] rounded-3xl overflow-hidden shadow-lg">
                    <img src="https://images.unsplash.com/photo-1629909613654-28e377c37b09?auto=format&fit=crop&w=900&q=80"
                         alt="Câu chuyện MediConnect"
                         class="w-full h-full object-cover">
                </div>
                {{-- Decorative dots pattern (optional decoration) --}}
                <div class="absolute -top-4 -right-4 w-32 h-32
                            bg-sky-100 rounded-3xl -z-10"></div>
                <div class="absolute -bottom-4 -left-4 w-24 h-24
                            bg-cyan-100 rounded-2xl -z-10"></div>
            </div>

            <div class="order-1 lg:order-2 space-y-5">

                <h2 class="text-3xl md:text-4xl font-bold text-slate-900 leading-tight">
                    Hành trình 15 năm
                    <span class="text-sky-600">vì nụ cười Việt</span>
                </h2>

                <p class="text-slate-600 leading-relaxed">
                    Bắt đầu từ một phòng khám nhỏ tại Hà Nội năm 2010 với chỉ 3 bác sĩ,
                    MediConnect đã không ngừng phát triển nhờ vào niềm tin của hàng nghìn khách hàng.
                </p>
                <p class="text-slate-600 leading-relaxed">
                    Mỗi nụ cười chúng tôi mang lại là một câu chuyện riêng — về sự tự tin, hạnh phúc
                    và một cuộc sống mới. Đó cũng là động lực để MediConnect không ngừng
                    đầu tư vào công nghệ, đào tạo đội ngũ và nâng cao chất lượng dịch vụ.
                </p>
                {{-- Quote --}}
                <blockquote class="border-l-4 border-sky-500 pl-5 py-2 italic text-slate-700">
                    "Sứ mệnh của chúng tôi không chỉ là chữa bệnh răng miệng,
                    mà là trao đi sự tự tin và niềm vui sống."
                    <footer class="mt-2 text-sm not-italic text-slate-500">
                        — <strong class="text-sky-600">BS. Đào Hồng Luyến</strong>, Sáng lập viên
                    </footer>
                </blockquote>
            </div>
        </div>
    </section>
    {{-- 3. TẦM NHÌN & SỨ MỆNH    --}}
    <section class="py-20 md:py-24 bg-white">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="flex flex-col items-center text-center mb-14">
                <h2 class="inline-block rounded-full bg-sky-100
                           px-6 md:px-10 py-3 md:py-4
                           text-2xl md:text-3xl lg:text-4xl font-bold text-slate-800
                           mb-5 leading-tight">
                    Tầm nhìn &amp; <span class="text-sky-600">sứ mệnh</span>
                </h2>
                <p class="max-w-2xl mx-auto text-slate-500 text-base md:text-lg">
                    Định hướng phát triển dài hạn và cam kết với cộng đồng.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="group bg-gradient-to-br from-sky-50 to-white
                            p-8 md:p-10 rounded-3xl border border-sky-100
                            hover:shadow-xl transition duration-300">
                    <div class="w-16 h-16 bg-gradient-to-br from-sky-500 to-cyan-500
                                rounded-2xl flex items-center justify-center mb-6
                                shadow-lg shadow-sky-500/30">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor"
                             stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/>
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-slate-900 mb-3">Tầm nhìn chiến lược</h3>
                    <p class="text-slate-600 leading-relaxed">
                        Trở thành chuỗi nha khoa công nghệ cao dẫn đầu cả nước, tiên phong
                        ứng dụng giải pháp số hóa vào trải nghiệm khách hàng. Đến 2030,
                        MediConnect đặt mục tiêu phục vụ 50.000+ khách hàng mỗi năm.
                    </p>
                </div>

                <div class="group bg-gradient-to-br from-emerald-50 to-white
                            p-8 md:p-10 rounded-3xl border border-emerald-100
                            hover:shadow-xl transition duration-300">
                    <div class="w-16 h-16 bg-gradient-to-br from-emerald-500 to-teal-500
                                rounded-2xl flex items-center justify-center mb-6
                                shadow-lg shadow-emerald-500/30">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor"
                             stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-slate-900 mb-3">Sứ mệnh cao cả</h3>
                    <p class="text-slate-600 leading-relaxed">
                        Đồng hành cùng hàng triệu gia đình Việt trên hành trình bảo vệ nụ cười
                        nguyên bản. Cam kết điều trị bằng sự tận tâm, minh bạch chi phí
                        và mang lại sự an tâm tuyệt đối trong từng ca can thiệp.
                    </p>
                </div>
            </div>
        </div>
    </section>
    {{-- 4. VÌ SAO CHỌN MEDICONNECT --}}
    <section class="py-20 md:py-24 bg-slate-50">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">

            <div class="flex flex-col items-center text-center mb-16">
                <h2 class="inline-block rounded-full bg-sky-100
                           px-6 md:px-10 py-3 md:py-4
                           text-2xl md:text-3xl lg:text-4xl font-bold text-slate-800
                           mb-5 leading-tight">
                    Khác biệt làm nên <span class="text-sky-600">MediConnect</span>
                </h2>
                <p class="max-w-2xl mx-auto text-slate-500 text-base md:text-lg">
                    Chúng tôi không chỉ điều trị, mà còn xây dựng niềm tin từng ngày.
                </p>
            </div>

            @php
                $highlights = [
                    [
                        'title' => 'Đội ngũ bác sĩ chuyên môn cao',
                        'desc'  => 'Tốt nghiệp từ Đại học Y Hà Nội, Đại học Y Dược TP.HCM. 100% có chứng chỉ hành nghề và cập nhật thường xuyên các phương pháp điều trị mới nhất từ chuyên gia quốc tế.',
                        'image' => 'https://images.unsplash.com/photo-1594824476967-48c8b964273f?auto=format&fit=crop&w=700&q=80',
                        'bullets' => ['10+ năm kinh nghiệm trung bình', 'Đào tạo định kỳ tại Đức, Mỹ, Hàn Quốc', 'Hội chẩn ca khó cùng chuyên gia đầu ngành'],
                    ],
                    [
                        'title' => 'Công nghệ điều trị hiện đại',
                        'desc'  => 'Máy chụp CT Cone-Beam 3D, máy quét iTero, công nghệ Implant All-on-4, máy laser nha khoa thế hệ mới — đầu tư hàng triệu USD cho trang thiết bị.',
                        'image' => 'https://images.unsplash.com/photo-1606811971618-4486d14f3f99?auto=format&fit=crop&w=700&q=80',
                        'bullets' => ['CT 3D Cone-Beam chuẩn Đức', 'Phẫu thuật Implant không đau', 'Máy quét răng kỹ thuật số iTero'],
                    ],
                    [
                        'title' => 'Cam kết an toàn tuyệt đối',
                        'desc'  => 'Quy trình vô trùng 7 bước chuẩn quốc tế ISO 9001:2015. Mỗi bộ dụng cụ chỉ sử dụng cho 1 khách hàng. Bảo hành điều trị lên đến 25 năm.',
                        'image' => 'https://images.unsplash.com/photo-1629909613654-28e377c37b09?auto=format&fit=crop&w=700&q=80',
                        'bullets' => ['Chứng nhận ISO 9001:2015', 'Vô trùng 7 bước theo chuẩn CDC', 'Bảo hành Implant đến 25 năm'],
                    ],
                ];
            @endphp

            <div class="space-y-16 md:space-y-24">
                @foreach ($highlights as $i => $h)
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 lg:gap-16 items-center">
                        {{-- Image - alternate side --}}
                        <div class="{{ $i % 2 === 0 ? 'lg:order-1' : 'lg:order-2' }}">
                            <div class="relative">
                                <div class="aspect-[4/3] rounded-3xl overflow-hidden shadow-lg">
                                    <img src="{{ $h['image'] }}"
                                         alt="{{ $h['title'] }}"
                                         class="w-full h-full object-cover hover:scale-105 transition duration-700">
                                </div>
                                {{-- Number badge --}}
                                <div class="absolute -top-5 -left-5 w-16 h-16
                                            rounded-2xl bg-gradient-to-br from-sky-500 to-cyan-500
                                            text-white font-black text-xl
                                            flex items-center justify-center shadow-lg">
                                    0{{ $i + 1 }}
                                </div>
                            </div>
                        </div>

                        {{-- Text - alternate side --}}
                        <div class="{{ $i % 2 === 0 ? 'lg:order-2' : 'lg:order-1' }} space-y-5">
                            <h3 class="text-2xl md:text-3xl font-bold text-slate-900 leading-tight">
                                {{ $h['title'] }}
                            </h3>
                            <p class="text-slate-600 leading-relaxed">{{ $h['desc'] }}</p>
                            <ul class="space-y-2.5">
                                @foreach ($h['bullets'] as $b)
                                    <li class="flex gap-3 items-start text-slate-700">
                                        <span class="shrink-0 w-5 h-5 mt-0.5 rounded-full
                                                     bg-sky-100 flex items-center justify-center">
                                            <svg class="w-3 h-3 text-sky-600" fill="none"
                                                 stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                      d="M5 13l4 4L19 7"/>
                                            </svg>
                                        </span>
                                        {{ $b }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    {{-- 5. GIÁ TRỊ CỐT LÕI    --}}
    <section class="py-20 md:py-24 bg-white">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">

            <div class="flex flex-col items-center text-center mb-14">
                <h2 class="inline-block rounded-full bg-sky-100
                           px-6 md:px-10 py-3 md:py-4
                           text-2xl md:text-3xl lg:text-4xl font-bold text-slate-800
                           mb-5 leading-tight">
                    Giá trị <span class="text-sky-600">cốt lõi</span>
                </h2>
                <p class="max-w-2xl mx-auto text-slate-500 text-base md:text-lg">
                    4 nguyên tắc dẫn lối mọi quyết định và hành động của chúng tôi.
                </p>
            </div>

            @php
                $values = [
                    ['icon' => '💙', 'title' => 'Tận tâm',     'desc' => 'Đồng hành cùng khách hàng từ tư vấn đến chăm sóc sau điều trị.'],
                    ['icon' => '🦷', 'title' => 'Chuyên môn',  'desc' => 'Bác sĩ giàu kinh nghiệm, điều trị theo tiêu chuẩn quốc tế.'],
                    ['icon' => '🔍', 'title' => 'Minh bạch',   'desc' => 'Chi phí rõ ràng, phác đồ cá nhân hóa cho từng khách hàng.'],
                    ['icon' => '⚡', 'title' => 'Đổi mới',     'desc' => 'Ứng dụng công nghệ hiện đại, nâng cao hiệu quả điều trị.'],
                ];
            @endphp

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach ($values as $v)
                    <div class="group bg-white rounded-2xl p-7 shadow-sm border border-slate-100
                                text-center hover:shadow-xl hover:-translate-y-2
                                transition duration-300">
                        <div class="text-5xl mb-4 group-hover:scale-110 transition duration-300">
                            {{ $v['icon'] }}
                        </div>
                        <h3 class="font-bold text-slate-900 mb-2 text-lg">{{ $v['title'] }}</h3>
                        <p class="text-sm text-slate-500 leading-relaxed">{{ $v['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    {{-- 7. ĐỘI NGŨ LÃNH ĐẠO     --}}
    <section class="py-20 md:py-24 bg-white">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">

            <div class="flex flex-col items-center text-center mb-14">
                <h2 class="inline-block rounded-full bg-sky-100
                           px-6 md:px-10 py-3 md:py-4
                           text-2xl md:text-3xl lg:text-4xl font-bold text-slate-800
                           mb-5 leading-tight">
                    Đội ngũ <span class="text-sky-600">lãnh đạo</span>
                </h2>
                <p class="max-w-2xl mx-auto text-slate-500 text-base md:text-lg">
                    Những con người tâm huyết, cùng nhau xây dựng MediConnect.
                </p>
            </div>

            @php
                $leaders = [
                    [
                        'name'  => 'BS. Đào Hồng Luyến',
                        'title' => 'Sáng lập / Giám đốc chuyên môn',
                        'image' => 'https://images.unsplash.com/photo-1559839734-2b71ea197ec2?auto=format&fit=crop&w=600&q=80',
                    ],
                    [
                        'name'  => 'BS. Nguyễn Tuấn Việt',
                        'title' => 'Trưởng khoa Chỉnh nha',
                        'image' => 'https://images.unsplash.com/photo-1612531385446-f7e6d131e1d0?auto=format&fit=crop&w=600&q=80',
                    ],
                    [
                        'name'  => 'BS. Bùi Gia Huy',
                        'title' => 'Trưởng khoa Implant',
                        'image' => 'https://images.unsplash.com/photo-1622253692010-333f2da6031d?auto=format&fit=crop&w=600&q=80',
                    ],
                    [
                        'name'  => 'BS. Lê Thị Hà',
                        'title' => 'Trưởng khoa Thẩm mỹ',
                        'image' => 'https://images.unsplash.com/photo-1551836022-deb4988cc6c0?auto=format&fit=crop&w=600&q=80',
                    ],
                ];
            @endphp

            <div class="grid grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach ($leaders as $ld)
                    <div class="group text-center">
                        <div class="relative overflow-hidden rounded-3xl shadow-md
                                    hover:shadow-xl transition mb-4 aspect-[3/4]">
                            <img src="{{ $ld['image'] }}" alt="{{ $ld['name'] }}"
                                 class="w-full h-full object-cover
                                        group-hover:scale-105 transition duration-500">
                            <div class="absolute inset-0 bg-gradient-to-t
                                        from-sky-900/60 via-transparent to-transparent
                                        opacity-0 group-hover:opacity-100 transition"></div>
                        </div>
                        <h3 class="font-bold text-slate-900">{{ $ld['name'] }}</h3>
                        <p class="text-sm text-sky-600 mt-1">{{ $ld['title'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    {{-- 8. CHỨNG NHẬN & GIẢI THƯỞNG --}}
    <section class="py-20 md:py-24 bg-slate-50">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">

            <div class="flex flex-col items-center text-center mb-14">
                <h2 class="inline-block rounded-full bg-sky-100
                           px-6 md:px-10 py-3 md:py-4
                           text-2xl md:text-3xl lg:text-4xl font-bold text-slate-800
                           mb-5 leading-tight">
                    Chứng nhận &amp; <span class="text-sky-600">giải thưởng</span>
                </h2>
                <p class="max-w-2xl mx-auto text-slate-500 text-base md:text-lg">
                    Sự công nhận của các tổ chức uy tín trong và ngoài nước.
                </p>
            </div>

            @php
                $awards = [
                    ['icon' => '🏆', 'title' => 'ISO 9001:2015', 'desc' => 'Hệ thống quản lý chất lượng quốc tế'],
                    ['icon' => '🥇', 'title' => 'Top 10 Nha khoa 2024', 'desc' => 'Hiệp hội Nha khoa Việt Nam'],
                    ['icon' => '⭐', 'title' => 'Thương hiệu tin cậy', 'desc' => 'Người tiêu dùng bình chọn 2023'],
                    ['icon' => '🎖️', 'title' => 'Đối tác Straumann', 'desc' => 'Implant Thụy Sĩ chính hãng'],
                ];
            @endphp

            <div class="grid grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach ($awards as $aw)
                    <div class="bg-white rounded-2xl p-6 text-center
                                border border-slate-100 shadow-sm
                                hover:shadow-md hover:border-sky-200 transition">
                        <div class="text-5xl mb-3">{{ $aw['icon'] }}</div>
                        <h3 class="font-bold text-slate-900 mb-1">{{ $aw['title'] }}</h3>
                        <p class="text-xs text-slate-500">{{ $aw['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    {{-- 9. CAM KẾT VỚI KHÁCH HÀNG --}}
    <section class="py-20 md:py-24 bg-white">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">

            <div class="flex flex-col items-center text-center mb-14">
                <h2 class="inline-block rounded-full bg-sky-100
                           px-6 md:px-10 py-3 md:py-4
                           text-2xl md:text-3xl lg:text-4xl font-bold text-slate-800
                           mb-5 leading-tight">
                    Cam kết với <span class="text-sky-600">khách hàng</span>
                </h2>
                <p class="max-w-2xl mx-auto text-slate-500 text-base md:text-lg">
                    5 cam kết bằng văn bản cho từng dịch vụ tại MediConnect.
                </p>
            </div>

            @php
                $promises = [
                    ['num' => '01', 'title' => 'Tư vấn miễn phí',       'desc' => 'Mọi khách hàng đều được tư vấn miễn phí, không bắt buộc sử dụng dịch vụ.'],
                    ['num' => '02', 'title' => 'Bảo hành dài hạn',      'desc' => 'Implant bảo hành đến 25 năm, niềng răng 5 năm, răng sứ 10-15 năm.'],
                    ['num' => '03', 'title' => 'Hoàn tiền nếu không hài lòng', 'desc' => 'Hoàn 100% trong vòng 7 ngày nếu chưa thực hiện điều trị.'],
                    ['num' => '04', 'title' => 'Tái khám miễn phí',     'desc' => 'Miễn phí tái khám trọn đời sau khi hoàn tất điều trị.'],
                    ['num' => '05', 'title' => 'Bảo mật thông tin',     'desc' => 'Hồ sơ y tế và thông tin cá nhân được bảo mật tuyệt đối.'],
                ];
            @endphp

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($promises as $p)
                    <div class="relative bg-gradient-to-br from-white to-sky-50/40
                                rounded-2xl p-6 border border-slate-100
                                hover:shadow-lg hover:border-sky-200 transition">
                        <div class="absolute top-4 right-4 text-5xl font-black
                                    text-sky-100 leading-none select-none">
                            {{ $p['num'] }}
                        </div>
                        <div class="relative pr-12">
                            <h3 class="font-bold text-slate-900 mb-2 text-lg">
                                {{ $p['title'] }}
                            </h3>
                            <p class="text-sm text-slate-600 leading-relaxed">
                                {{ $p['desc'] }}
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    {{-- 10. CTA --}}
    <section class="py-20 md:py-24 px-4 md:px-8 lg:px-16">
        <div class="max-w-7xl mx-auto bg-gradient-to-r from-sky-500 to-cyan-500
                    p-10 md:p-16 text-center text-white
                    rounded-3xl shadow-md relative overflow-hidden">

            <div class="absolute -top-20 -right-20 w-60 h-60 rounded-full bg-white/10"></div>
            <div class="absolute -bottom-20 -left-20 w-80 h-80 rounded-full bg-white/10"></div>
        </div>
    </section>
</main>

@include('components.footer')
<script src="{{ asset('js/auth.js') }}" defer></script>
</body>
</html>
