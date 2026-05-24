<header id="siteHeader"
        class=" fixed top-0 left-0 z-50 w-full bg-white px-8 lg:px-16
               transition-all duration-300 shadow-[0_4px_18px_rgba(0,0,0,0.06)]">
    <div id="headerInner"
         class="flex items-center justify-between mx-auto max-w-7xl
                h-24 md:h-32 transition-all duration-300">

        {{-- LOGO --}}
        <div class="shrink-0 " style="margin-left: 24px;">
            <a href="{{ url('/') }}" class="block">
                <img id="siteLogo" src="{{ asset('img/logo2.png') }}" alt="logo"
                     class="h-16 md:h-24 object-contain transition-all duration-300">
            </a>
        </div>

        {{-- MENU DESKTOP --}}
        <nav class="hidden lg:flex items-center gap-6 xl:gap-10">

            <a href="{{ url('/') }}"
               class="{{ request()->is('/') ? 'text-black font-bold' : 'text-blue-500' }}
                      rounded-full px-5 py-3 text-base font-bold transition
                      hover:bg-slate-100 hover:text-blue-700">
                TRANG CHỦ
            </a>

            <a href="{{ url('/about') }}"
               class="{{ Request::is('about') ? 'text-black font-bold' : 'text-blue-500' }}
                      rounded-full px-5 py-3 text-base font-bold transition
                      hover:bg-slate-100 hover:text-blue-700">
                GIỚI THIỆU
            </a>

            {{-- DỊCH VỤ + dropdown --}}
            <div class="relative group">
                <a href="{{ url('/services') }}"
                   class="{{ Request::is('services*') ? 'text-black font-bold' : 'text-blue-500' }}
                          inline-flex items-center gap-1 rounded-full px-5 py-3 text-base font-bold transition
                          hover:bg-slate-100 hover:text-blue-700">
                    DỊCH VỤ

                </a>
            </div>
            {{-- TIN TỨC + dropdown --}}
            <div class="relative group">
                <a href="{{ url('/news') }}"
                   class="{{ Request::is('news*') ? 'text-black font-bold' : 'text-blue-500' }}
                          inline-flex items-center gap-1 rounded-full px-5 py-3 text-base font-bold transition
                          hover:bg-slate-100 hover:text-blue-700">
                    TIN TỨC
                </a>
                <div class="invisible opacity-0 translate-y-2 group-hover:visible
                            group-hover:opacity-100 group-hover:translate-y-0
                            absolute left-0 top-full pt-3 min-w-55 z-50
                            transition-all duration-200">
                </div>
            </div>

            <a href="{{ url('/contact') }}"
               class="{{ Request::is('contact') ? 'text-black font-bold' : 'text-blue-500' }}
                      rounded-full px-5 py-3 text-base font-bold transition
                      hover:bg-slate-100 hover:text-blue-700">
                LIÊN HỆ
            </a>
        </nav>

        {{-- RIGHT --}}
        <div class="flex items-center gap-3 md:gap-4 shrink-0">

            <input type="text" placeholder="Tìm kiếm..."
                   class="hidden md:block h-12 w-48 lg:w-64  rounded-2xl border border-gray-300 text-base outline-none focus:border-blue-500"
                   style="padding-left: 24px; padding-right: 24px;">

            <a href="tel:19006900" class="hidden md:block font-bold text-red-600 whitespace-nowrap">
                1900.6900
            </a>

            <button type="button"
                    class="btn-login_popup !h-12 !w-28 lg:!w-32 !rounded-full !bg-green-600
                   !px-6 !text-base !font-semibold !text-white
                   hover:!bg-green-700 transition duration-300">
                Log In
            </button>

            {{-- HAMBURGER - chỉ hiện mobile --}}
            <button id="mobileMenuBtn" type="button" aria-label="Mở menu"
                    class="lg:hidden text-3xl leading-none text-slate-700 hover:text-slate-900">
                ☰
            </button>

        </div>
    </div>

    {{-- MOBILE MENU --}}
    <div id="mobileMenu" class="hidden border-t bg-white px-4 py-4 lg:hidden">
        <nav class="flex flex-col">

            <a href="{{ url('/') }}" class="py-3 font-semibold text-blue-500 border-b border-gray-100">
                TRANG CHỦ
            </a>
            <a href="{{ url('/about') }}" class="py-3 font-semibold text-blue-500 border-b border-gray-100">
                GIỚI THIỆU
            </a>

            {{-- Dịch vụ - accordion --}}
            <div class="border-b border-gray-100">
                <button type="button"
                        class="mobile-submenu-toggle w-full flex items-center justify-between py-3 font-semibold text-blue-500"
                        data-target="submenu-services">
                    DỊCH VỤ
                    <svg class="w-4 h-4 transition-transform" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                              d="M5.23 7.21a.75.75 0 011.06.02L10 11.06l3.71-3.83a.75.75 0 111.08 1.04l-4.25 4.39a.75.75 0 01-1.08 0L5.21 8.27a.75.75 0 01.02-1.06z"
                              clip-rule="evenodd"/>
                    </svg>
                </button>
            </div>

            {{-- Tin tức - accordion --}}
            <div class="border-b border-gray-100">
                <button type="button"
                        class="mobile-submenu-toggle w-full flex items-center justify-between py-3 font-semibold text-blue-500"
                        data-target="submenu-news">
                    TIN TỨC
                    <svg class="w-4 h-4 transition-transform" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                              d="M5.23 7.21a.75.75 0 011.06.02L10 11.06l3.71-3.83a.75.75 0 111.08 1.04l-4.25 4.39a.75.75 0 01-1.08 0L5.21 8.27a.75.75 0 01.02-1.06z"
                              clip-rule="evenodd"/>
                    </svg>
                </button>
            </div>

            <a href="{{ url('/contact') }}" class="py-3 font-semibold text-blue-500">
                LIÊN HỆ
            </a>

            <input type="text" placeholder="Tìm kiếm..."
                   class="mt-3 rounded-md border border-gray-300 px-3 py-2 outline-none">

            <a href="tel:19006900" class="mt-2 font-bold text-red-600">
                Hotline: 1900.6900
            </a>
        </nav>
    </div>
</header>

