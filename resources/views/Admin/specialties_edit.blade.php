@extends('layouts.admin')
@section('title', 'Sửa Chuyên khoa')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title mt-1"><i class="fas fa-edit"></i> Sửa Chuyên khoa: {{ $specialty->name }}</h3>
            <div class="card-tools">
                <a href="{{ route('admin.specialties') }}" class="btn btn-secondary btn-sm">
                    <i class="fas fa-arrow-left"></i> Quay lại
                </a>
            </div>
        </div>
        <form action="{{ route('admin.specialties.update', $specialty->id) }}" method="POST">
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
                    <label>Tên chuyên khoa <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $specialty->name) }}" required>
                    <small class="text-muted">Slug hiện tại: <code>{{ $specialty->slug }}</code> (sẽ tự cập nhật theo tên)</small>
                </div>

                <div class="form-group">
                    <label>Icon (emoji)</label>
                    <input type="text" name="icon" class="form-control" value="{{ old('icon', $specialty->icon) }}" maxlength="50">
                </div>

                <div class="form-group">
                    <label>Mô tả</label>
                    <textarea name="description" class="form-control" rows="2">{{ old('description', $specialty->description) }}</textarea>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Trạng thái <span class="text-danger">*</span></label>
                            <select name="status" class="form-control" required>
                                <option value="1" {{ old('status', $specialty->status) == 1 ? 'selected' : '' }}>Đang hoạt động</option>
                                <option value="0" {{ old('status', $specialty->status) == 0 ? 'selected' : '' }}>Không hoạt động</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Thứ tự hiển thị</label>
                            <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $specialty->sort_order) }}" min="0">
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Cập nhật</button>
                <a href="{{ route('admin.specialties') }}" class="btn btn-secondary">Hủy</a>
            </div>
        </form>
    </div>
@endsection
