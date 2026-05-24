<?php

namespace App\Http\Controllers;

use App\Models\Specialty;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SpecialtyController extends Controller
{
    public function index(Request $request)
    {
        $query = Specialty::query();

        if ($search = $request->input('search')) {
            $query->where('name', 'like', "%$search%");
        }

        if ($request->filled('status') && $request->input('status') !== '') {
            $query->where('status', (int) $request->input('status'));
        }

        $specialties = $query->withCount('doctors')->orderBy('sort_order')->get();

        $stats = [
            'total'    => Specialty::count(),
            'active'   => Specialty::where('status', 1)->count(),
            'inactive' => Specialty::where('status', 0)->count(),
        ];

        return view('admin.specialties', compact('specialties', 'stats'));
    }

    public function create()
    {
        return view('admin.specialties_create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:150',
            'icon'        => 'nullable|string|max:50',
            'description' => 'nullable|string|max:255',
            'status'      => 'required|in:0,1',
            'sort_order'  => 'nullable|integer|min:0',
        ]);

        $data['slug']       = Str::slug($data['name']);
        $data['sort_order'] = $data['sort_order'] ?? 0;

        Specialty::create($data);

        return redirect()->route('admin.specialties')
            ->with('success', '✅ Đã thêm chuyên khoa thành công');
    }

    public function edit($id)
    {
        $specialty = Specialty::findOrFail($id);
        return view('admin.specialties_edit', compact('specialty'));
    }

    public function update(Request $request, $id)
    {
        $specialty = Specialty::findOrFail($id);

        $data = $request->validate([
            'name'        => 'required|string|max:150',
            'icon'        => 'nullable|string|max:50',
            'description' => 'nullable|string|max:255',
            'status'      => 'required|in:0,1',
            'sort_order'  => 'nullable|integer|min:0',
        ]);

        $data['slug']       = Str::slug($data['name']);
        $data['sort_order'] = $data['sort_order'] ?? 0;

        $specialty->update($data);

        return redirect()->route('admin.specialties')
            ->with('success', '✅ Đã cập nhật chuyên khoa');
    }

    public function destroy($id)
    {
        $specialty = Specialty::findOrFail($id);

        if ($specialty->doctors()->count() > 0) {
            return back()->with('error', '❌ Không thể xóa - chuyên khoa đang được sử dụng bởi ' . $specialty->doctors()->count() . ' bác sĩ');
        }

        $specialty->delete();

        return back()->with('success', '✅ Đã xóa chuyên khoa');
    }
}
