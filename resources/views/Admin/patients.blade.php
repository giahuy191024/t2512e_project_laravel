@extends('layouts.admin')
@section('title', 'Danh sách Bệnh nhân')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title mt-1"><i class="fas fa-hospital-user"></i> Danh sách Bệnh nhân</h3>
        </div>

        <div class="card-body table-responsive p-0">
            <table class="table table-hover table-striped">
                <thead>
                <tr>
                    <th>Tên bệnh nhân</th>
                    <th>Email</th>
                    <th>Ngày đăng ký</th>
                    <th class="text-right">Hành động</th>
                </tr>
                </thead>
                <tbody>
                @foreach($patients as $p)
                    <tr>
                        <td class="align-middle">{{ $p->name }}</td>
                        <td class="align-middle">{{ $p->email }}</td>
                        <td class="align-middle">{{ $p->created_at->format('d/m/Y') }}</td>
                        <td class="text-right align-middle">
                            <button class="btn btn-sm btn-primary">
                                <i class="fas fa-file-medical"></i> Hồ sơ bệnh án
                            </button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
