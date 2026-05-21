<section
    class="w-full h-124 flex items-center px-[8%]
           bg-no-repeat bg-top bg-size-[100%_auto]"
    style="background-image: url('{{ asset('img/bg1.png') }}');">

    <!-- HERO CONTENT -->
    <div class="w-1/2">
        <!-- TAG -->
        <span
            class="inline-flex items-center gap-2.5
                   bg-[rgba(66,153,225,0.15)]
                   border border-[rgba(66,153,225,0.25)]
                   backdrop-blur-sm
                   px-5.5 py-3
                   rounded-full
                   text-[16px] font-bold text-[#2b6cb0]
                   mb-7">
            ✨ Nha khoa tiêu chuẩn quốc tế
        </span>

        <!-- TITLE -->
        <h2
            class="text-[36px] leading-[1.1]
                   font-bold text-[#1a237e]
                   mb-6">
            Nụ cười hoàn hảo <br>
            Tự tin tỏa sáng
        </h2>

        <!-- DESCRIPTION -->
        <p
            class="text-[20px] leading-[1.8]
                   text-[#4a5568]
                   max-w-155
                   mb-10">
            Công nghệ nha khoa hiện đại hàng đầu,
            đội ngũ bác sĩ giàu kinh nghiệm,
            mang đến trải nghiệm chăm sóc tốt nhất.
        </p>

        <!-- BUTTONS -->
        <div class="flex gap-5">

            <!-- PRIMARY -->
            @auth
                <a href="/appointment"
                   class="inline-flex items-center justify-center
                          no-underline
                          bg-[linear-gradient(135deg,#1e90ff,#0066ff)]
                          text-white
                          border-0
                          rounded-[18px]
                          px-9 py-4.5
                          text-[18px] font-bold
                          cursor-pointer
                          transition-all duration-300
                          shadow-[0_10px_25px_rgba(30,144,255,0.25)]
                          hover:-translate-y-0.75">
                    Đặt lịch ngay
                </a>
            @endauth

            @guest
                <button
                    class="inline-flex items-center justify-center
                           bg-[linear-gradient(135deg,#1e90ff,#0066ff)]
                           text-white
                           border-0
                           rounded-[18px]
                           px-9 py-4.5
                           text-[18px] font-bold
                           cursor-pointer
                           transition-all duration-300
                           shadow-[0_10px_25px_rgba(30,144,255,0.25)]
                           hover:-translate-y-0.75
                           btn-login_popup">
                    Đặt lịch ngay
                </button>
            @endguest

            <!-- SECONDARY -->
            <button
                class="bg-[rgba(255,255,255,0.75)]
                       text-[#1e4db7]
                       border border-[rgba(30,144,255,0.2)]
                       rounded-[18px]
                       px-[36px] py-[18px]
                       text-[18px] font-bold
                       backdrop-blur-[10px]
                       cursor-pointer
                       transition-all duration-300
                       hover:bg-white
                       hover:-translate-y-[3px]">
                Tìm hiểu thêm
            </button>

        </div>
    </div>
</section>
