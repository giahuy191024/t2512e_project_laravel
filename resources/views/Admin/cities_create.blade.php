@extends('layouts.admin')
@section('title', 'Thêm Thành phố')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title mt-1"><i class="fas fa-plus-circle"></i> Thêm Thành phố mới</h3>
            <div class="card-tools">
                <a href="{{ route('admin.cities') }}" class="btn btn-secondary btn-sm">
                    <i class="fas fa-arrow-left"></i> Quay lại
                </a>
            </div>
        </div>
        <form action="{{ route('admin.cities.store') }}" method="POST">
            @csrf
            <div class="card-body">
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $err)<li>{{ $err }}</li>@endforeach
                        </ul>
                    </div>
                @endif

                <div class="form-group">
                    <label>Tên thành phố <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="Vd: Cần Thơ" required>
                </div>

                <div class="form-group">
                    <label>Mã code <span class="text-danger">*</span></label>
                    <input type="text" name="code" class="form-control" value="{{ old('code') }}" placeholder="Vd: CT" maxlength="10" required style="text-transform:uppercase">
                    <small class="text-muted">Mã viết hoa, 2-10 ký tự (HN, HCM, DN, CT...)</small>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Trạng thái <span class="text-danger">*</span></label>
                            <select name="status" class="form-control" required>
                                <option value="1" {{ old('status', '1') === '1' ? 'selected' : '' }}>Đang hoạt động</option>
                                <option value="0" {{ old('status') === '0' ? 'selected' : '' }}>Không hoạt động</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Thứ tự hiển thị</label>
                            <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', 0) }}" min="0">
                            <small class="text-muted">Số nhỏ hiển thị trước</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Lưu</button>
                <a href="{{ route('admin.cities') }}" class="btn btn-secondary">Hủy</a>
            </div>
        </form>
    </div>
@endsection
