@extends('layouts.doctordashboard')
@section('title', 'Lịch tuần của tôi')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title">Lịch tuần của tôi</h3>
            <a href="{{ route('doctor.schedules.create') }}" class="btn btn-primary">Đăng ký tuần mới</a>
        </div>
        <div class="card-body">
            @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
            @if($schedules->isEmpty())
                <p>Chưa có tuần nào được đăng ký.</p>
            @else
                @php
                    $dayNames = [1=>'Thứ 2',2=>'Thứ 3',3=>'Thứ 4',4=>'Thứ 5',5=>'Thứ 6',6=>'Thứ 7',7=>'Chủ nhật'];
                    $slotLabels = \App\Models\DoctorWeekSchedule::defaultSlots();
                @endphp

                <div class="d-flex gap-3 overflow-auto py-2" id="weeksRow">
                    @foreach($schedules as $weekStart => $items)
                        @php
                            $week = \Carbon\Carbon::parse($weekStart);
                            $display = $week->format('d/m/Y');
                            $byDay = $items->groupBy('day_of_week');
                        @endphp

                        <div class="card shadow" style="min-width:370px;background:#f8fafc">
                            <div class="card-header d-flex justify-content-between align-items-center bg-primary text-white">
                                <strong>Tuần bắt đầu: {{ $display }}</strong>
                                <!-- Nút xóa tuần đã bị ẩn theo yêu cầu, hệ thống sẽ tự xóa tuần cũ -->
                            </div>
                            <div class="card-body p-3">
                                @for($dow=1;$dow<=6;$dow++)
                                    <div class="mb-3 p-2 rounded" style="background:#fff;border:1px solid #e3e6ea;">
                                        <div class="d-flex align-items-center mb-2 flex-wrap">
                                            <div style="width:110px;font-weight:700;font-size:1.1em;color:#0d47a1">
                                                {{ $dayNames[$dow] ?? $dow }}
                                            </div>
                                            <div class="d-flex flex-row justify-content-center align-items-center gap-4 flex-nowrap" style="min-width:220px;">
                                                @foreach($slotLabels as $code => $label)
                                                    @php
                                                        $exists = isset($byDay[$dow]) && $byDay[$dow]->contains(fn($x)=> $x->slot_code===$code);
                                                    @endphp
                                                    <div class="form-check form-switch d-flex align-items-center" style="min-width:100px;">
                                                        <input class="form-check-input week-slot-toggle" type="checkbox" role="switch"
                                                            data-weekstart="{{ $weekStart }}" data-dow="{{ $dow }}" data-slot="{{ $code }}"
                                                            id="toggle_{{ $weekStart }}_{{ $dow }}_{{ $code }}" {{ $exists ? 'checked' : '' }}>
                                                        <label class="form-check-label ms-2" for="toggle_{{ $weekStart }}_{{ $dow }}_{{ $code }}">{{ $label }}</label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="d-flex gap-2">
                                            @foreach($slotLabels as $code => $label)
                                                @php
                                                    $exists = isset($byDay[$dow]) && $byDay[$dow]->contains(fn($x)=> $x->slot_code===$code);
                                                    $def = $code==='morning' ? ['08:00','11:30'] : ['13:00','16:30'];
                                                    $start = \Carbon\Carbon::createFromFormat('H:i', $def[0]);
                                                    $end = \Carbon\Carbon::createFromFormat('H:i', $def[1]);
                                                    $slots = [];
                                                    while($start->lt($end)) {
                                                        $slotStart = $start->format('H:i');
                                                        $slotEnd = $start->copy()->addMinutes(30);
                                                        if($slotEnd->gt($end)) $slotEnd = $end->copy();
                                                        $slots[] = $slotStart.'-'.$slotEnd->format('H:i');
                                                        $start->addMinutes(30);
                                                    }
                                                    $badgeId = 'badges_'.$weekStart.'_'.$dow.'_'.$code;
                                                @endphp
                                                <div id="{{ $badgeId }}" class="bg-gradient p-2 px-3 rounded border text-primary-emphasis"
                                                    style="background:linear-gradient(90deg,#e3f2fd,#fff);font-size:.95em;display:{{ $exists ? 'block':'none' }};">
                                                    <strong>{{ $label }}:</strong>
                                                    @foreach($slots as $s)
                                                        <span class="badge bg-primary-subtle border border-primary text-primary mx-1">{{ $s }}</span>
                                                    @endforeach
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endfor
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.querySelectorAll('.week-slot-toggle').forEach(cb => {
        cb.addEventListener('change', async function(){
            const weekStart = this.dataset.weekstart;
            const dow = this.dataset.dow;
            const slot = this.dataset.slot;
            const enabled = this.checked ? 1 : 0;

            // Hiện/ẩn badge ca 30 phút ngay khi bật/tắt
            const badgeId = `badges_${weekStart}_${dow}_${slot}`;
            const badge = document.getElementById(badgeId);
            if (badge) badge.style.display = enabled ? 'block' : 'none';

            try {
                const res = await fetch("{{ route('doctor.schedules.toggleWeekSlot') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ week_start: weekStart, day_of_week: dow, slot_code: slot, enabled: enabled })
                });
                const json = await res.json();
                if (!json.success) throw new Error(json.message || 'Error');
            } catch (err) {
                alert('Có lỗi khi lưu thay đổi: ' + err.message);
                // revert
                this.checked = !this.checked;
                if (badge) badge.style.display = this.checked ? 'block' : 'none';
            }
        });
    });
</script>
@endpush
