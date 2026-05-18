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

    /* ── Profile Hero ── */
    .profile-hero {
        background: linear-gradient(135deg, #4361ee 0%, #7209b7 100%);
        border-radius: var(--radius);
        padding: 40px 36px;
        display: flex;
        align-items: center;
        gap: 32px;
        position: relative;
        overflow: hidden;
        margin-bottom: 28px;
        animation: fadeUp .5s ease both;
    }
    .profile-hero::before {
        content: '';
        position: absolute;
        width: 300px; height: 300px;
        border-radius: 50%;
        background: rgba(255,255,255,.07);
        top: -80px; right: -60px;
    }
    .profile-hero::after {
        content: '';
        position: absolute;
        width: 200px; height: 200px;
        border-radius: 50%;
        background: rgba(255,255,255,.05);
        bottom: -60px; right: 120px;
    }

    .hero-avatar-wrap {
        position: relative;
        flex-shrink: 0;
    }
    .hero-avatar {
        width: 110px; height: 110px;
        border-radius: 50%;
        border: 4px solid rgba(255,255,255,.6);
        object-fit: cover;
        box-shadow: 0 8px 24px rgba(0,0,0,.3);
    }
    .avatar-badge {
        position: absolute;
        bottom: 4px; right: 4px;
        background: #2ec4b6;
        border: 3px solid white;
        border-radius: 50%;
        width: 22px; height: 22px;
        display: flex; align-items: center; justify-content: center;
    }
    .avatar-badge i { color: white; font-size: 9px; }

    .hero-info { color: white; z-index: 1; }
    .hero-info .role-badge {
        display: inline-flex; align-items: center; gap: 6px;
        background: rgba(255,255,255,.2);
        border-radius: 20px;
        padding: 4px 14px;
        font-size: 12px;
        font-weight: 600;
        letter-spacing: .5px;
        margin-bottom: 10px;
    }
    .hero-info h2 { font-size: 28px; font-weight: 800; margin: 0 0 6px; }
    .hero-info .meta { display: flex; gap: 20px; font-size: 13px; opacity: .85; }
    .hero-info .meta span { display: flex; align-items: center; gap: 6px; }

    /* ── Card ── */
    .info-card {
        background: white;
        border-radius: var(--radius);
        box-shadow: var(--card-shadow);
        overflow: hidden;
        animation: fadeUp .5s ease both;
    }
    .info-card + .info-card { margin-top: 24px; }

    .card-header-custom {
        display: flex; align-items: center; gap: 12px;
        padding: 20px 28px;
        border-bottom: 1px solid #f0f0f0;
        background: white;
    }
    .card-header-custom .icon-wrap {
        width: 40px; height: 40px;
        border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        font-size: 17px;
    }
    .card-header-custom h5 { margin: 0; font-weight: 700; color: var(--text-dark); font-size: 16px; }
    .card-header-custom small { color: var(--text-muted); font-size: 12px; }

    .card-body-custom { padding: 28px; }

    /* ── Form Fields ── */
    .form-group-custom { margin-bottom: 22px; }
    .form-group-custom label {
        font-weight: 600;
        font-size: 13px;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: .6px;
        margin-bottom: 8px;
        display: block;
    }
    .form-control-custom {
        width: 100%;
        padding: 12px 16px;
        border: 2px solid #e8ecff;
        border-radius: 10px;
        font-size: 14px;
        color: var(--text-dark);
        transition: all .2s;
        background: #fafbff;
    }
    .form-control-custom:focus {
        outline: none;
        border-color: var(--primary);
        background: white;
        box-shadow: 0 0 0 4px rgba(67,97,238,.1);
    }
    .form-control-custom[readonly] {
        background: #f4f6fb;
        color: var(--text-muted);
        cursor: not-allowed;
        border-color: #e0e0e0;
    }
    textarea.form-control-custom { resize: vertical; min-height: 110px; }

    /* ── Read-only Info Row ── */
    .info-row {
        display: flex; align-items: flex-start;
        padding: 14px 0;
        border-bottom: 1px solid #f5f5f5;
    }
    .info-row:last-child { border-bottom: none; padding-bottom: 0; }
    .info-row .label {
        width: 180px;
        flex-shrink: 0;
        font-size: 13px;
        font-weight: 600;
        color: var(--text-muted);
        display: flex; align-items: center; gap: 8px;
    }
    .info-row .label i { width: 16px; color: var(--primary); }
    .info-row .value { font-size: 14px; color: var(--text-dark); font-weight: 500; }
    .info-row .value .badge-info {
        display: inline-flex; align-items: center; gap: 5px;
        background: var(--primary-light);
        color: var(--primary);
        border-radius: 20px;
        padding: 4px 12px;
        font-size: 12px;
        font-weight: 600;
    }

    /* ── Submit Button ── */
    .btn-save {
        background: linear-gradient(135deg, #4361ee, #7209b7);
        color: white;
        border: none;
        border-radius: 12px;
        padding: 13px 36px;
        font-size: 14px;
        font-weight: 700;
        cursor: pointer;
        transition: all .2s;
        display: inline-flex; align-items: center; gap: 8px;
    }
    .btn-save:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(67,97,238,.35);
    }
    .btn-save:active { transform: translateY(0); }

    /* ── Alert ── */
    .alert-custom {
        border-radius: 12px;
        padding: 14px 20px;
        display: flex; align-items: center; gap: 12px;
        font-size: 14px;
        font-weight: 500;
        margin-bottom: 24px;
        animation: fadeUp .4s ease both;
    }
    .alert-success-custom { background: #e6faf8; color: #1a9c8e; border: 1.5px solid #2ec4b6; }
    .alert-error-custom   { background: #fdecea; color: #c62828; border: 1.5px solid #e63946; }
    .alert-custom i { font-size: 18px; }

    /* ── Change Password Toggle ── */
    .pwd-toggle {
        display: inline-flex; align-items: center; gap: 8px;
        color: var(--primary);
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        background: var(--primary-light);
        border: none;
        border-radius: 8px;
        padding: 8px 16px;
        transition: all .2s;
        margin-bottom: 20px;
    }
    .pwd-toggle:hover { background: var(--primary); color: white; }

    /* ── Animations ── */
    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(20px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    .grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
    @media (max-width: 768px) { .grid-2 { grid-template-columns: 1fr; } .profile-hero { flex-direction: column; text-align: center; } .hero-info .meta { justify-content: center; } }

    /* ── Certificates ── */
    .cert-grid, .cert-preview-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
        gap: 14px;
        margin-bottom: 20px;
    }
    .cert-item {
        border-radius: 12px;
        border: 2px solid #e8ecff;
        overflow: hidden;
        position: relative;
        background: #fafbff;
        transition: all .2s;
    }
    .cert-item.marked-delete { border-color: #e63946; opacity: .55; }
    .cert-thumb {
        width: 100%; height: 110px;
        object-fit: cover;
        display: block;
    }
    .pdf-thumb {
        height: 110px;
        display: flex; flex-direction: column;
        align-items: center; justify-content: center;
        background: #fff0f0; gap: 8px;
        font-size: 11px; color: #e63946; text-align: center; padding: 8px;
    }
    .pdf-thumb i { font-size: 32px; }
    .cert-view-btn {
        display: flex; align-items: center; justify-content: center; gap: 5px;
        padding: 7px 0;
        font-size: 11px; font-weight: 600;
        color: var(--primary);
        text-decoration: none;
        border-top: 1px solid #e8ecff;
        background: white;
    }
    .cert-view-btn:hover { background: var(--primary-light); }
    .cert-delete-check {
        display: flex; align-items: center; justify-content: center;
        padding: 6px;
        cursor: pointer;
        font-size: 11px; font-weight: 600; color: #e63946;
        background: #fdecea;
        border-top: 1px solid #fcc;
    }
    .cert-delete-check input { margin-right: 5px; accent-color: #e63946; }

    /* Preview new */
    .preview-item {
        border-radius: 12px;
        border: 2px dashed #4361ee;
        overflow: hidden;
        background: var(--primary-light);
        position: relative;
    }
    .preview-thumb {
        width: 100%; height: 110px;
        object-fit: cover; display: block;
    }
    .preview-pdf {
        height: 110px;
        display: flex; flex-direction: column;
        align-items: center; justify-content: center;
        gap: 6px; color: var(--primary); font-size: 11px; text-align: center; padding: 8px;
    }
    .preview-pdf i { font-size: 28px; }
    .preview-name {
        font-size: 11px; font-weight: 600; color: var(--primary);
        padding: 6px 8px; text-align: center;
        white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
        background: white; border-top: 1px solid #c5d0ff;
    }
    .btn-remove-preview {
        position: absolute; top: 6px; right: 6px;
        background: #e63946; color: white;
        border: none; border-radius: 50%;
        width: 22px; height: 22px;
        font-size: 10px; cursor: pointer;
        display: flex; align-items: center; justify-content: center;
    }

    /* Drop zone */
    .drop-zone {
        border: 2.5px dashed #c5d0ff;
        border-radius: 14px;
        padding: 30px 20px;
        text-align: center;
        cursor: pointer;
        color: var(--text-muted);
        transition: all .2s;
        background: #fafbff;
        margin-bottom: 16px;
    }
    .drop-zone:hover, .drop-zone.drag-over {
        border-color: var(--primary);
        background: var(--primary-light);
        color: var(--primary);
    }
    .drop-zone i { font-size: 36px; margin-bottom: 10px; display: block; }
    .drop-zone p { margin: 0 0 4px; font-size: 14px; font-weight: 500; }
    .drop-zone small { font-size: 12px; }

    .no-cert-msg {
        text-align: center; color: var(--text-muted);
        padding: 20px; font-size: 13px;
    }
    .no-cert-msg i { font-size: 32px; margin-bottom: 8px; display: block; }
</style>
@endpush

@section('content')
@php
    $gender = $doctor->user->gender ?? 'men';
    $photoId = ($doctor->id % 70) + 1;
    $photoUrl = "https://randomuser.me/api/portraits/{$gender}/{$photoId}.jpg";
@endphp

{{-- ── Alerts ── --}}
@if(session('success'))
    <div class="alert-custom alert-success-custom">
        <i class="fas fa-check-circle"></i>
        {{ session('success') }}
    </div>
@endif
@if($errors->any())
    <div class="alert-custom alert-error-custom">
        <i class="fas fa-exclamation-circle"></i>
        <div>
            @foreach($errors->all() as $err)
                <div>{{ $err }}</div>
            @endforeach
        </div>
    </div>
@endif

{{-- ── Hero ── --}}
<div class="profile-hero">
    <div class="hero-avatar-wrap">
        <img src="{{ $photoUrl }}"
             onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($doctor->full_name) }}&background=4361ee&color=fff&size=110'"
             class="hero-avatar" alt="{{ $doctor->full_name }}">
        <div class="avatar-badge"><i class="fas fa-check"></i></div>
    </div>
    <div class="hero-info">
        <div class="role-badge">
            <i class="fas fa-user-md"></i> Bác Sĩ
        </div>
        <h2>{{ $doctor->full_name }}</h2>
        <div class="meta">
            <span><i class="fas fa-stethoscope"></i> {{ $doctor->specialization->name ?? '—' }}</span>
            <span><i class="fas fa-map-marker-alt"></i> {{ $doctor->city->name ?? '—' }}</span>
            <span><i class="fas fa-phone"></i> {{ $doctor->phone_number ?? '—' }}</span>
        </div>
    </div>
</div>

<div class="row">
    {{-- ── Left: Read-only Info ── --}}
    <div class="col-md-4">
        <div class="info-card" style="animation-delay:.05s">
            <div class="card-header-custom">
                <div class="icon-wrap" style="background:#e8ecff">
                    <i class="fas fa-id-card" style="color:#4361ee"></i>
                </div>
                <div>
                    <h5>Thông tin tài khoản</h5>
                    <small>Chỉ đọc — liên hệ admin để thay đổi</small>
                </div>
            </div>
            <div class="card-body-custom">
                <div class="info-row">
                    <div class="label"><i class="fas fa-envelope"></i> Email</div>
                    <div class="value">{{ $doctor->user->email }}</div>
                </div>
                <div class="info-row">
                    <div class="label"><i class="fas fa-user"></i> Tên đăng nhập</div>
                    <div class="value">{{ $doctor->user->name }}</div>
                </div>
                <div class="info-row">
                    <div class="label"><i class="fas fa-shield-alt"></i> Vai trò</div>
                    <div class="value">
                        <span class="badge-info"><i class="fas fa-user-md"></i> Bác sĩ</span>
                    </div>
                </div>
                <div class="info-row">
                    <div class="label"><i class="fas fa-map-marked-alt"></i> Chuyên khoa</div>
                    <div class="value">{{ $doctor->specialization->name ?? '—' }}</div>
                </div>
                <div class="info-row">
                    <div class="label"><i class="fas fa-city"></i> Thành phố</div>
                    <div class="value">{{ $doctor->city->name ?? '—' }}</div>
                </div>
                <div class="info-row">
                    <div class="label"><i class="fas fa-calendar-alt"></i> Ngày tham gia</div>
                    <div class="value">{{ $doctor->created_at->format('d/m/Y') }}</div>
                </div>
            </div>
        </div>
    </div>

    {{-- ── Right: Editable Form ── --}}
    <div class="col-md-8">
        <form action="{{ route('doctor.profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="info-card" style="animation-delay:.1s">
                <div class="card-header-custom">
                    <div class="icon-wrap" style="background:#e6faf8">
                        <i class="fas fa-pen" style="color:#2ec4b6"></i>
                    </div>
                    <div>
                        <h5>Chỉnh sửa thông tin</h5>
                        <small>Cập nhật thông tin cá nhân của bạn</small>
                    </div>
                </div>
                <div class="card-body-custom">
                    <div class="grid-2">
                        <div class="form-group-custom">
                            <label>Họ và tên</label>
                            <input type="text" name="full_name" class="form-control-custom"
                                   value="{{ old('full_name', $doctor->full_name) }}" required>
                        </div>
                        <div class="form-group-custom">
                            <label>Số điện thoại</label>
                            <input type="text" name="phone_number" class="form-control-custom"
                                   value="{{ old('phone_number', $doctor->phone_number) }}" required>
                        </div>
                    </div>

                    <div class="form-group-custom">
                        <label>Bằng cấp / Chứng chỉ</label>
                        <input type="text" name="qualifications" class="form-control-custom"
                               placeholder="VD: Tiến sĩ Y khoa, Chuyên khoa II..."
                               value="{{ old('qualifications', $doctor->qualifications) }}">
                    </div>

                    <div class="form-group-custom">
                        <label>Giới thiệu bản thân</label>
                        <textarea name="description" class="form-control-custom"
                                  placeholder="Mô tả kinh nghiệm, phương pháp làm việc...">{{ old('description', $doctor->description) }}</textarea>
                    </div>
                </div>
            </div>

            {{-- ── Certificates Upload ── --}}
            <div class="info-card mt-4" style="animation-delay:.12s">
                <div class="card-header-custom">
                    <div class="icon-wrap" style="background:#fff8e1">
                        <i class="fas fa-certificate" style="color:#f4a100"></i>
                    </div>
                    <div>
                        <h5>Chứng chỉ hành nghề</h5>
                        <small>Upload ảnh hoặc PDF (tối đa 5MB mỗi file)</small>
                    </div>
                </div>
                <div class="card-body-custom">

                    {{-- Existing certificates --}}
                    @if($doctor->certificates && count($doctor->certificates) > 0)
                    <div class="cert-grid" id="cert-grid">
                        @foreach($doctor->certificates as $cert)
                        @php $isPdf = str_ends_with(strtolower($cert), '.pdf'); @endphp
                        <div class="cert-item" id="cert-{{ $loop->index }}">
                            @if($isPdf)
                                <div class="cert-thumb pdf-thumb">
                                    <i class="fas fa-file-pdf"></i>
                                    <span>{{ basename($cert) }}</span>
                                </div>
                                <a href="{{ Storage::url($cert) }}" target="_blank" class="cert-view-btn">
                                    <i class="fas fa-external-link-alt"></i> Xem
                                </a>
                            @else
                                <img src="{{ Storage::url($cert) }}" class="cert-thumb" alt="Chứng chỉ">
                                <a href="{{ Storage::url($cert) }}" target="_blank" class="cert-view-btn">
                                    <i class="fas fa-search-plus"></i> Xem
                                </a>
                            @endif
                            <label class="cert-delete-check">
                                <input type="checkbox" name="delete_cert[]" value="{{ $cert }}"
                                       onchange="toggleDeleteMark(this)">
                                <span><i class="fas fa-trash-alt"></i> Xoá</span>
                            </label>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div id="no-cert-msg" class="no-cert-msg">
                        <i class="fas fa-folder-open"></i>
                        <p>Chưa có chứng chỉ nào được tải lên</p>
                    </div>
                    @endif

                    {{-- Drop zone --}}
                    <div class="drop-zone" id="drop-zone" onclick="document.getElementById('cert-input').click()">
                        <i class="fas fa-cloud-upload-alt"></i>
                        <p>Kéo thả hoặc <strong>nhấn để chọn file</strong></p>
                        <small>Hỗ trợ: JPG, PNG, PDF — tối đa 5MB/file</small>
                    </div>
                    <input type="file" id="cert-input" name="certificates[]" multiple
                           accept=".jpg,.jpeg,.png,.pdf" style="display:none"
                           onchange="previewCerts(this)">

                    {{-- Preview new files --}}
                    <div class="cert-preview-grid" id="cert-preview-grid"></div>
                </div>
            </div>

            {{-- ── Change Password ── --}}
            <div class="info-card mt-4" style="animation-delay:.15s">
                <div class="card-header-custom">
                    <div class="icon-wrap" style="background:#fff0f0">
                        <i class="fas fa-lock" style="color:#e63946"></i>
                    </div>
                    <div>
                        <h5>Đổi mật khẩu</h5>
                        <small>Để trống nếu không muốn thay đổi</small>
                    </div>
                </div>
                <div class="card-body-custom">
                    <button type="button" class="pwd-toggle" onclick="togglePwd(this)">
                        <i class="fas fa-key"></i> Nhấn để đổi mật khẩu
                    </button>

                    <div id="pwd-section" style="display:none">
                        <div class="grid-2">
                            <div class="form-group-custom">
                                <label>Mật khẩu mới</label>
                                <input type="password" name="password" id="pw-new" class="form-control-custom"
                                       placeholder="Ít nhất 8 ký tự" minlength="8" autocomplete="new-password">
                            </div>
                            <div class="form-group-custom">
                                <label>Xác nhận mật khẩu mới</label>
                                <input type="password" name="password_confirmation" class="form-control-custom"
                                       placeholder="Nhập lại mật khẩu mới" autocomplete="new-password">
                            </div>
                        </div>
                        <div id="pwd-match-msg" style="font-size:12px;margin-top:-12px;margin-bottom:16px;display:none"></div>
                    </div>
                </div>
            </div>

            <div class="mt-4 d-flex align-items-center gap-3">
                <button type="submit" class="btn-save">
                    <i class="fas fa-save"></i> Lưu thay đổi
                </button>
                <a href="{{ route('doctor.dashboard') }}" style="color:var(--text-muted);font-size:13px;text-decoration:none;margin-left:16px;">
                    <i class="fas fa-arrow-left"></i> Quay lại Dashboard
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
// ── Toggle delete mark ──
function toggleDeleteMark(checkbox) {
    const item = checkbox.closest('.cert-item');
    item.classList.toggle('marked-delete', checkbox.checked);
}

// ── Preview new cert files ──
let selectedFiles = [];

function previewCerts(input) {
    const grid = document.getElementById('cert-preview-grid');
    Array.from(input.files).forEach((file, i) => {
        if (selectedFiles.find(f => f.name === file.name && f.size === file.size)) return;
        selectedFiles.push(file);
        renderPreview(file, selectedFiles.length - 1, grid);
    });
    rebuildFileInput();
}

function renderPreview(file, idx, grid) {
    const div = document.createElement('div');
    div.className = 'preview-item';
    div.id = 'preview-' + idx;

    const isPdf = file.type === 'application/pdf';
    if (isPdf) {
        div.innerHTML = `
            <div class="preview-pdf"><i class="fas fa-file-pdf"></i><span>${file.name}</span></div>
            <div class="preview-name">${file.name}</div>
            <button type="button" class="btn-remove-preview" onclick="removePreview(${idx})"><i class="fas fa-times"></i></button>`;
    } else {
        const reader = new FileReader();
        reader.onload = e => {
            div.innerHTML = `
                <img src="${e.target.result}" class="preview-thumb" alt="${file.name}">
                <div class="preview-name">${file.name}</div>
                <button type="button" class="btn-remove-preview" onclick="removePreview(${idx})"><i class="fas fa-times"></i></button>`;
        };
        reader.readAsDataURL(file);
    }
    grid.appendChild(div);
}

function removePreview(idx) {
    selectedFiles[idx] = null;
    const el = document.getElementById('preview-' + idx);
    if (el) el.remove();
    rebuildFileInput();
}

function rebuildFileInput() {
    const dt = new DataTransfer();
    selectedFiles.filter(Boolean).forEach(f => dt.items.add(f));
    document.getElementById('cert-input').files = dt.files;
}

// ── Drag & Drop ──
const dz = document.getElementById('drop-zone');
dz.addEventListener('dragover', e => { e.preventDefault(); dz.classList.add('drag-over'); });
dz.addEventListener('dragleave', () => dz.classList.remove('drag-over'));
dz.addEventListener('drop', e => {
    e.preventDefault();
    dz.classList.remove('drag-over');
    const input = document.getElementById('cert-input');
    const grid = document.getElementById('cert-preview-grid');
    Array.from(e.dataTransfer.files).forEach(file => {
        if (!['image/jpeg','image/png','application/pdf'].includes(file.type)) return;
        selectedFiles.push(file);
        renderPreview(file, selectedFiles.length - 1, grid);
    });
    rebuildFileInput();
});

// ── Password toggle ──
function togglePwd(btn) {
    const sec = document.getElementById('pwd-section');
    const isHidden = sec.style.display === 'none';
    sec.style.display = isHidden ? 'block' : 'none';
    btn.innerHTML = isHidden
        ? '<i class="fas fa-times"></i> Đóng đổi mật khẩu'
        : '<i class="fas fa-key"></i> Nhấn để đổi mật khẩu';

    // remove required when hidden
    const pwNew = document.getElementById('pw-new');
    if (!isHidden) {
        pwNew.removeAttribute('required');
        pwNew.value = '';
        document.querySelector('[name=password_confirmation]').value = '';
    }
}

// Kiểm tra match mật khẩu
document.querySelector('[name=password_confirmation]').addEventListener('input', function() {
    const msg = document.getElementById('pwd-match-msg');
    const pw = document.getElementById('pw-new').value;
    if (!pw) { msg.style.display = 'none'; return; }
    msg.style.display = 'block';
    if (this.value === pw) {
        msg.innerHTML = '<span style="color:#2ec4b6"><i class="fas fa-check-circle"></i> Mật khẩu khớp</span>';
    } else {
        msg.innerHTML = '<span style="color:#e63946"><i class="fas fa-times-circle"></i> Mật khẩu chưa khớp</span>';
    }
});
</script>
@endpush
