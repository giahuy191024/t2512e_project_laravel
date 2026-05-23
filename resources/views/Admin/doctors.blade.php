@extends('layouts.admin')
@section('title', 'Quản lý Bác Sĩ')

@section('content')
    @if(session('success'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <i class="fas fa-check-circle mr-1"></i> {{ session('success') }}
        </div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <ul class="mb-0">
                @foreach($errors->all() as $err)<li>{{ $err }}</li>@endforeach
            </ul>
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <h3 class="card-title mt-1"><i class="fas fa-user-md"></i> Danh sách Bác Sĩ ({{ $doctors->count() }})</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addDoctorModal">
                    <i class="fas fa-plus"></i> Thêm Bác Sĩ
                </button>
            </div>
        </div>

        <div class="card-body table-responsive p-0">
            <table class="table table-hover table-striped text-nowrap">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>BÁC SĨ</th>
                    <th>EMAIL</th>
                    <th>CHUYÊN KHOA</th>
                    <th>KINH NGHIỆM</th>
                    <th>TRẠNG THÁI</th>
                    <th class="text-right">HÀNH ĐỘNG</th>
                </tr>
                </thead>
                <tbody>
                @foreach($doctors as $d)
                    <tr>
                        <td class="align-middle">#{{ $d->id }}</td>
                        <td class="align-middle">
                            <div class="d-flex align-items-center">
                                @if($d->user?->avatar_url)
                                    <img src="{{ asset('storage/' . $d->user->avatar_url) }}"
                                         style="width:38px;height:38px;border-radius:50%;object-fit:cover;margin-right:10px">
                                @else
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($d->full_name) }}&background=4361ee&color=fff&size=80"
                                         style="width:38px;height:38px;border-radius:50%;object-fit:cover;margin-right:10px">
                                @endif
                                <div>
                                    <span class="font-weight-bold d-block">{{ $d->full_name }}</span>
                                    <small class="text-muted">{{ \Illuminate\Support\Str::limit($d->bio ?? '—', 40) }}</small>
                                </div>
                            </div>
                        </td>
                        <td class="align-middle">
                            <small class="text-info">{{ $d->user->email ?? 'N/A' }}</small>
                        </td>
                        <td class="align-middle">
                            @php
                                // Ưu tiên relationship (FK), fallback về column text legacy
                                $specialtyName = $d->getRelation('specialty')?->name ?? $d->specialty;
                            @endphp
                            <span class="badge badge-primary">{{ $specialtyName ?? 'Chưa rõ' }}</span>
                        </td>
                        <td class="align-middle">{{ $d->experience_years ?? 0 }} năm</td>
                        <td class="align-middle">
                            @if($d->status == 1)
                                <span class="badge badge-success">Hoạt động</span>
                            @else
                                <span class="badge badge-secondary">Tạm nghỉ</span>
                            @endif
                        </td>
                        <td class="text-right align-middle">
                            <a href="{{ route('admin.doctors.edit', $d->id) }}" class="btn btn-sm btn-info" title="Chỉnh sửa">
                                <i class="fas fa-pen"></i>
                            </a>
                            <form action="{{ route('admin.doctors.destroy', $d->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Xóa hồ sơ bác sĩ này?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" title="Xóa">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- MODAL THÊM BÁC SĨ --}}
    <div class="modal fade" id="addDoctorModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h4 class="modal-title"><i class="fas fa-user-plus mr-1"></i> Thêm Hồ Sơ Bác Sĩ</h4>
                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                </div>
                <form action="{{ route('admin.doctors.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body row">
                        <div class="col-md-12">
                            <h5 class="text-primary border-bottom pb-2 mb-3">1. Thông tin tài khoản</h5>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Email <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control" required placeholder="doctor@clinic.test">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Mật khẩu <span class="text-danger">*</span></label>
                            <input type="password" name="password" class="form-control" required minlength="6" placeholder="Tối thiểu 6 ký tự">
                        </div>

                        <div class="col-md-12">
                            <h5 class="text-primary border-bottom pb-2 mb-3 mt-3">2. Thông tin chuyên môn</h5>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Họ và Tên <span class="text-danger">*</span></label>
                            <input type="text" name="full_name" class="form-control" required placeholder="VD: BS. Nguyễn Văn An">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Chuyên khoa <span class="text-danger">*</span></label>
                            <select name="specialty_id" class="form-control" required>
                                <option value="">-- Chọn chuyên khoa --</option>
                                @foreach($specialties as $sp)
                                    <option value="{{ $sp->id }}">{{ $sp->icon }} {{ $sp->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Thành phố / Cơ sở <span class="text-danger">*</span></label>
                            <select name="city_id" class="form-control" required>
                                <option value="">-- Chọn thành phố --</option>
                                @foreach($cities as $c)
                                    <option value="{{ $c->id }}">{{ $c->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Số năm kinh nghiệm</label>
                            <input type="number" name="experience_years" class="form-control" min="0" value="0">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Trạng thái</label>
                            <select name="status" class="form-control">
                                <option value="1" selected>Hoạt động</option>
                                <option value="0">Tạm nghỉ</option>
                            </select>
                        </div>
                        <div class="col-md-12">
                            <h5 class="text-primary border-bottom pb-2 mb-3 mt-3">3. Tài liệu (tùy chọn)</h5>
                        </div>

                        <div class="form-group col-md-6">
                            <label>Ảnh đại diện</label>
                            <input type="file" name="avatar" class="form-control-file" accept="image/*">
                            <small class="text-muted">JPG, PNG. Tối đa 2MB</small>
                        </div>

                        <div class="form-group col-md-6">
                            <label>Chứng chỉ hành nghề</label>
                            <input type="file" name="certificate" class="form-control-file" accept=".jpg,.jpeg,.png,.pdf">
                            <small class="text-muted">JPG, PNG, PDF. Tối đa 5MB</small>
                        </div>
                        <div class="form-group col-md-12">
                            <label>Giới thiệu / Bio</label>
                            <textarea name="bio" class="form-control" rows="3" placeholder="VD: Bác sĩ chuyên khoa Tim mạch, tốt nghiệp Đại học Y Hà Nội..."></textarea>
                        </div>
                        <div class="col-md-12">
                            <small class="text-muted">
                                <i class="fas fa-info-circle"></i>
                                Sau khi tạo, bác sĩ có thể login để upload <strong>avatar</strong> và <strong>chứng chỉ hành nghề</strong> qua trang Hồ sơ cá nhân.
                            </small>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Hủy</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save mr-1"></i> Lưu Hồ Sơ
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
