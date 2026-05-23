@extends('layouts.admin')
@section('title', 'Quản lý hủy lịch')

@push('styles')
<style>
:root{--primary:#4361ee;--primary-light:#e8ecff;--success:#2ec4b6;--warning:#f4a100;--danger:#e63946;--purple:#7209b7;--text-dark:#1a1a2e;--text-muted:#6c757d;--shadow:0 4px 24px rgba(67,97,238,.10);--radius:14px;}
body{background:#f0f4ff!important;}
@keyframes fadeUp{from{opacity:0;transform:translateY(18px)}to{opacity:1;transform:translateY(0)}}
@keyframes slideIn{from{opacity:0;transform:translateX(-20px)}to{opacity:1;transform:translateX(0)}}

.page-hero{background:linear-gradient(135deg,#e63946,#c1121f);border-radius:var(--radius);padding:26px 32px;color:white;margin-bottom:28px;animation:fadeUp .5s ease both;position:relative;overflow:hidden;}
.page-hero::before{content:'';position:absolute;width:220px;height:220px;border-radius:50%;background:rgba(255,255,255,.07);top:-60px;right:-30px;}
.page-hero h2{font-size:22px;font-weight:800;margin:0 0 4px;position:relative;z-index:1;}
.page-hero p{margin:0;opacity:.85;font-size:13px;position:relative;z-index:1;}

/* Stats */
.stats-row{display:flex;gap:14px;margin-bottom:22px;flex-wrap:wrap;animation:fadeUp .5s ease .05s both;}
.stat-card{flex:1;min-width:160px;background:white;border-radius:var(--radius);padding:16px 20px;box-shadow:var(--shadow);border-left:4px solid transparent;}
.stat-card.total{border-color:#6c757d;}
.stat-card.unhandled{border-color:#e63946;}
.stat-card.handled{border-color:#2ec4b6;}
.stat-label{font-size:11px;font-weight:700;text-transform:uppercase;color:var(--text-muted);letter-spacing:.5px;}
.stat-value{font-size:26px;font-weight:800;color:var(--text-dark);line-height:1.2;}

/* Filter tabs */
.filter-tabs{display:flex;gap:8px;flex-wrap:wrap;margin-bottom:20px;animation:fadeUp .5s ease .1s both;}
.filter-tab{padding:7px 20px;border-radius:20px;font-size:.82rem;font-weight:700;cursor:pointer;border:2px solid #dadce0;background:#fff;color:#5f6368;transition:all .2s ease;user-select:none;}
.filter-tab:hover{border-color:#4361ee;color:#4361ee;}
.filter-tab.active{background:linear-gradient(135deg,#4361ee,#7209b7);border-color:transparent;color:#fff;box-shadow:0 4px 12px rgba(67,97,238,.3);}
.filter-tab .cnt{background:rgba(255,255,255,.25);border-radius:10px;padding:0 7px;font-size:.7rem;margin-left:4px;}
.filter-tab:not(.active) .cnt{background:#f1f3f4;color:#5f6368;}

/* Cancellation cards */
.cx-card{background:white;border-radius:var(--radius);box-shadow:var(--shadow);margin-bottom:16px;overflow:hidden;animation:fadeUp .5s ease both;border-left:5px solid #e63946;transition:transform .2s,box-shadow .2s;}
.cx-card:hover{transform:translateY(-2px);box-shadow:0 8px 28px rgba(230,57,70,.12);}
.cx-card.handled{border-left-color:#2ec4b6;opacity:.85;}
.cx-card.handled:hover{opacity:1;}

.cx-header{display:flex;align-items:center;gap:16px;padding:16px 20px;cursor:pointer;user-select:none;}
.cx-avatar{width:44px;height:44px;border-radius:50%;object-fit:cover;border:2px solid var(--primary-light);}
.cx-info{flex:1;min-width:0;}
.cx-patient-name{font-size:15px;font-weight:700;color:var(--text-dark);}
.cx-meta{display:flex;flex-wrap:wrap;gap:8px;margin-top:4px;}
.cx-meta-item{font-size:11px;color:var(--text-muted);display:flex;align-items:center;gap:4px;}
.cx-meta-item i{color:var(--primary);width:14px;text-align:center;}
.cx-meta-item .label{font-weight:600;color:var(--text-dark);}

.cx-status-badge{display:inline-flex;align-items:center;gap:4px;border-radius:20px;padding:3px 10px;font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.4px;}
.cx-status-badge.unhandled{background:#fdecea;color:#e63946;}
.cx-status-badge.handled{background:#e6faf8;color:#2ec4b6;}

.cx-expand{margin-left:auto;background:var(--primary-light);border:none;border-radius:50%;width:30px;height:30px;display:flex;align-items:center;justify-content:center;color:var(--primary);font-size:12px;transition:transform .3s,background .2s;cursor:pointer;}
.cx-expand.open{transform:rotate(180deg);background:var(--primary);color:white;}

/* Panel content */
.cx-panel{display:none;border-top:1px solid #f0f0f0;}
.cx-panel.open{display:block;animation:slideIn .3s ease;}
.cx-panel-inner{padding:16px 20px 20px;}

/* Reason box */
.reason-box{background:#fff5f5;border-radius:10px;padding:12px 14px;margin-bottom:16px;border-left:3px solid #e63946;}
.reason-box .reason-label{font-size:10px;font-weight:700;text-transform:uppercase;color:#e63946;letter-spacing:.4px;margin-bottom:4px;}
.reason-box .reason-text{font-size:13px;color:var(--text-dark);}

/* Actions */
.action-grid{display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-top:14px;}
@media(max-width:600px){.action-grid{grid-template-columns:1fr;}}
.action-card-btn{border-radius:12px;padding:18px 16px;text-align:center;border:2px dashed #dadce0;background:#fafbff;cursor:pointer;transition:all .2s ease;}
.action-card-btn:hover{border-color:var(--primary);background:var(--primary-light);transform:translateY(-2px);}
.action-card-btn .icon{font-size:28px;display:block;margin-bottom:8px;}
.action-card-btn .title{font-weight:700;font-size:13px;color:var(--text-dark);margin-bottom:4px;}
.action-card-btn .desc{font-size:11px;color:var(--text-muted);}

.action-card-btn.danger{border-color:#fdecea;}
.action-card-btn.danger:hover{border-color:#e63946;background:#fdecea;}

/* Transfer modal */
.modal-overlay{display:none;position:fixed;inset:0;background:rgba(0,0,0,.5);z-index:9999;align-items:center;justify-content:center;animation:fadeUp .2s ease;}
.modal-overlay.show{display:flex;}
.modal-box{background:white;border-radius:18px;width:90%;max-width:520px;max-height:90vh;overflow-y:auto;box-shadow:0 20px 60px rgba(0,0,0,.2);animation:fadeUp .3s ease;}
.modal-header{padding:20px 24px 14px;border-bottom:1px solid #f0f0f0;display:flex;align-items:center;justify-content:space-between;}
.modal-header h5{font-weight:800;font-size:16px;color:var(--text-dark);margin:0;}
.modal-close{background:none;border:none;font-size:20px;color:var(--text-muted);cursor:pointer;padding:4px 8px;border-radius:8px;transition:background .2s;}
.modal-close:hover{background:#f1f3f4;}
.modal-body{padding:20px 24px;}
.modal-footer{padding:14px 24px 20px;border-top:1px solid #f0f0f0;display:flex;gap:10px;justify-content:flex-end;}

.form-group{margin-bottom:16px;}
.form-group label{display:block;font-size:12px;font-weight:700;color:var(--text-dark);margin-bottom:6px;}
.form-group label i{margin-right:5px;color:var(--primary);}
.form-control{width:100%;padding:9px 13px;border:1.5px solid #d1d5db;border-radius:8px;font-size:13px;transition:border-color .2s;}
.form-control:focus{outline:none;border-color:var(--primary);box-shadow:0 0 0 2px rgba(67,97,238,.13);}
.form-control.is-invalid{border-color:#e63946;}
textarea.form-control{min-height:80px;resize:vertical;}
select.form-control{appearance:auto;}

.btn{font-weight:700;font-size:13px;border-radius:10px;padding:9px 20px;border:none;cursor:pointer;transition:transform .15s,box-shadow .15s;display:inline-flex;align-items:center;gap:6px;}
.btn:hover{transform:translateY(-1px);}
.btn-primary{background:linear-gradient(135deg,#4361ee,#7209b7);color:white;box-shadow:0 4px 12px rgba(67,97,238,.3);}
.btn-primary:hover{box-shadow:0 6px 18px rgba(67,97,238,.4);}
.btn-success{background:linear-gradient(135deg,#2ec4b6,#1a9085);color:white;box-shadow:0 4px 12px rgba(46,196,182,.3);}
.btn-success:hover{box-shadow:0 6px 18px rgba(46,196,182,.4);}
.btn-danger{background:linear-gradient(135deg,#e63946,#c1121f);color:white;box-shadow:0 4px 12px rgba(230,57,70,.3);}
.btn-danger:hover{box-shadow:0 6px 18px rgba(230,57,70,.4);}
.btn-outline{background:transparent;color:var(--text-muted);border:1.5px solid #dadce0;}
.btn-outline:hover{background:#f1f3f4;border-color:#9aa0a6;}
.btn-sm{padding:6px 14px;font-size:11px;border-radius:8px;}

.empty-state{text-align:center;padding:60px 20px;background:white;border-radius:var(--radius);box-shadow:var(--shadow);}
.empty-state i{font-size:56px;color:#dadce0;display:block;margin-bottom:14px;}
.empty-state h5{color:#5f6368;font-weight:700;}
.empty-state p{color:#9aa0a6;font-size:14px;}

.success-msg{position:fixed;top:20px;right:20px;z-index:99999;background:linear-gradient(135deg,#2ec4b6,#1a9085);color:white;border-radius:12px;padding:12px 20px;font-weight:600;font-size:14px;box-shadow:0 6px 20px rgba(46,196,182,.4);animation:slideIn .3s ease both;}
.error-msg{position:fixed;top:20px;right:20px;z-index:99999;background:linear-gradient(135deg,#e63946,#c1121f);color:white;border-radius:12px;padding:12px 20px;font-weight:600;font-size:14px;box-shadow:0 6px 20px rgba(230,57,70,.4);animation:slideIn .3s ease both;}

/* Alert info */
.alert-info{background:#e8f4fd;border:1px solid #b6d4fe;border-radius:10px;padding:12px 16px;font-size:13px;color:#0c5460;margin-bottom:16px;display:flex;align-items:center;gap:8px;}
.alert-info i{font-size:18px;}
</style>
@endpush

@section('content')

@if(session('success'))
    <div class="success-msg" id="successMsg"><i class="fas fa-check-circle mr-1"></i> {{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="error-msg" id="errorMsg"><i class="fas fa-times-circle mr-1"></i> {{ session('error') }}</div>
@endif

{{-- Hero --}}
<div class="page-hero">
    <h2><i class="fas fa-calendar-times mr-2"></i> Quản lý hủy lịch</h2>
    <p>Xử lý các lịch hẹn bị hủy - Gọi khách hàng, chuyển bác sĩ hoặc xác nhận</p>
</div>

{{-- Stats --}}
<div class="stats-row">
    <div class="stat-card total">
        <div class="stat-label">Tổng lịch hủy</div>
        <div class="stat-value">{{ $stats['total'] }}</div>
    </div>
    <div class="stat-card unhandled">
        <div class="stat-label">Chưa xử lý</div>
        <div class="stat-value">{{ $stats['unhandled'] }}</div>
    </div>
    <div class="stat-card handled">
        <div class="stat-label">Đã xử lý</div>
        <div class="stat-value">{{ $stats['handled'] }}</div>
    </div>
</div>

{{-- Filter tabs --}}
<div class="filter-tabs">
    <a href="{{ route('admin.cancellations') }}" class="filter-tab {{ !request('filter') ? 'active' : '' }}">
        Tất cả <span class="cnt">{{ $stats['total'] }}</span>
    </a>
    <a href="{{ route('admin.cancellations', ['filter' => 'unhandled']) }}" class="filter-tab {{ request('filter') === 'unhandled' ? 'active' : '' }}">
        Chưa xử lý <span class="cnt">{{ $stats['unhandled'] }}</span>
    </a>
    <a href="{{ route('admin.cancellations', ['filter' => 'handled']) }}" class="filter-tab {{ request('filter') === 'handled' ? 'active' : '' }}">
        Đã xử lý <span class="cnt">{{ $stats['handled'] }}</span>
    </a>
</div>

{{-- Cancellation list --}}
@if($cancellations->isEmpty())
    <div class="empty-state">
        <i class="far fa-check-circle" style="color:#2ec4b6"></i>
        <h5>Không có lịch hủy nào cần xử lý</h5>
        <p>Tất cả lịch hẹn bị hủy đã được xử lý xong.</p>
    </div>
@else
    @foreach($cancellations as $idx => $booking)
    @php
        $slot     = $booking->timeSlot;
        $schedule = $slot?->doctorSchedule;
        $doctor   = $schedule?->doctor;
        $patient  = $booking->patient;
        $user     = $patient?->user;
        $patientName = $patient?->full_name ?? $user?->name ?? 'Bệnh nhân #?';
        $isHandled = $booking->admin_handled;
        $transferred = $booking->transferredTo;
    @endphp
    <div class="cx-card {{ $isHandled ? 'handled' : '' }}" style="animation-delay:{{ $idx * 0.04 }}s">
        <div class="cx-header" onclick="togglePanel({{ $booking->id }})">
            <img src="https://ui-avatars.com/api/?name={{ urlencode($patientName) }}&background=e63946&color=fff&size=44"
                 class="cx-avatar" alt="{{ $patientName }}">
            <div class="cx-info">
                <div class="cx-patient-name">
                    <i class="fas fa-user-injured mr-1" style="color:#e63946;font-size:12px"></i>
                    {{ $patientName }}
                </div>
                <div class="cx-meta">
                    <span class="cx-meta-item">
                        <i class="fas fa-user-md"></i>
                        BS. <span class="label">{{ $doctor?->full_name ?? '—' }}</span>
                    </span>
                    <span class="cx-meta-item">
                        <i class="far fa-calendar-alt"></i>
                        {{ $schedule ? \Carbon\Carbon::parse($schedule->work_date)->format('d/m/Y') : '—' }}
                    </span>
                    <span class="cx-meta-item">
                        <i class="far fa-clock"></i>
                        {{ $slot ? \Carbon\Carbon::parse($slot->start_time)->format('H:i') : '—' }}
                    </span>
                    @if($user?->email)
                    <span class="cx-meta-item">
                        <i class="fas fa-envelope"></i>
                        {{ $user->email }}
                    </span>
                    @endif
                </div>
            </div>
            <span class="cx-status-badge {{ $isHandled ? 'handled' : 'unhandled' }}">
                <i class="fas {{ $isHandled ? 'fa-check-circle' : 'fa-exclamation-circle' }}"></i>
                {{ $isHandled ? 'Đã xử lý' : 'Chờ xử lý' }}
            </span>
            <button type="button" class="cx-expand" id="expand-{{ $booking->id }}">
                <i class="fas fa-chevron-down"></i>
            </button>
        </div>

        <div class="cx-panel" id="panel-{{ $booking->id }}">
            <div class="cx-panel-inner">
                {{-- Cancel reason --}}
                <div class="reason-box">
                    <div class="reason-label"><i class="fas fa-pen mr-1"></i> Lý do hủy</div>
                    <div class="reason-text">{{ $booking->cancel_reason ?? 'Không có lý do' }}</div>
                </div>

                @if($isHandled)
                    {{-- Đã xử lý --}}
                    <div class="alert-info">
                        <i class="fas fa-info-circle"></i>
                        <div>
                            <strong>Ghi chú xử lý:</strong>
                            {{ $booking->handled_note ?? 'Không có ghi chú' }}
                            @if($transferred)
                                <br>→ Đã chuyển sang <strong>BS. {{ $transferred->timeSlot?->doctorSchedule?->doctor?->full_name ?? 'Bác sĩ khác' }}</strong>
                            @endif
                        </div>
                    </div>
                @else
                    {{-- Chưa xử lý - action buttons --}}
                    <div class="action-grid">
                        {{-- Chuyển bác sĩ --}}
                        <div class="action-card-btn" onclick="openTransferModal({{ $booking->id }}, '{{ $patientName }}')">
                            <span class="icon">🔄</span>
                            <div class="title">Chuyển bác sĩ khác</div>
                            <div class="desc">Giữ nguyên ngày giờ, đổi bác sĩ mới</div>
                        </div>

                        {{-- Xác nhận đã gọi khách --}}
                        <div class="action-card-btn danger" onclick="openHandleModal({{ $booking->id }}, '{{ $patientName }}')">
                            <span class="icon">📞</span>
                            <div class="title">Đã gọi khách - Xác nhận</div>
                            <div class="desc">Ghi nhận kết quả gọi điện cho khách</div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
    @endforeach
@endif

{{-- ===== MODAL: CHUYỂN BÁC SĨ ===== --}}
<div class="modal-overlay" id="transferModal">
    <div class="modal-box">
        <div class="modal-header">
            <h5><i class="fas fa-exchange-alt mr-2" style="color:#4361ee"></i> Chuyển bác sĩ</h5>
            <button type="button" class="modal-close" onclick="closeModal('transferModal')">&times;</button>
        </div>
        <form action="{{ route('admin.cancellations.transfer') }}" method="POST">
            @csrf
            <input type="hidden" name="booking_id" id="transferBookingId" value="">
            <div class="modal-body">
                <div class="alert-info" style="margin-bottom:16px">
                    <i class="fas fa-info-circle"></i>
                    <div>Giữ nguyên ngày giờ cũ, chuyển bệnh nhân <strong id="transferPatientName"></strong> sang bác sĩ khác.</div>
                </div>
                <div class="form-group">
                    <label><i class="fas fa-user-md"></i> Chọn bác sĩ mới</label>
                    <select name="new_doctor_id" class="form-control" required>
                        <option value="">-- Chọn bác sĩ --</option>
                        @foreach($doctors as $doc)
                        <option value="{{ $doc->id }}">
                            BS. {{ $doc->full_name }}
                            ({{ $doc->specialization?->name ?? 'N/A' }}
                            - {{ $doc->city?->name ?? 'N/A' }})
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label><i class="fas fa-sticky-note"></i> Ghi chú (tùy chọn)</label>
                    <textarea name="notes" class="form-control" placeholder="Ví dụ: Bệnh nhân đồng ý chuyển sang bác sĩ Nguyễn Văn B"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline" onclick="closeModal('transferModal')">Quay lại</button>
                <button type="submit" class="btn btn-primary"><i class="fas fa-check mr-1"></i> Xác nhận chuyển</button>
            </div>
        </form>
    </div>
</div>

{{-- ===== MODAL: XÁC NHẬN ĐÃ XỬ LÝ ===== --}}
<div class="modal-overlay" id="handleModal">
    <div class="modal-box">
        <div class="modal-header">
            <h5><i class="fas fa-phone-alt mr-2" style="color:#2ec4b6"></i> Xác nhận đã xử lý</h5>
            <button type="button" class="modal-close" onclick="closeModal('handleModal')">&times;</button>
        </div>
        <form action="{{ route('admin.cancellations.handle') }}" method="POST">
            @csrf
            <input type="hidden" name="booking_id" id="handleBookingId" value="">
            <input type="hidden" name="action" id="handleAction" value="handled">
            <div class="modal-body">
                <div class="alert-info" style="margin-bottom:16px">
                    <i class="fas fa-info-circle"></i>
                    <div>Ghi nhận kết quả gọi điện cho khách <strong id="handlePatientName"></strong>.</div>
                </div>
                <div class="form-group">
                    <label><i class="fas fa-tasks"></i> Kết quả xử lý</label>
                    <div style="display:flex;gap:12px;flex-wrap:wrap">
                        <label style="flex:1;padding:12px 16px;border:2px solid #dadce0;border-radius:10px;cursor:pointer;text-align:center;transition:all .2s" id="optHandled" onclick="selectHandleOption('handled')">
                            <input type="radio" name="_action_radio" value="handled" checked style="display:none">
                            <div style="font-size:20px;margin-bottom:4px">✅</div>
                            <div style="font-weight:700;font-size:12px;color:var(--text-dark)">Đồng ý hủy</div>
                            <div style="font-size:10px;color:var(--text-muted)">Khách đồng ý hủy</div>
                        </label>
                        <label style="flex:1;padding:12px 16px;border:2px solid #dadce0;border-radius:10px;cursor:pointer;text-align:center;transition:all .2s" id="optRescheduled" onclick="selectHandleOption('rescheduled')">
                            <input type="radio" name="_action_radio" value="rescheduled" style="display:none">
                            <div style="font-size:20px;margin-bottom:4px">📅</div>
                            <div style="font-weight:700;font-size:12px;color:var(--text-dark)">Hẹn lịch mới</div>
                            <div style="font-size:10px;color:var(--text-muted)">Khách muốn đặt lịch khác</div>
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <label><i class="fas fa-sticky-note"></i> Ghi chú</label>
                    <textarea name="handled_note" class="form-control" placeholder="Nhập ghi chú về cuộc gọi..."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline" onclick="closeModal('handleModal')">Quay lại</button>
                <button type="submit" class="btn btn-success"><i class="fas fa-check mr-1"></i> Xác nhận</button>
            </div>
        </form>
    </div>
</div>

<script>
// Auto hide messages
const successMsg = document.getElementById('successMsg');
const errorMsg = document.getElementById('errorMsg');
if (successMsg) setTimeout(() => successMsg.style.opacity = '0', 4000);
if (errorMsg) setTimeout(() => errorMsg.style.opacity = '0', 4000);

// Toggle panels
function togglePanel(id) {
    const panel = document.getElementById('panel-' + id);
    const btn   = document.getElementById('expand-' + id);
    panel.classList.toggle('open');
    btn.classList.toggle('open');
}

// Open transfer modal
function openTransferModal(bookingId, patientName) {
    document.getElementById('transferBookingId').value = bookingId;
    document.getElementById('transferPatientName').textContent = patientName;
    document.getElementById('transferModal').classList.add('show');
}

// Open handle modal
function openHandleModal(bookingId, patientName) {
    document.getElementById('handleBookingId').value = bookingId;
    document.getElementById('handlePatientName').textContent = patientName;
    document.getElementById('handleModal').classList.add('show');
}

// Select handle option
function selectHandleOption(action) {
    document.getElementById('handleAction').value = action;
    document.querySelectorAll('#handleModal [name="_action_radio"]').forEach(r => {
        r.checked = (r.value === action);
    });
    // Update visual
    document.getElementById('optHandled').style.borderColor = (action === 'handled') ? '#2ec4b6' : '#dadce0';
    document.getElementById('optHandled').style.background = (action === 'handled') ? '#e6faf8' : 'white';
    document.getElementById('optRescheduled').style.borderColor = (action === 'rescheduled') ? '#4361ee' : '#dadce0';
    document.getElementById('optRescheduled').style.background = (action === 'rescheduled') ? '#e8ecff' : 'white';
}
// Default selected
selectHandleOption('handled');

// Close modals
function closeModal(id) {
    document.getElementById(id).classList.remove('show');
}

// Close modal on overlay click
document.querySelectorAll('.modal-overlay').forEach(overlay => {
    overlay.addEventListener('click', function(e) {
        if (e.target === this) {
            this.classList.remove('show');
        }
    });
});
</script>
@endsection
