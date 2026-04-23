CRUD cho bảng `products` step by step.

### 1. Cấu hình Database trong file .env

Mở file `.env` tại thư mục gốc và thiết lập các thông số kết nối cơ sở dữ liệu:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ten_database_cua_ban
DB_USERNAME=root
DB_PASSWORD=
```

### 2. Tạo Model và Migration

Chạy lệnh sau trong terminal để tạo Model `Product` kèm theo file migration:

```bash
php artisan make:model Product --migration
```

### 3. Cấu hình Product Schema

Tìm file migration vừa tạo trong thư mục `database/migrations/`. Thêm các trường dữ liệu cho bảng `products`:

```php
public function up(): void
{
    Schema::create('products', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->text('description')->nullable();
        $table->decimal('price', 10, 2);
        $table->integer('stock')->default(0);
        $table->timestamps();
    });
}
```

Trong file `app/Models/Product.php`, thêm thuộc tính `$fillable` để cho phép nạp dữ liệu hàng loạt:

```php
protected $fillable = ['name', 'description', 'price', 'stock'];
```

### 4. Chạy Migration

Thực hiện tạo cấu trúc bảng trong database:

```bash
php artisan migrate:fresh
```

### 5 & 6. Cấu hình Routes và Xây dựng View (Không dùng Controller)

Toàn bộ logic xử lý sẽ được viết trực tiếp trong `routes/web.php`. Các file giao diện sẽ nằm trong `resources/views/products/`.

#### Cấu hình file `routes/web.php`

```php
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::post('/products', function (Request $request) {
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
Route::put('/products/{product}', function (Request $request, Product $product) {
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
```

#### Tạo giao diện với Tailwind CSS

Sử dụng một file layout chung `resources/views/layouts/app.blade.php`:

```html
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel 12 CRUD</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-10">
    <div class="max-w-4xl mx-auto bg-white p-8 rounded-lg shadow-md">
        @yield('content')
    </div>
</body>
</html>
```

**Trang danh sách (`resources/views/products/index.blade.php`):**

```html
@extends('layouts.app')
@section('content')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Danh sách sản phẩm</h1>
        <a href="{{ route('products.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded">Thêm mới</a>
    </div>
    <table class="w-full text-left border-collapse">
        <thead>
            <tr class="border-b">
                <th class="py-2">Tên</th>
                <th class="py-2">Giá</th>
                <th class="py-2">Kho</th>
                <th class="py-2">Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
            <tr class="border-b">
                <td class="py-2">{{ $product->name }}</td>
                <td class="py-2">{{ number_format($product->price) }}đ</td>
                <td class="py-2">{{ $product->stock }}</td>
                <td class="py-2 flex gap-2">
                    <a href="{{ route('products.edit', $product->id) }}" class="text-yellow-600">Sửa</a>
                    <form action="{{ route('products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Xóa?')">
                        @csrf @method('DELETE')
                        <button class="text-red-600">Xóa</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
@endsection
```

**Trang thêm mới (`resources/views/products/create.blade.php`):**

```html
@extends('layouts.app')
@section('content')
    <h1 class="text-2xl font-bold mb-6">Thêm sản phẩm</h1>
    <form action="{{ route('products.store') }}" method="POST" class="space-y-4">
        @csrf
        <div>
            <label class="block">Tên sản phẩm</label>
            <input type="text" name="name" class="w-full border p-2 rounded">
        </div>
        <div>
            <label class="block">Giá</label>
            <input type="number" name="price" class="w-full border p-2 rounded">
        </div>
        <div>
            <label class="block">Số lượng</label>
            <input type="number" name="stock" class="w-full border p-2 rounded">
        </div>
        <div>
            <label class="block">Mô tả</label>
            <textarea name="description" class="w-full border p-2 rounded"></textarea>
        </div>
        <button class="bg-green-500 text-white px-4 py-2 rounded">Lưu sản phẩm</button>
    </form>
@endsection
```

**Trang chỉnh sửa (`resources/views/products/edit.blade.php`):**

```html
@extends('layouts.app')
@section('content')
    <h1 class="text-2xl font-bold mb-6">Sửa sản phẩm</h1>
    <form action="{{ route('products.update', $product->id) }}" method="POST" class="space-y-4">
        @csrf @method('PUT')
        <div>
            <label class="block">Tên sản phẩm</label>
            <input type="text" name="name" value="{{ $product->name }}" class="w-full border p-2 rounded">
        </div>
        <div>
            <label class="block">Giá</label>
            <input type="number" name="price" value="{{ $product->price }}" class="w-full border p-2 rounded">
        </div>
        <div>
            <label class="block">Số lượng</label>
            <input type="number" name="stock" value="{{ $product->stock }}" class="w-full border p-2 rounded">
        </div>
        <div>
            <label class="block">Mô tả</label>
            <textarea name="description" class="w-full border p-2 rounded">{{ $product->description }}</textarea>
        </div>
        <button class="bg-blue-500 text-white px-4 py-2 rounded">Cập nhật</button>
    </form>
@endsection
```
