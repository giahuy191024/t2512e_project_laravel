<footer class="bg-slate-900 text-slate-300 pt-16 pb-8 ml-6 border-t border-slate-800">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">

        {{-- ===== TOP GRID ===== --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-10 mb-12">

            {{-- Logo + Description + Social --}}
            <div class="lg:col-span-4">
                <a href="{{ url('/') }}" class="inline-block mb-4">
                    <span class=" text-3xl font-black tracking-wider text-white">
                        Medi<span class="text-sky-500">Connect</span>
                    </span>
                </a>
                <p class="text-sm text-slate-400 leading-7 mb-5 pr-4">
                    Hệ thống nha khoa hiện đại, đồng hành cùng hàng nghìn khách hàng
                    trên hành trình <br> chăm sóc nụ cười khỏe đẹp.
                </p>

                <div class="flex gap-3">
                    <a href="#" aria-label="Facebook"
                       class="group w-10 h-10 rounded-full bg-slate-800
                              hover:bg-sky-600 flex items-center justify-center
                              transition duration-300">
                        <svg class="w-4 h-4 text-slate-400 group-hover:text-white transition"
                             fill="currentColor" viewBox="0 0 24 24">
                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                        </svg>
                    </a>
                    <a href="#" aria-label="LinkedIn"
                       class="group w-10 h-10 rounded-full bg-slate-800
                              hover:bg-sky-500 flex items-center justify-center
                              transition duration-300">
                        <svg class="w-4 h-4 text-slate-400 group-hover:text-white transition"
                             fill="currentColor" viewBox="0 0 24 24">
                            <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.063 2.063 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                        </svg>
                    </a>
                    <a href="#" aria-label="YouTube"
                       class="group w-10 h-10 rounded-full bg-slate-800
                              hover:bg-red-600 flex items-center justify-center
                              transition duration-300">
                        <svg class="w-4 h-4 text-slate-400 group-hover:text-white transition"
                             fill="currentColor" viewBox="0 0 24 24">
                            <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                        </svg>
                    </a>
                </div>
            </div>

            {{-- Dịch vụ --}}
            <div class="lg:col-span-2">
                <h4 class="text-white font-bold text-base mb-5 relative pb-2
                           after:content-[''] after:absolute after:bottom-0 after:left-0
                           after:w-8 after:h-0.5 after:bg-sky-500">
                    Dịch vụ
                </h4>
                <ul class="space-y-3 text-sm text-slate-400">
                    @foreach (['Trồng răng Implant', 'Niềng răng Invisalign', 'Răng sứ thẩm mỹ', 'Nha khoa trẻ em'] as $svc)
                        <li>
                            <a href="#" class="hover:text-sky-400 hover:translate-x-1
                                              inline-block transition duration-200">
                                {{ $svc }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            {{-- Liên kết --}}
            <div class="lg:col-span-2">
                <h4 class="text-white font-bold text-base mb-5 relative pb-2
                           after:content-[''] after:absolute after:bottom-0 after:left-0
                           after:w-8 after:h-0.5 after:bg-sky-500">
                    Liên kết nhanh
                </h4>
                <ul class="space-y-3 text-sm text-slate-400">
                    @foreach ([
                        ['url' => '/',         'label' => 'Trang chủ'],
                        ['url' => '/about',    'label' => 'Giới thiệu'],
                        ['url' => '/services', 'label' => 'Dịch vụ'],
                        ['url' => '/booking',  'label' => 'Đặt lịch'],
                    ] as $link)
                        <li>
                            <a href="{{ url($link['url']) }}"
                               class="hover:text-sky-400 hover:translate-x-1
                                      inline-block transition duration-200">
                                {{ $link['label'] }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            {{-- Liên hệ --}}
            <div class="lg:col-span-4">
                <h4 class="text-white font-bold text-base mb-5 relative pb-2
                           after:content-[''] after:absolute after:bottom-0 after:left-0
                           after:w-8 after:h-0.5 after:bg-sky-500">
                    Liên hệ
                </h4>
                <ul class="space-y-3.5 text-sm text-slate-400">
                    <li class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-sky-500 shrink-0 mt-0.5"
                             fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25s-7.5-4.108-7.5-11.25a7.5 7.5 0 1115 0z"/>
                        </svg>
                        <a href="https://maps.app.goo.gl/wUmJaJ7cDTiSyywq7"
                           target="_blank" rel="noopener noreferrer"
                           class="hover:text-sky-400 transition group inline-flex items-start gap-1">
                            <span>13 Phan Tây Nhạc, Xuân Phương, Hà Nội</span>
                            <svg class="w-3.5 h-3.5 mt-1 shrink-0 opacity-60 group-hover:opacity-100 transition"
                                 fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25"/>
                            </svg>
                        </a>
                    </li>
                    <li class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-sky-500 shrink-0"
                             fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-2.824-1.657-5.191-4.023-6.857-6.857l1.293-.97c.362-.272.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z"/>
                        </svg>
                        <a href="tel:19006900" class="hover:text-sky-400 transition">1900 6900</a>
                    </li>
                    <li class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-sky-500 shrink-0"
                             fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/>
                        </svg>
                        <a href="mailto:support@mediconnect.vn"
                           class="hover:text-sky-400 transition truncate">
                            support@mediconnect.vn
                        </a>
                    </li>
                    <li class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-sky-500 shrink-0"
                             fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span>08:00 - 20:00 (T2 - CN)</span>
                    </li>
                </ul>
            </div>
        </div>

        {{-- ===== BOTTOM BAR ===== --}}
        <div class="pt-6 border-t border-slate-800/80
                    flex flex-col md:flex-row items-center justify-center gap-4
                    text-xs text-slate-500">
            <p>© 2026 MediConnect. All rights reserved.</p>
            <div class="flex items-center gap-5">
                <a href="#" class="hover:text-sky-400 transition">Chính sách bảo mật</a>
                <a href="#" class="hover:text-sky-400 transition">Điều khoản sử dụng</a>
                <a href="#" class="hover:text-sky-400 transition">Sitemap</a>
            </div>
        </div>
    </div>
</footer>
