@extends('layouts.patient')
@section('title', 'Tìm kiếm Bác sĩ')

@push('styles')
    <style>
        /* ===== PAGE HEADER ===== */
        .doctors-hero {
            background: linear-gradient(135deg, #1a73e8 0%, #0d47a1 100%);
            border-radius: 16px;
            padding: 36px 32px;
            margin-bottom: 28px;
            color: #fff;
            position: relative;
            overflow: hidden;
        }
        .doctors-hero::before {
            content: '\f0f0';
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            font-size: 160px;
            position: absolute;
            right: -20px;
            top: -20px;
            opacity: 0.07;
            color: #fff;
            pointer-events: none;
        }
        .doctors-hero h2 { font-size: 1.9rem; font-weight: 700; margin-bottom: 4px; }
        .doctors-hero p  { opacity: .85; margin: 0; }

        /* ===== FILTER CARD ===== */
        .filter-card {
            background: #fff;
            border-radius: 14px;
            box-shadow: 0 4px 20px rgba(26,115,232,.10);
            padding: 24px 28px;
            margin-bottom: 30px;
            border: none;
        }
        .filter-card label {
            font-size: .78rem;
            font-weight: 600;
            color: #5f6368;
            text-transform: uppercase;
            letter-spacing: .5px;
            margin-bottom: 6px;
        }
        .filter-card .form-control {
            border-radius: 10px;
            border: 1.5px solid #dadce0;
            font-size: .92rem;
            transition: border-color .2s, box-shadow .2s;
        }
        .filter-card .form-control:focus {
            border-color: #1a73e8;
            box-shadow: 0 0 0 3px rgba(26,115,232,.15);
        }
        .btn-filter {
            background: linear-gradient(135deg, #1a73e8, #0d47a1);
            color: #fff;
            border: none;
            border-radius: 10px;
            font-weight: 600;
            padding: 9px 0;
            transition: transform .15s, box-shadow .15s;
        }
        .btn-filter:hover { transform: translateY(-2px); box-shadow: 0 6px 18px rgba(26,115,232,.35); color:#fff; }
        .btn-reset {
            border-radius: 10px;
            font-weight: 600;
            padding: 9px 0;
            transition: background .2s;
        }

        /* ===== RESULT COUNT BADGE ===== */
        .result-count {
            font-size: .88rem;
            color: #5f6368;
            margin-bottom: 18px;
        }
        .result-count span {
            background: #e8f0fe;
            color: #1a73e8;
            font-weight: 700;
            border-radius: 20px;
            padding: 2px 10px;
        }

        /* ===== DOCTOR CARD ===== */
        .doctor-card {
            background: #fff;
            border-radius: 20px;
            border: none;
            box-shadow: 0 2px 16px rgba(0,0,0,.07);
            overflow: hidden;
            transition: transform .28s cubic-bezier(.34,1.56,.64,1), box-shadow .28s;
            animation: fadeInUp .4s ease both;
            display: flex;
            flex-direction: column;
        }
        .doctor-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 48px rgba(26,115,232,.16);
        }
        .dc-photo-wrap { position: relative; height: 200px; overflow: hidden; flex-shrink: 0; }
        .dc-photo-wrap img { width: 100%; height: 100%; object-fit: cover; object-position: center top; transition: transform .4s ease; }
        .doctor-card:hover .dc-photo-wrap img { transform: scale(1.05); }
        .dc-photo-overlay { position: absolute; inset: 0; background: linear-gradient(to bottom, transparent 40%, rgba(13,71,161,.75) 100%); }
        .dc-spec-badge {
            position: absolute; top: 12px; left: 12px;
            background: rgba(255,255,255,.92); color: #1a73e8;
            border-radius: 20px; padding: 4px 12px;
            font-size: .72rem; font-weight: 700; letter-spacing: .3px;
            backdrop-filter: blur(4px); box-shadow: 0 2px 8px rgba(0,0,0,.12);
        }
        .dc-spec-badge i { margin-right: 4px; }
        .dc-exp-badge {
            position: absolute; top: 12px; right: 12px;
            background: linear-gradient(135deg, #1a73e8, #0d47a1); color: #fff;
            border-radius: 20px; padding: 4px 10px; font-size: .7rem; font-weight: 700;
        }
        .dc-name-overlay { position: absolute; bottom: 12px; left: 14px; right: 14px; }
        .dc-name-overlay h4 { color: #fff; font-weight: 800; font-size: 1.05rem; margin: 0 0 2px; text-shadow: 0 1px 4px rgba(0,0,0,.3); }
        .dc-name-overlay .dc-title { color: rgba(255,255,255,.85); font-size: .75rem; }
        .dc-body { padding: 16px 18px 18px; flex: 1; display: flex; flex-direction: column; }
        .dc-stars { color: #fbbc04; font-size: .82rem; letter-spacing: 1px; }
        .dc-stars span { color: #6c757d; font-size: .75rem; margin-left: 4px; font-weight: 500; }
        .dc-info-row { display: flex; gap: 8px; margin: 12px 0; flex-wrap: wrap; }
        .dc-chip {
            display: inline-flex; align-items: center; gap: 5px;
            background: #f1f3f4; border-radius: 8px; padding: 5px 10px;
            font-size: .75rem; color: #3c4043; font-weight: 500; flex: 1; min-width: 0;
        }
        .dc-chip i { flex-shrink: 0; }
        .btn-book {
            display: block; width: 100%;
            background: linear-gradient(135deg, #1a73e8, #0d47a1); color: #fff;
            border: none; border-radius: 12px; padding: 11px 0;
            font-weight: 700; font-size: .9rem; letter-spacing: .3px;
            text-align: center; text-decoration: none; margin-top: auto;
            transition: transform .15s, box-shadow .15s;
            position: relative; overflow: hidden;
        }
        .btn-book:hover { color: #fff; transform: translateY(-2px); box-shadow: 0 8px 24px rgba(26,115,232,.45); text-decoration: none; }
        .empty-state { text-align: center; padding: 60px 20px; }
        .empty-state i { font-size: 64px; color: #dadce0; display: block; margin-bottom: 16px; }
        .empty-state h5 { color: #5f6368; font-weight: 600; }
        .empty-state p  { color: #9aa0a6; font-size: .9rem; }
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(28px); } to { opacity: 1; transform: translateY(0); } }
    </style>
@endpush

@section('content')

    {{-- ===== PAGE HERO ===== --}}
    <div class="doctors-hero">
        <h2><i class="fas fa-user-md mr-2"></i> Tìm kiếm Bác sĩ</h2>
        <p>Chọn chuyên khoa để tìm bác sĩ phù hợp với bạn</p>
    </div>

    {{-- ===== THANH LỌC ===== --}}
    <div class="filter-card">
        <form action="{{ route('patient.doctors') }}" method="GET">
            <div class="row align-items-end">

                {{-- Tìm theo tên --}}
                <div class="col-md-4 form-group mb-md-0">
                    <label for="keyword"><i class="fas fa-search mr-1"></i> Tên bác sĩ</label>
                    <input type="text" id="keyword" name="keyword" class="form-control"
                           placeholder="Nhập tên..." value="{{ request('keyword') }}" autocomplete="off">
                </div>

                {{-- Chuyên khoa --}}
                <div class="col-md-3 form-group mb-md-0">
                    <label for="specialty_id"><i class="fas fa-stethoscope mr-1"></i> Chuyên khoa</label>
                    <select name="specialty_id" id="specialty_id" class="form-control">
                        <option value="">-- Tất cả --</option>
                        @foreach($specialties as $sp)
                            <option value="{{ $sp->id }}" {{ request('specialty_id') == $sp->id ? 'selected' : '' }}>
                                {{ $sp->icon }} {{ $sp->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Thành phố (mới) --}}
                <div class="col-md-3 form-group mb-md-0">
                    <label for="city_id"><i class="fas fa-map-marker-alt mr-1"></i> Thành phố</label>
                    <select name="city_id" id="city_id" class="form-control">
                        <option value="">-- Tất cả --</option>
                        @foreach($cities as $c)
                            <option value="{{ $c->id }}" {{ request('city_id') == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Nút --}}
                <div class="col-md-2 form-group mb-0">
                    <label class="d-none d-md-block">&nbsp;</label>
                    <div class="d-flex gap-2" style="gap:8px;">
                        <button type="submit" class="btn btn-filter flex-fill">
                            <i class="fas fa-search mr-1"></i> Lọc
                        </button>
                        <a href="{{ route('patient.doctors') }}" class="btn btn-outline-secondary btn-reset flex-fill">
                            <i class="fas fa-undo"></i>
                        </a>
                    </div>
                </div>

            </div>
        </form>
    </div>

    {{-- ===== KẾT QUẢ ===== --}}
    <div class="result-count mb-3">
        Tìm thấy <span>{{ $doctors->count() }}</span> bác sĩ
        @if(request()->hasAny(['keyword','specialty_id','city_id']))
            phù hợp với bộ lọc
        @endif
    </div>

    <div class="row">
        @forelse($doctors as $d)
            <div class="col-xl-3 col-lg-4 col-md-6 mb-4 doctor-col">
                <div class="doctor-card">

                    {{-- ===== ẢNH BÁC SĨ ===== --}}
                    <div class="dc-photo-wrap">
                        @if($d->user->avatar_url)
                            <img src="{{ asset('storage/' . $d->user->avatar_url) }}"
                                 alt="Bác sĩ {{ $d->full_name }}" loading="lazy">
                        @else
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($d->full_name) }}&background=1a73e8&color=fff&size=300&bold=true&font-size=0.4"
                                 alt="Bác sĩ {{ $d->full_name }}" loading="lazy">
                        @endif
                        <div class="dc-photo-overlay"></div>

                        {{-- Badge chuyên khoa --}}
                            <div class="dc-spec-badge">
                                <i class="fas fa-stethoscope"></i>{{ $d->getRelation('specialty')?->name ?? $d->specialty ?? 'Chuyên khoa' }}
                            </div>

                        {{-- Badge kinh nghiệm --}}
                        @if($d->experience_years)
                            <div class="dc-exp-badge">
                                {{ $d->experience_years }} năm KN
                            </div>
                        @endif

                        {{-- Tên nổi trên ảnh --}}
                        <div class="dc-name-overlay">
                            <h4>{{ $d->full_name }}</h4>
                            <span class="dc-title">{{ \Illuminate\Support\Str::limit($d->bio ?? 'Bác sĩ chuyên khoa', 40) }}</span>
                        </div>
                    </div>

                    {{-- ===== BODY ===== --}}
                    <div class="dc-body">

                        {{-- Rating --}}
                        <div class="dc-stars mb-1">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                            <span>4.5 ({{ rand(20,120) }} đánh giá)</span>
                        </div>

                        {{-- Chips thông tin --}}
                        <div class="dc-info-row">
                            <div class="dc-chip">
                                <i class="fas fa-briefcase text-primary"></i>
                                <span>{{ $d->experience_years ? $d->experience_years . ' năm KN' : 'Chuyên gia' }}</span>
                            </div>
                            <div class="dc-chip">
                                <i class="fas fa-map-marker-alt text-danger"></i>
                                <span>{{ $d->getRelation('city')?->name ?? $d->city ?? '—' }}</span>
                            </div>
                        </div>
                        {{-- Nút đặt lịch --}}
                        <a href="{{ route('patient.booking', $d->id) }}" class="btn-book">
                            <i class="far fa-calendar-check mr-1"></i> Đặt lịch khám
                        </a>
                    </div>

                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="empty-state">
                    <i class="fas fa-user-slash"></i>
                    <h5>Không tìm thấy bác sĩ nào</h5>
                    <p>Hãy thử thay đổi bộ lọc hoặc <a href="{{ route('patient.doctors') }}">xem tất cả bác sĩ</a></p>
                </div>
            </div>
        @endforelse
    </div>

@endsection

