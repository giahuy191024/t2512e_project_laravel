<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $list = Student::latest()->get();
        return view('students.index', compact('list'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('students.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(\Illuminate\Http\Request $request)
    {
        $data = $request->validate([
            'fullName' => 'required',
            'email' => 'required',
            'phone' => 'required'
        ]);
        Student::create($data);
        return redirect()->route('students.index')->with('success', 'Thêm thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $obj = Student::find($id);
        return view('students.detail', compact('obj'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $obj = Student::find($id);
        return view('students.edit', compact('obj'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $obj = Student::find($id);
        $data = $request->validate([
            'fullName' => 'required',
            'email' => 'required',
            'phone' => 'required'
        ]);
        $obj->update($data);
        return redirect()->route('students.index')->with('success', 'Cập nhật thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $obj = Student::find($id);
        $obj->delete();
        return redirect()->route('products.index')->with('success', 'Xóa thành công!');
    }
}
