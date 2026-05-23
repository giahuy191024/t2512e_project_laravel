@extends('layouts.patient')
@section('title', 'Hồ sơ cá nhân')

@push('styles')
    <style>
        .profile-hero {
            background: linear-gradient(135deg, #1a73e8 0%, #0d47a1 100%);
            border-radius: 16px;
            padding: 32px 28px;
            color: #fff;
            margin-bottom: 24px;
            position: relative;
            overflow: hidden;
        }
        .profile-hero::before {
            content: '\f007';
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            font-size: 140px;
            position: absolute;
            right: -10px; top: -20px;
            opacity: .08; color: #fff;
        }
        .profile-hero h2 { font-size: 1.7rem; font-weight: 800; margin-bottom: 4px; }
        .profile-hero p { opacity: .85; margin: 0; }

        .profile-card {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 2px 14px rgba(0,0,0,.06);
            padding: 28px 32px;
            margin-bottom: 20px;
        }
        .profile-section-title {
            font-size: .82rem; font-weight: 700;
            color: #1a73e8; text-transform: uppercase;
            letter-spacing: .5px; margin-bottom: 16px;
            padding-bottom: 8px; border-bottom: 2px solid #e8f0fe;
        }
        .form-label-bold {
            font-size: .78rem; font-weight: 600;
            color: #5f6368; text-transform: uppercase;
            letter-spacing: .3px;
        }
        .form-control {
            border-radius: 10px;
            border: 1.5px solid #dadce0;
            font-size: .92rem;
            padding: 10px 14px;
        }
        .form-control:focus {
            border-color: #1a73e8;
            box-shadow: 0 0 0 3px rgba(26,115,232,.15);
        }
        .form-control[readonly] {
            background: #f8f9fa; color: #5f6368;
        }
        .btn-save {
            background: linear-gradient(135deg, #1a73e8, #0d47a1);
            color: #fff; border: none; border-radius: 10px;
            padding: 10px 32px; font-weight: 700;
            transition: transform .15s, box-shadow .15s;
        }
        .btn-save:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(26,115,232,.35);
            color: #fff;
        }
        .avatar-wrap {
            text-align: center;
            margin-bottom: 24px;
        }
        .avatar-circle {
            width: 120px; height: 120px;
            border-radius: 50%;
            margin: 0 auto;
            border: 4px solid #e8f0fe;
            background: linear-gradient(135deg, #1a73e8, #0d47a1);
            display: flex; align-items: center; justify-content: center;
            color: #fff; font-size: 3rem; font-weight: 700;
        }
    </style>
@endpush

@section('content')

    <div class="profile-hero">
        <h2><i class="far fa-id-card mr-2"></i> Hồ sơ cá nhân</h2>
        <p>Cập nhật thông tin để bác sĩ liên hệ và chăm sóc bạn tốt hơn</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <i class="fas fa-check-circle mr-1"></i> {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <ul class="mb-0">
                @foreach($errors->all() as $err) <li>{{ $err }}</li> @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('patient.profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- AVATAR --}}
        <div class="profile-card">
            <div class="avatar-wrap">
                @if($user->avatar_url)
                    <img src="{{ asset('storage/' . $user->avatar_url) }}"
                         class="avatar-circle"
                         style="object-fit:cover"
                         alt="Avatar">
                @else
                    <div class="avatar-circle">
                        {{ strtoupper(mb_substr($user->full_name ?? 'U', 0, 1)) }}
                    </div>
                @endif

                <div class="mt-3">
                    <label for="avatarInput" class="btn btn-outline-primary btn-sm rounded-pill">
                        <i class="fas fa-camera mr-1"></i> Đổi ảnh đại diện
                    </label>
                    <input type="file" id="avatarInput" name="avatar" accept="image/*"
                           style="display:none" onchange="document.getElementById('avatarFileName').textContent = this.files[0]?.name || ''">
                    <div id="avatarFileName" class="mt-2" style="color:#1a73e8;font-size:.85rem;font-weight:600"></div>
                </div>

                <div class="mt-2" style="color:#5f6368;font-size:.78rem">
                    Định dạng: JPG, PNG. Tối đa 2MB.
                </div>
                <div class="mt-1" style="color:#9aa0a6;font-size:.78rem">
                    Tài khoản tạo ngày {{ $user->created_at?->format('d/m/Y') }}
                </div>
            </div>
        </div>

        {{-- THÔNG TIN TÀI KHOẢN --}}
        <div class="profile-card">
            <div class="profile-section-title">
                <i class="fas fa-user mr-1"></i> 1. Thông tin tài khoản
            </div>

            <div class="row">
                <div class="form-group col-md-6">
                    <label class="form-label-bold">Họ và tên</label>
                    <input type="text" name="full_name" class="form-control"
                           value="{{ old('full_name', $user->full_name) }}" required>
                </div>
                <div class="form-group col-md-6">
                    <label class="form-label-bold">Email (đăng nhập)</label>
                    <input type="email" class="form-control" value="{{ $user->email }}" readonly>
                    <small class="text-muted">Email đăng nhập không thể thay đổi</small>
                </div>
            </div>
        </div>

        {{-- THÔNG TIN LIÊN HỆ --}}
        <div class="profile-card">
            <div class="profile-section-title">
                <i class="fas fa-address-book mr-1"></i> 2. Thông tin liên hệ
            </div>

            <div class="row">
                <div class="form-group col-md-6">
                    <label class="form-label-bold">Số điện thoại</label>
                    <input type="text" name="phone_number" class="form-control"
                           value="{{ old('phone_number', $patient?->phone_number) }}"
                           placeholder="VD: 0901234567">
                </div>
                <div class="form-group col-md-12">
                    <label class="form-label-bold">Địa chỉ</label>
                    <input type="text" name="address_line" class="form-control"
                           value="{{ old('address_line', $patient?->address_line) }}"
                           placeholder="Số nhà, tên đường...">
                </div>
                <div class="form-group col-md-4">
                    <label class="form-label-bold">Tỉnh/Thành phố</label>
                    <select name="city" id="citySelect" class="form-control">
                        <option value="">-- Chọn Tỉnh/Thành phố --</option>
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label class="form-label-bold">Quận/Huyện</label>
                    <select name="district" id="districtSelect" class="form-control" disabled>
                        <option value="">-- Chọn Quận/Huyện --</option>
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label class="form-label-bold">Phường/Xã</label>
                    <select name="ward" id="wardSelect" class="form-control" disabled>
                        <option value="">-- Chọn Phường/Xã --</option>
                    </select>
                </div>
            </div>
        </div>

        {{-- NÚT LƯU --}}
        <div class="text-right mt-3">
            <button type="submit" class="btn btn-save">
                <i class="fas fa-save mr-1"></i> Lưu thay đổi
            </button>
        </div>
    </form>
@endsection
@push('scripts')
    <script>
        const API = 'https://provinces.open-api.vn/api'; //url API

        const citySelect     = document.getElementById('citySelect');
        const districtSelect = document.getElementById('districtSelect');
        const wardSelect     = document.getElementById('wardSelect');

        // Data đang lưu trong DB của user (lúc render)
        const currentCity     = @json($patient?->city ?? '');
        const currentDistrict = @json($patient?->district ?? '');
        const currentWard     = @json($patient?->ward ?? '');

        // === STEP 1: Load tất cả tỉnh/thành ===
        fetch(`${API}/p/`) //call api tỉnh
            .then(r => r.json())
            .then(provinces => {
                provinces.forEach(p => {
                    const opt = new Option(p.name, p.name);
                    opt.dataset.code = p.code;
                    if (p.name === currentCity) opt.selected = true;
                    citySelect.add(opt);
                });
                // Nếu user đã có city → tự load district
                const sel = citySelect.options[citySelect.selectedIndex];
                if (sel && sel.dataset.code) loadDistricts(sel.dataset.code);
            });

        // === STEP 2: Khi chọn city → load district ===
        citySelect.addEventListener('change', function() {
            const code = this.options[this.selectedIndex].dataset.code;
            resetSelect(districtSelect, '-- Chọn Quận/Huyện --', true);
            resetSelect(wardSelect, '-- Chọn Phường/Xã --', true);
            if (code) loadDistricts(code);
        });

        function loadDistricts(provinceCode) {
            fetch(`${API}/p/${provinceCode}?depth=2`) //call api lấy huyện
                .then(r => r.json())
                .then(data => {
                    districtSelect.disabled = false;
                    data.districts.forEach(d => {
                        const opt = new Option(d.name, d.name);
                        opt.dataset.code = d.code;
                        if (d.name === currentDistrict) opt.selected = true;
                        districtSelect.add(opt);
                    });
                    const sel = districtSelect.options[districtSelect.selectedIndex];
                    if (sel && sel.dataset.code) loadWards(sel.dataset.code);
                });
        }

        // === STEP 3: Khi chọn district → load ward ===
        districtSelect.addEventListener('change', function() {
            const code = this.options[this.selectedIndex].dataset.code;
            resetSelect(wardSelect, '-- Chọn Phường/Xã --', true);
            if (code) loadWards(code);
        });

        function loadWards(districtCode) {
            fetch(`${API}/d/${districtCode}?depth=2`) //call api lấy xã
                .then(r => r.json())
                .then(data => {
                    wardSelect.disabled = false;
                    data.wards.forEach(w => {
                        const opt = new Option(w.name, w.name);
                        if (w.name === currentWard) opt.selected = true;
                        wardSelect.add(opt);
                    });
                });
        }

        // Helper reset select
        function resetSelect(sel, placeholder, disable = false) {
            sel.innerHTML = `<option value="">${placeholder}</option>`;
            sel.disabled = disable;
        }
    </script>
@endpush
