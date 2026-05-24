<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function index(Request $request)
    {
        $query = City::query();

        if ($search = $request->input('search')) {
            $query->where('name', 'like', "%$search%")
                ->orWhere('code', 'like', "%$search%");
        }

        if ($request->filled('status') && $request->input('status') !== '') {
            $query->where('status', (int) $request->input('status'));
        }

        $cities = $query->withCount('doctors')->orderBy('sort_order')->get();

        $stats = [
            'total'    => City::count(),
            'active'   => City::where('status', 1)->count(),
            'inactive' => City::where('status', 0)->count(),
        ];

        return view('admin.cities', compact('cities', 'stats'));
    }

    public function create()
    {
        return view('admin.cities_create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'       => 'required|string|max:100',
            'code'       => 'required|string|max:10|unique:cities,code',
            'status'     => 'required|in:0,1',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $data['sort_order'] = $data['sort_order'] ?? 0;

        City::create($data);

        return redirect()->route('admin.cities')
            ->with('success', '✅ Đã thêm thành phố thành công');
    }

    public function edit($id)
    {
        $city = City::findOrFail($id);
        return view('admin.cities_edit', compact('city'));
    }

    public function update(Request $request, $id)
    {
        $city = City::findOrFail($id);

        $data = $request->validate([
            'name'       => 'required|string|max:100',
            'code'       => 'required|string|max:10|unique:cities,code,' . $id,
            'status'     => 'required|in:0,1',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $data['sort_order'] = $data['sort_order'] ?? 0;

        $city->update($data);

        return redirect()->route('admin.cities')
            ->with('success', '✅ Đã cập nhật thành phố');
    }

    public function destroy($id)
    {
        $city = City::findOrFail($id);

        if ($city->doctors()->count() > 0) {
            return back()->with('error', '❌ Không thể xóa - thành phố đang được sử dụng bởi ' . $city->doctors()->count() . ' bác sĩ');
        }

        $city->delete();

        return back()->with('success', '✅ Đã xóa thành phố');
    }
}
