@extends('layouts.doctordashboard')
@section('title', 'Quản lý Lịch & Ca khám')

@section('content')
    <div class="card card-primary card-outline">
        <div class="card-header">
            <h3 class="card-title text-bold"><i class="fas fa-calendar-check mr-2"></i> Lịch trình chi tiết</h3>
            <div class="card-tools">
                <a href="{{ route('doctor.schedules.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> Đăng ký đợt mới
                </a>
            </div>
        </div>

        <div class="card-body p-0">
            <div id="accordion">
                @forelse($schedules as $groupKey => $groupItems)
                    @php
                        $first = $groupItems->first();
                        $last = $groupItems->last();
                        $groupId = md5($groupKey);
                        $idsInGroup = $groupItems->pluck('id')->toArray();
                    @endphp

                    <div class="border-bottom p-3">
                        <div class="row align-items-center">
                            <div class="col-md-4">
                                <span class="text-primary font-weight-bold">
                                    <i class="far fa-calendar-alt mr-1"></i>
                                    {{ \Carbon\Carbon::parse($first->work_date)->format('d/m/Y') }}
                                    <i class="fas fa-arrow-right mx-2 text-xs text-muted"></i>
                                    {{ \Carbon\Carbon::parse($last->work_date)->format('d/m/Y') }}
                                </span>
                            </div>
                            <div class="col-md-3">
                                <span class="badge badge-info shadow-sm">
                                    <i class="far fa-clock mr-1"></i> {{ $first->start_time }} - {{ $first->end_time }}
                                </span>
                            </div>
                            <div class="col-md-2 text-muted small">{{ $groupItems->count() }} ngày</div>
                            <div class="col-md-3 text-right d-flex justify-content-end align-items-center">
                                <button class="btn btn-sm btn-info shadow-sm mr-2 px-3" data-toggle="collapse" data-target="#collapse{{ $groupId }}">
                                    <i class="fas fa-eye mr-1"></i> Xem ca khám
                                </button>

                                <form action="{{route('doctor.schedules.destroy-Schedule_Group')}}" method="POST" onsubmit="return confirm('Xóa toàn bộ đợt lịch này?')">
                                    @csrf
                                    @method('DELETE')
                                    @foreach($idsInGroup as $id)
                                        <input type="hidden" name="ids[]" value="{{ $id }}">
                                    @endforeach
                                    <button type="submit" class="btn btn-sm btn-outline-danger btn-circle shadow-sm" title="Xóa toàn bộ đợt này">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </div>

                        <div id="collapse{{ $groupId }}" class="collapse mt-3 bg-light rounded p-3" data-parent="#accordion">
                            <div class="row">
                                @foreach($groupItems as $item)
                                    <div class="col-md-6 col-lg-4 mb-3">
                                        <div class="card h-100 shadow-sm border-0">
                                            <div class="card-header bg-white py-2">
                                                <strong class="text-dark small">{{ \Carbon\Carbon::parse($item->work_date)->translatedFormat('l') }}, {{ \Carbon\Carbon::parse($item->work_date)->format('d/m/Y') }}</strong>
                                            </div>
                                            <div class="card-body p-0">
                                                <table class="table table-sm mb-0">
                                                    <tbody class="small">
                                                    @foreach($item->timeSlots as $slot)
                                                        <tr>
                                                            <td class="pl-3 py-2 font-weight-bold text-secondary">{{ $slot->start_time }} - {{ $slot->end_time }}</td>
                                                            <td class="text-right pr-3 py-2">
                                                                @if($slot->current_patient == 0)
                                                                    <button class="btn btn-xs text-info p-0 mr-2"
                                                                            data-toggle="modal" data-target="#editSlotModal"
                                                                            data-id="{{ $slot->id }}"
                                                                            data-start="{{ $slot->start_time }}"
                                                                            data-end="{{ $slot->end_time }}">
                                                                        <i class="fas fa-edit"></i> Sửa
                                                                    </button>

                                                                    <button type="button"
                                                                            class="btn btn-xs text-danger p-0 btn-delete-slot"
                                                                            data-id="{{ $slot->id }}"
                                                                            data-url="{{ route('doctor.schedules.destroySlot', $slot->id) }}">
                                                                        <i class="fas fa-trash"></i> Xóa
                                                                    </button>
                                                                @else
                                                                    <span class="badge badge-warning">Đã có người đặt</span>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center p-5 text-muted">Chưa có lịch.</div>
                @endforelse
            </div>
        </div>
    </div>

    <div class="modal fade" id="editSlotModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-sm" role="document">
            <form action="{{ route('doctor.schedules.updateSlot') }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header py-2">
                        <h6 class="modal-title font-weight-bold">Sửa giờ ca khám</h6>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="slot_id" id="modal_slot_id">
                        <div class="form-group mb-2">
                            <label class="small">Giờ bắt đầu</label>
                            <input type="time" name="start_time" id="modal_start_time" class="form-control form-control-sm" required>
                        </div>
                        <div class="form-group mb-0">
                            <label class="small">Giờ kết thúc</label>
                            <input type="time" name="end_time" id="modal_end_time" class="form-control form-control-sm" required>
                        </div>
                    </div>
                    <div class="modal-footer py-2">
                        <button type="submit" class="btn btn-primary btn-sm btn-block">Lưu thay đổi</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @section('scripts')
        <script>
            // JS để đổ dữ liệu vào modal khi bác sĩ bấm nút "Sửa"
            $('#editSlotModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var id = button.data('id');
                var start = button.data('start');
                var end = button.data('end');

                var modal = $(this);
                modal.find('#modal_slot_id').val(id);
                modal.find('#modal_start_time').val(start);
                modal.find('#modal_end_time').val(end);
            });
            // Dùng $(document).on để chắc chắn nút nào cũng "ăn"
            $(document).ready(function() {
                console.log("1. Đã vào Document Ready"); // Kiểm tra xem JS có load không

                $(document).on('click', '.btn-delete-slot', function(e) {
                    e.preventDefault();
                    console.log("2. Đã bấm nút Xóa"); // Kiểm tra xem nút có ăn click không

                    let btn = $(this);
                    let url = btn.data('url');
                    console.log("3. URL nhận được là: " + url); // Kiểm tra xem lấy được URL không

                    if (confirm('Xác nhận xóa ca này?')) {
                        $.ajax({
                            url: url,
                            type: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                _method: 'DELETE'
                            },
                            success: function(response) {
                                console.log("4. Xóa thành công trên Server");
                                btn.closest('tr').fadeOut(300);
                            },
                            error: function(xhr) {
                                console.log("Lỗi Ajax: ", xhr.status);
                            }
                        });
                    }
                });
            });
        </script>
    @endsection

    <style>
        .collapse { transition: all 0.3s ease; }
        .bg-light { background-color: #f4f6f9 !important; }
        .table-sm td { vertical-align: middle; }
        .btn-circle {
            width: 32px;
            height: 32px;
            padding: 6px 0;
            border-radius: 50%;
            text-align: center;
            line-height: 1.42857;
            transition: all 0.3s ease;
        }

        /* Hiệu ứng hover cho nút xóa */
        .btn-outline-danger:hover {
            background-color: #dc3545;
            color: white;
            transform: scale(1.1); /* Phóng to nhẹ khi di chuột vào */
            box-shadow: 0 4px 8px rgba(220, 53, 69, 0.3);
        }

        /* Bo góc card và shadow nhẹ */
        .card {
            border-radius: 10px;
            overflow: hidden;
        }

        /* Chỉnh lại cái accordion cho sang */
        .border-bottom {
            border-bottom: 1px solid #edf2f7 !important;
            transition: background 0.2s;
        }

        .border-bottom:hover {
            background-color: #fcfdfe; /* Highlight nhẹ dòng đang xem */
        }

        .badge-info {
            background-color: #e1effe;
            color: #1e429f;
            padding: 5px 10px;
            border-radius: 6px;
        }
    </style>
@endsection
