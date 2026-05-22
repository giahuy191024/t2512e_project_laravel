<section class="py-20 md:py-24 bg-white">

    <style>
        .branch-card { background: white; border-color: #e2e8f0; }
        .branch-card:hover {
            border-color: #38bdf8;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(2, 132, 199, 0.1);
        }
        .branch-card.active {
            border-color: #0284c7;
            background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
            box-shadow: 0 12px 28px rgba(2, 132, 199, 0.15);
        }
        .branch-card.active .branch-dot { background: linear-gradient(180deg, #0284c7, #06b6d4); }
        .branch-card.active .branch-icon { color: #0284c7; }
        .branch-dot { background: #94a3b8; }
        .branch-icon { color: #64748b; }
    </style>

    <div class="max-w-7xl mx-auto px-6 lg:px-8">

        {{-- HEADER --}}
        <div class="flex flex-col items-center text-center mb-14">
            <h2 class="inline-block rounded-full bg-sky-100 px-6 md:px-10 py-3 md:py-4
                       text-2xl md:text-3xl lg:text-4xl font-bold text-slate-800 mb-5 leading-tight">
                Mạng lưới <span class="text-sky-600">MediConnect</span> toàn quốc
            </h2>
            <p class="max-w-2xl mx-auto text-base md:text-lg text-slate-500 leading-8">
                Hãy chọn cơ sở gần bạn nhất để nhận được sự chăm sóc
                nhanh chóng và chu đáo từ đội ngũ của chúng tôi.
            </p>
        </div>

        @php
            $branches = [
                [
                    'name'    => 'Hà Nội',
                    'badge'   => 'Trụ sở chính',
                    'address' => '13 Phan Tây Nhạc, Xuân Phương, Hà Nội',
                    'hotline' => '1900 6000 (Phím 1)',
                    'hours'   => '08:00 - 20:00 (Thứ 2 - Chủ Nhật)',
                    'query'   => '13 Phan Tây Nhạc, Xuân Phương, Nam Từ Liêm, Hà Nội',
                ],
                [
                    'name'    => 'TP. Hồ Chí Minh',
                    'badge'   => null,
                    'address' => '456 Đường Nguyễn Thị Minh Khai, Quận 3, TP. HCM',
                    'hotline' => '1900 6000 (Phím 2)',
                    'hours'   => '08:00 - 20:00 (Thứ 2 - Chủ Nhật)',
                    'query'   => '456 Nguyễn Thị Minh Khai, Quận 3, TP HCM',
                ],
                [
                    'name'    => 'Đà Nẵng',
                    'badge'   => null,
                    'address' => '789 Đường Lê Duẩn, Quận Hải Châu, Đà Nẵng',
                    'hotline' => '1900 6000 (Phím 3)',
                    'hours'   => '08:00 - 17:30 (Thứ 2 - Thứ 7)',
                    'query'   => '789 Lê Duẩn, Hải Châu, Đà Nẵng',
                ],
            ];
        @endphp

        {{-- LAYOUT --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-stretch">

            {{-- MAP --}}
            <div class="w-full min-h-[450px] lg:min-h-[600px]
                        bg-slate-100 rounded-3xl overflow-hidden
                        shadow-sm border border-slate-100 relative
                        order-2 lg:order-1">
                <iframe id="branchMap"
                        src="https://www.google.com/maps?q={{ urlencode($branches[0]['query']) }}&z=16&output=embed"
                        class="w-full h-full absolute inset-0 border-0"
                        allowfullscreen=""
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>

            {{-- CARDS --}}
            <div class="flex flex-col gap-4 justify-center order-1 lg:order-2">
                @foreach ($branches as $i => $b)
                    <button type="button"
                            data-query="{{ urlencode($b['query']) }}"
                            class="branch-card {{ $i === 0 ? 'active' : '' }}
                                   text-left p-6 rounded-3xl border-2
                                   transition-all duration-300 relative cursor-pointer">

                        @if ($b['badge'])
                            <span class="absolute top-6 right-6 px-3 py-1
                                         bg-gradient-to-r from-sky-500 to-cyan-500
                                         text-white text-xs font-bold rounded-full shadow-md">
                                {{ $b['badge'] }}
                            </span>
                        @endif

                        <h3 class="text-xl font-bold text-slate-800 mb-4 flex items-center gap-2 pr-28">
                            <span class="branch-dot w-2 h-5 rounded-full"></span>
                            Cơ sở {{ $b['name'] }}
                        </h3>

                        <div class="space-y-3 text-slate-600 text-sm">
                            <p class="flex items-start gap-2.5">
                                <svg class="branch-icon w-5 h-5 shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25s-7.5-4.108-7.5-11.25a7.5 7.5 0 1115 0z"/>
                                </svg>
                                <span><strong>Địa chỉ:</strong> {{ $b['address'] }}</span>
                            </p>
                            <p class="flex items-center gap-2.5">
                                <svg class="branch-icon w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-2.824-1.657-5.191-4.023-6.857-6.857l1.293-.97c.362-.272.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z"/>
                                </svg>
                                <span><strong>Hotline:</strong> {{ $b['hotline'] }}</span>
                            </p>
                            <p class="flex items-center gap-2.5">
                                <svg class="branch-icon w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span><strong>Giờ làm việc:</strong> {{ $b['hours'] }}</span>
                            </p>
                        </div>
                    </button>
                @endforeach
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const mapFrame = document.getElementById('branchMap');

            document.querySelectorAll('.branch-card').forEach((card) => {
                card.addEventListener('click', function() {
                    const query = this.dataset.query;
                    mapFrame.src = `https://www.google.com/maps?q=${query}&z=16&output=embed`;

                    document.querySelectorAll('.branch-card').forEach(c => c.classList.remove('active'));
                    this.classList.add('active');
                });
            });
        });
    </script>
</section>
