<?php

use App\Models\Product; // import
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// Danh sách sản phẩm
Route::get('/', function () {
    $products = Product::latest()->get();
    return view('products.index', compact('products'));
})->name('products.index');

// Form tạo mới
Route::get('/products/create', function () {
    return view('products.create');
})->name('products.create');

// Lưu sản phẩm
Route::post('/products', function (\Illuminate\Http\Request $request) {
    $data = $request->validate([
        'name' => 'required',
        'description' => 'nullable',
        'price' => 'required|numeric',
        'stock' => 'required|integer',
    ]);
    Product::create($data);
    return redirect()->route('products.index')->with('success', 'Thêm thành công!');
})->name('products.store');

// Form chỉnh sửa
Route::get('/products/{product}/edit', function (Product $product) {
    return view('products.edit', compact('product'));
})->name('products.edit');

// Cập nhật sản phẩm
Route::put('/products/{product}', function (\Illuminate\Http\Request $request, Product $product) {
    $data = $request->validate([
        'name' => 'required',
        'description' => 'nullable',
        'price' => 'required|numeric',
        'stock' => 'required|integer',
    ]);
    $product->update($data);
    return redirect()->route('products.index')->with('success', 'Cập nhật thành công!');
})->name('products.update');

// Xóa sản phẩm
Route::delete('/products/{product}', function (Product $product) {
    $product->delete();
    return redirect()->route('products.index')->with('success', 'Xóa thành công!');
})->name('products.destroy');
Route::get('/',function (){
   return view('auth');
});
Route::post('/auth', [AuthController::class, 'handleAuth']);

Route::get('/dashboard', function () {
    return "Đăng nhập thành công";
})->middleware('auth');

Route::post('/logout', [AuthController::class, 'logout']);
