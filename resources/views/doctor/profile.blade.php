@extends('layouts.doctordashboard')

@section('title', 'Thông Tin Cá Nhân')

@push('styles')
    <style>
        :root {
            --primary: #4361ee;
            --primary-light: #e8ecff;
            --success: #2ec4b6;
            --danger: #e63946;
            --text-dark: #1a1a2e;
            --text-muted: #6c757d;
            --card-shadow: 0 10px 40px rgba(67,97,238,.12);
            --radius: 16px;
        }
        body { background: #f0f4ff; }

        .profile-hero {
            background: linear-gradient(135deg, #4361ee 0%, #7209b7 100%);
            border-radius: var(--radius);
            padding: 40px 36px;
            display: flex; align-items: center; gap: 32px;
            position: relative; overflow: hidden;
            margin-bottom: 28px;
        }
        .hero-avatar-wrap { position: relative; flex-shrink: 0; }
        .hero-avatar {
            width: 110px; height: 110px;
            border-radius: 50%;
            border: 4px solid rgba(255,255,255,.6);
            object-fit: cover;
            box-shadow: 0 8px 24px rgba(0,0,0,.3);
        }
        .hero-info { color: white; z-index: 1; }
        .hero-info .role-badge {
            display: inline-flex; align-items: center; gap: 6px;
            background: rgba(255,255,255,.2); border-radius: 20px;
            padding: 4px 14px; font-size: 12px; font-weight: 600;
            margin-bottom: 10px;
        }
        .hero-info h2 { font-size: 28px; font-weight: 800; margin: 0 0 6px; }
        .hero-info .meta { display: flex; gap: 20px; font-size: 13px; opacity: .85; flex-wrap: wrap; }
        .hero-info .meta span { display: flex; align-items: center; gap: 6px; }

        .info-card {
            background: white; border-radius: var(--radius);
            box-shadow: var(--card-shadow); overflow: hidden;
        }
        .info-card + .info-card { margin-top: 24px; }
        .card-header-custom {
            display: flex; align-items: center; gap: 12px;
            padding: 20px 28px; border-bottom: 1px solid #f0f0f0;
        }
        .card-header-custom .icon-wrap {
            width: 40px; height: 40px; border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 17px;
        }
        .card-header-custom h5 { margin: 0; font-weight: 700; color: var(--text-dark); font-size: 16px; }
        .card-header-custom small { color: var(--text-muted); font-size: 12px; }
        .card-body-custom { padding: 28px; }

        .form-group-custom { margin-bottom: 22px; }
        .form-group-custom label {
            font-weight: 600; font-size: 13px; color: var(--text-muted);
            text-transform: uppercase; letter-spacing: .6px;
            margin-bottom: 8px; display: block;
        }
        .form-control-custom {
            width: 100%; padding: 12px 16px;
            border: 2px solid #e8ecff; border-radius: 10px;
            font-size: 14px; background: #fafbff;
        }
        .form-control-custom:focus {
            outline: none; border-color: var(--primary);
            background: white; box-shadow: 0 0 0 4px rgba(67,97,238,.1);
        }
        textarea.form-control-custom { resize: vertical; min-height: 110px; }

        .info-row {
            display: flex; padding: 14px 0; border-bottom: 1px solid #f5f5f5;
        }
        .info-row:last-child { border-bottom: none; }
        .info-row .label {
            width: 180px; flex-shrink: 0; font-size: 13px; font-weight: 600; color: var(--text-muted);
            display: flex; align-items: center; gap: 8px;
        }
        .info-row .label i { width: 16px; color: var(--primary); }
        .info-row .value { font-size: 14px; color: var(--text-dark); font-weight: 500; }
        .info-row .value .badge-info {
            background: var(--primary-light); color: var(--primary);
            border-radius: 20px; padding: 4px 12px; font-size: 12px; font-weight: 600;
        }

        .btn-save {
            background: linear-gradient(135deg, #4361ee, #7209b7);
            color: white; border: none; border-radius: 12px;
            padding: 13px 36px; font-size: 14px; font-weight: 700;
            cursor: pointer;
            display: inline-flex; align-items: center; gap: 8px;
        }
        .btn-save:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(67,97,238,.35); }

        .alert-custom { border-radius: 12px; padding: 14px 20px; display: flex; gap: 12px; font-size: 14px; margin-bottom: 24px; }
        .alert-success-custom { background: #e6faf8; color: #1a9c8e; border: 1.5px solid #2ec4b6; }
        .alert-error-custom   { background: #fdecea; color: #c62828; border: 1.5px solid #e63946; }

        .pwd-toggle {
            color: var(--primary); font-size: 13px; font-weight: 600;
            background: var(--primary-light); border: none;
            border-radius: 8px; padding: 8px 16px; cursor: pointer;
            display: inline-flex; align-items: center; gap: 8px;
            margin-bottom: 20px;
        }
        .pwd-toggle:hover { background: var(--primary); color: white; }

        .grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
        @media (max-width: 768px) {
            .grid-2 { grid-template-columns: 1fr; }
            .profile-hero { flex-direction: column; text-align: center; }
        }

        .drop-zone {
            border: 2.5px dashed #c5d0ff; border-radius: 14px;
            padding: 30px 20px; text-align: center; cursor: pointer;
            color: var(--text-muted); background: #fafbff;
        }
        .drop-zone:hover { border-color: var(--primary); background: var(--primary-light); color: var(--primary); }
        .drop-zone i { font-size: 36px; margin-bottom: 10px; display: block; }
        .drop-zone p { margin: 0 0 4px; font-size: 14px; font-weight: 500; }

        .no-cert-msg { text-align: center; color: var(--text-muted); padding: 20px; font-size: 13px; }
        .no-cert-msg i { font-size: 32px; margin-bottom: 8px; display: block; }

        .avatar-letter {
            width: 120px; height: 120px; border-radius: 50%;
            background: #e8ecff; display: inline-flex; align-items: center; justify-content: center;
            font-size: 48px; font-weight: 700; color: #4361ee;
        }
    </style>
@endpush

@section('content')

    @if(session('success'))
        <div class="alert-custom alert-success-custom">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif
    @if($errors->any())
        <div class="alert-custom alert-error-custom">
            <i class="fas fa-exclamation-circle"></i>
            <div>@foreach($errors->all() as $err)<div>{{ $err }}</div>@endforeach</div>
        </div>
    @endif

    {{-- HERO --}}
    <div class="profile-hero">
        <div class="hero-avatar-wrap">
            @if($doctor->user->avatar_url)
                <img src="{{ asset('storage/' . $doctor->user->avatar_url) }}" class="hero-avatar" alt="{{ $doctor->full_name }}">
            @else
                <img src="https://ui-avatars.com/api/?name={{ urlencode($doctor->full_name) }}&background=fff&color=4361ee&size=110"
                     class="hero-avatar" alt="{{ $doctor->full_name }}">
            @endif
        </div>
        <div class="hero-info">
            <div class="role-badge"><i class="fas fa-user-md"></i> Bác Sĩ</div>
            <h2>{{ $doctor->full_name }}</h2>
            <div class="meta">
                <span><i class="fas fa-stethoscope"></i> {{ $doctor->specialty ?? '—' }}</span>
                <span><i class="fas fa-briefcase"></i> {{ $doctor->experience_years ?? 0 }} năm KN</span>
                <span><i class="fas fa-envelope"></i> {{ $doctor->user->email }}</span>
            </div>
        </div>
    </div>

    <div class="row">
        {{-- LEFT: readonly info --}}
        <div class="col-md-4">
            <div class="info-card">
                <div class="card-header-custom">
                    <div class="icon-wrap" style="background:#e8ecff">
                        <i class="fas fa-id-card" style="color:#4361ee"></i>
                    </div>
                    <div><h5>Thông tin tài khoản</h5><small>Chỉ đọc</small></div>
                </div>
                <div class="card-body-custom">
                    <div class="info-row">
                        <div class="label"><i class="fas fa-envelope"></i> Email</div>
                        <div class="value">{{ $doctor->user->email }}</div>
                    </div>
                    <div class="info-row">
                        <div class="label"><i class="fas fa-shield-alt"></i> Vai trò</div>
                        <div class="value"><span class="badge-info"><i class="fas fa-user-md"></i> Bác sĩ</span></div>
                    </div>
                    <div class="info-row">
                        <div class="label"><i class="fas fa-stethoscope"></i> Chuyên khoa</div>
                        <div class="value">{{ $doctor->specialty ?? '—' }}</div>
                    </div>
                    <div class="info-row">
                        <div class="label"><i class="fas fa-briefcase"></i> Kinh nghiệm</div>
                        <div class="value">{{ $doctor->experience_years ?? 0 }} năm</div>
                    </div>
                    <div class="info-row">
                        <div class="label"><i class="fas fa-calendar-alt"></i> Ngày tham gia</div>
                        <div class="value">{{ $doctor->created_at->format('d/m/Y') }}</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- RIGHT: form --}}
        <div class="col-md-8">
            <form action="{{ route('doctor.profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- AVATAR --}}
                <div class="info-card">
                    <div class="card-header-custom">
                        <div class="icon-wrap" style="background:#fff8e1"><i class="fas fa-camera" style="color:#f4a100"></i></div>
                        <div><h5>Ảnh đại diện</h5><small>JPG, PNG. Tối đa 2MB</small></div>
                    </div>
                    <div class="card-body-custom" style="text-align:center">
                        @if($doctor->user->avatar_url)
                            <img src="{{ asset('storage/' . $doctor->user->avatar_url) }}"
                                 style="width:120px;height:120px;border-radius:50%;object-fit:cover;border:3px solid #4361ee;margin-bottom:16px">
                        @else
                            <div class="avatar-letter" style="margin-bottom:16px">
                                {{ strtoupper(mb_substr($doctor->full_name, 0, 1)) }}
                            </div>
                        @endif
                        <div>
                            <label for="avatarInput" class="btn btn-outline-primary rounded-pill" style="cursor:pointer">
                                <i class="fas fa-camera mr-1"></i> Đổi ảnh đại diện
                            </label>
                            <input type="file" id="avatarInput" name="avatar" accept="image/*" style="display:none"
                                   onchange="document.getElementById('avatarFileName').textContent = this.files[0]?.name || ''">
                            <div id="avatarFileName" style="color:#4361ee;font-size:13px;font-weight:600;margin-top:8px"></div>
                        </div>
                    </div>
                </div>

                {{-- EDIT INFO --}}
                <div class="info-card mt-4">
                    <div class="card-header-custom">
                        <div class="icon-wrap" style="background:#e6faf8"><i class="fas fa-pen" style="color:#2ec4b6"></i></div>
                        <div><h5>Chỉnh sửa thông tin</h5><small>Cập nhật thông tin cá nhân</small></div>
                    </div>
                    <div class="card-body-custom">
                        <div class="grid-2">
                            <div class="form-group-custom">
                                <label>Họ và tên</label>
                                <input type="text" name="full_name" class="form-control-custom"
                                       value="{{ old('full_name', $doctor->full_name) }}" required>
                            </div>
                            <div class="form-group-custom">
                                <label>Chuyên khoa</label>
                                <input type="text" name="specialty" class="form-control-custom"
                                       placeholder="VD: Tim mạch"
                                       value="{{ old('specialty', $doctor->specialty) }}">
                            </div>
                        </div>
                        <div class="form-group-custom">
                            <label>Số năm kinh nghiệm</label>
                            <input type="number" name="experience_years" class="form-control-custom" min="0"
                                   value="{{ old('experience_years', $doctor->experience_years) }}">
                        </div>
                        <div class="form-group-custom">
                            <label>Giới thiệu bản thân</label>
                            <textarea name="bio" class="form-control-custom"
                                      placeholder="Mô tả kinh nghiệm, phương pháp làm việc...">{{ old('bio', $doctor->bio) }}</textarea>
                        </div>
                    </div>
                </div>

                {{-- CERTIFICATE --}}
                <div class="info-card mt-4">
                    <div class="card-header-custom">
                        <div class="icon-wrap" style="background:#fff8e1"><i class="fas fa-certificate" style="color:#f4a100"></i></div>
                        <div><h5>Chứng chỉ hành nghề</h5><small>JPG, PNG, PDF — tối đa 5MB</small></div>
                    </div>
                    <div class="card-body-custom">

                        @if($doctor->certificate_url)
                            @php $isPdf = str_ends_with(strtolower($doctor->certificate_url), '.pdf'); @endphp
                            <div style="margin-bottom:20px;padding:16px;border:2px solid #e8ecff;border-radius:12px;display:flex;align-items:center;gap:14px;background:#fafbff">
                                @if($isPdf)
                                    <i class="fas fa-file-pdf" style="font-size:36px;color:#e63946"></i>
                                @else
                                    <img src="{{ asset('storage/' . $doctor->certificate_url) }}"
                                         style="width:60px;height:60px;object-fit:cover;border-radius:8px">
                                @endif
                                <div style="flex:1">
                                    <div style="font-weight:600;color:#1a1a2e">Chứng chỉ đã upload</div>
                                    <small style="color:#6c757d">{{ basename($doctor->certificate_url) }}</small>
                                </div>
                                <a href="{{ asset('storage/' . $doctor->certificate_url) }}" target="_blank"
                                   class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-external-link-alt"></i> Xem
                                </a>
                            </div>
                        @else
                            <div class="no-cert-msg">
                                <i class="fas fa-folder-open"></i>
                                <p>Chưa có chứng chỉ nào</p>
                            </div>
                        @endif

                        <div class="drop-zone" onclick="document.getElementById('cert-input').click()">
                            <i class="fas fa-cloud-upload-alt"></i>
                            <p>{{ $doctor->certificate_url ? 'Thay thế chứng chỉ' : 'Nhấn để chọn file' }}</p>
                            <small>JPG, PNG, PDF — tối đa 5MB</small>
                        </div>
                        <input type="file" id="cert-input" name="certificate"
                               accept=".jpg,.jpeg,.png,.pdf" style="display:none"
                               onchange="document.getElementById('certFileName').textContent = this.files[0]?.name || ''">
                        <div id="certFileName" style="text-align:center;color:#4361ee;font-size:13px;font-weight:600;margin-top:8px"></div>
                    </div>
                </div>

                {{-- PASSWORD --}}
                <div class="info-card mt-4">
                    <div class="card-header-custom">
                        <div class="icon-wrap" style="background:#fff0f0"><i class="fas fa-lock" style="color:#e63946"></i></div>
                        <div><h5>Đổi mật khẩu</h5><small>Để trống nếu không muốn thay đổi</small></div>
                    </div>
                    <div class="card-body-custom">
                        <button type="button" class="pwd-toggle" onclick="togglePwd(this)">
                            <i class="fas fa-key"></i> Nhấn để đổi mật khẩu
                        </button>
                        <div id="pwd-section" style="display:none">
                            <div class="grid-2">
                                <div class="form-group-custom">
                                    <label>Mật khẩu mới</label>
                                    <input type="password" name="password" class="form-control-custom" minlength="6">
                                </div>
                                <div class="form-group-custom">
                                    <label>Xác nhận mật khẩu</label>
                                    <input type="password" name="password_confirmation" class="form-control-custom">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn-save">
                        <i class="fas fa-save"></i> Lưu thay đổi
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function togglePwd(btn) {
            const sec = document.getElementById('pwd-section');
            const isHidden = sec.style.display === 'none';
            sec.style.display = isHidden ? 'block' : 'none';
            btn.innerHTML = isHidden
                ? '<i class="fas fa-times"></i> Đóng đổi mật khẩu'
                : '<i class="fas fa-key"></i> Nhấn để đổi mật khẩu';
        }
    </script>
@endpush
