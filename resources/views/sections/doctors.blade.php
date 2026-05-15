<section class="doctors" id="doctors">

    <div class="doctors-header">

        <span class="doctors-tag">
            ĐỘI NGŨ BÁC SĨ
        </span>

        <h2>
            Chuyên gia nha khoa hàng đầu
        </h2>

        <p>
            Đội ngũ bác sĩ tại MediConnect được đào tạo chuyên sâu,
            giàu kinh nghiệm và luôn cập nhật những công nghệ điều trị hiện đại nhất.
        </p>

    </div>

    <!-- Featured Doctor -->
    @if($featuredDoctor)

        <div class="featured-doctor">

            <div class="featured-doctor-image">
                <img src="{{ asset($featuredDoctor->image) }}" alt="">
            </div>

            <div class="featured-doctor-content">

                <h3>
                    {{ $featuredDoctor->full_name }}
                </h3>

                <ul>
                    {{--                    <li>--}}
                    {{--                        {{ $featuredDoctor->experience_years }}--}}
                    {{--                        năm kinh nghiệm--}}
                    {{--                    </li>--}}

                    {{--                    <li>--}}
                    {{--                        {{ $featuredDoctor->specialty }}--}}
                    {{--                    </li>--}}
                    @foreach(explode("\n", $featuredDoctor->highlights ?? '') as $item)

                        @if(trim($item))

                            <li>{{ $item }}</li>

                        @endif

                    @endforeach

                </ul>

                <div class="featured-buttons">

                    <button class="doctor-detail-btn"
                            onclick='openDoctorModal(
                                @json($featuredDoctor->full_name),
                                @json($featuredDoctor->bio)
                            )'>

                        Xem thêm

                    </button>

                    @auth
                        <a href="/appointment"
                           class="doctor-book-btn">

                            Đặt lịch ngay

                        </a>
                    @endauth

                    @guest
                        <button class="doctor-book-btn btn-login_popup">

                            Đặt lịch ngay

                        </button>
                    @endguest

                </div>

            </div>

        </div>

    @endif

    <!-- Tabs -->
    <div class="doctor-tabs">

        <button class="doctor-tab active" onclick="changeRegion('north', this)">
            Miền Bắc
        </button>

        <button class="doctor-tab" onclick="changeRegion('central', this)">
            Miền Trung
        </button>

        <button class="doctor-tab" onclick="changeRegion('south', this)">
            Miền Nam
        </button>

    </div>

    <!-- Doctors Grid -->
    <!-- Miền Bắc -->
    <div class="doctors-grid doctor-region"
         id="north">

        @foreach($northDoctors as $doctor)

            <div class="doctor-card">

                <img src="{{ asset($doctor->image) }}" alt="">

                <div class="doctor-card-content">

                    <h4>
                        {{ $doctor->full_name }}
                    </h4>

                    <button
                        onclick='openDoctorModal(
                            @json($doctor->full_name),
                            @json(
                                "Chuyên môn: {$doctor->specialty}\n\n" .
                                "Kinh nghiệm: {$doctor->experience_years} năm\n\n" .
                                $doctor->bio
            )
        )'>
                        Xem thêm
                    </button>

                </div>

            </div>

        @endforeach

    </div>

    <!-- Miền Trung -->
    <div class="doctors-grid doctor-region"
         id="central"
         style="display:none;">

        @foreach($centralDoctors as $doctor)

            <div class="doctor-card">

                <img src="{{ asset($doctor->image) }}" alt="">

                <div class="doctor-card-content">

                    <h4>
                        {{ $doctor->full_name }}
                    </h4>

                    <button
                        onclick='openDoctorModal(
                            @json($doctor->full_name),
                            @json(
                                "Chuyên môn: {$doctor->specialty}\n\n" .
                                "Kinh nghiệm: {$doctor->experience_years} năm\n\n" .
                                $doctor->bio
            )
        )'>
                        Xem thêm
                    </button>

                </div>

            </div>

        @endforeach

    </div>

    <!-- Miền Nam -->
    <div class="doctors-grid doctor-region"
         id="south"
         style="display:none;">

        @foreach($southDoctors as $doctor)

            <div class="doctor-card">

                <img src="{{ asset($doctor->image) }}" alt="">

                <div class="doctor-card-content">

                    <h4>
                        {{ $doctor->full_name }}
                    </h4>

                    <button
                        onclick='openDoctorModal(
                            @json($doctor->full_name),
                            @json(
                                "Chuyên môn: {$doctor->specialty}\n\n" .
                                "Kinh nghiệm: {$doctor->experience_years} năm\n\n" .
                                $doctor->bio
                            )
        )'>

                        Xem thêm

                    </button>

                </div>

            </div>

        @endforeach

    </div>

</section>

<!-- Modal -->
<div class="doctor-modal" id="doctorModal">

    <div class="doctor-modal-box">

        <span class="doctor-modal-close"
              onclick="closeDoctorModal()">
            &times;
        </span>

        <h3 id="modalDoctorName"></h3>

        <p id="modalDoctorInfo"></p>

    </div>

</div>
