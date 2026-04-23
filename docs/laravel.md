### Setup
  1. gitbash https://git-scm.com/downloads
  2. xampp: giúp ta cài database mysql, apache, php. https://www.apachefriends.org/download.html
  3. composer: giúp bản quản lý thư viện giống với maven, nuget, npm.  
    https://getcomposer.org/Composer-Setup.exe
  4. composer -> install laravel
    `composer global require laravel/installer`
  5. Tạo project laravel.
    - Chuột phải -> Git bash here tại thư mục muốn tạo project.
      `laravel new ten-cua-project`
      
### Editor

  - PHP Storm (visual studio code, sublime text, webstorm): webstorm -> php storm -> intellij IDEA
    - File > Open trỏ đến `thư mục chứa project` (nhìn thấy được thư mục app)
  - Quan trọng: trường hợp php storm không suggest code, chọn **File > Invalidate Caches**

### Terminal
  - Điều hướng
    - `cd ten-thu-muc` đi vào trong một thư mục.
    - `cd ..` đi ra ngoài một thư mục.
    - `cd ~` đi ra ngoài thư mục gốc.
    - `cd ~/Desktop` đi ra ngoài thư mục desktop.
  - Xoá nội dung trong terminal.
    - `cls` (windows)
    - `clear` (macos hoặc linux)
  - Tạo một thư mục
    - mkdir (make directory)
  - Khi gõ lệnh cần chủ động ấn Tab để terminal tự động hoàn thiện nốt câu lệnh.  
    
### Cấu trúc thư mục trong project laravel.
  - `app` chứa code php core hay cơ bản là những controller, entity, class php hỗ trợ trong quá trình 
    xây dựng project.
    - `app/Http/Controllers` chứa controller.
    - `app/Models` chứa entity (mapping với database như Product, Order, Customer) và model liên quan.
  - `resources/views` thư mục default chứa view của project, những file html quan trọng ở đây, có đuôi
    là `.blade.php` <- view engine chúng ta sử dụng.
  - `routes` chứa thông tin mapping request người dùng với các controller tương ứng.
    - `web.php` cần làm việc với thằng này.
  - `database` chứa các thông tin làm việc với cơ sở dữ liệu từ việc tạo bảng (migration) 
     đến tạo seeding (tạo dữ liệu mẫu).
  - `config` chứa thông tin cấu hình project, từ việc kết nối database đến cache, log...
  - `.env` là một file đặc biệt quan trọng khi chạy project, chứa thông tin cấu hình cơ bản 
    (được ưu tiên trước config)
    nếu không có file này, project không chạy được. Phần lớn các trường hợp kéo trên git về
    thì không có file này do tính chất bảo mật.
     
    
### Các lệnh thông dụng trong laravel và một số thao tác cần biết.
  - `php artisan serve` : chạy project.
    - Một số trường hợp lấy project từ trên git về.
      - composer chưa update, update composer bằng lệnh `composer update` hoặc `composer install`.
      - chưa có application key, mở file .env để check.
        - Nếu chưa có, chạy câu lệnh sau để sinh key: `php artisan key:generate`
  - Ctrl + C: thoát chương trình đang chạy.
  - Ấn nút mũi tên lên, xuống để chạy lại những lệnh vừa chạy.  
  - Một số trường hợp yêu cầu nhập password thì trong terminal khi bạn gõ password sẽ không được hiển thị,
    không có dấu * hay bất kỳ dấu hiệu -> gõ, hoặc enter cho báo lỗi và gõ lại.
  - `php artisan make:controller TenController` Câu lệnh tạo controller. 
    Lưu ý phần tên luôn viết hoa chữ cái đầu.
    
### Routing.
  - Cấu hình trong file `routes/web.php`.
  - Nếu mapping với console thì có thể hiêu đây là menu trong console. Mỗi lần người dùng
    nhập thông tin vào url và enter tương ứng với việc người dùng chọn 1, 2, 3 trong menu console.
    Cơ chế routing sẽ giúp laravel tìm được một function tương ứng để callback.
  - Cơ chế routing phụ thuộc vào
    - `method` (get, post, put, delete, patch...)
    - `link` (đường dẫn người dùng gõ trên trình duyệt),
    - `callback function` là function được gọi khi người dùng truy cập vào một đường dẫn tương ứng.
  - Callback function.
    - Có thể trả về đơn giản là text `return 'Hello world'`.
    - Có thể trả về một view `return view('ten-view')` 
      (laravel sẽ tự động tìm đến thư mục `resources/views` và tìm tên view tương ứng. Bỏ đuổi .blade.php)
    - `redirect` Có thể điều hướng người dùng sang một trang khác.  
  - Để project dễ quản lý hơn, thì chúng ta không định nghĩa function trong file `web.php` 
    mà thường khai báo thành các `controller` và các hàm tương ứng.
  - Sử dụng class Route trong package `Illuminate\Support\Facades\Route;`

### Controller.
  - Tạo controller.
    - Vào thư mục `app/Http/Controllers/`, tạo file `TenController.php` và phải là một php class
    extend từ `Controller`.
    - Chạy câu lệnh `php artisan make:controller TenController`, sẽ giúp tạo một controller với tên tương
    ứng mà không cần phải copy thêm code.
    
### View.
  - Sử dụng engine blade `.blade.php`.
  - Default các view nằm trong thư mục `resources/views` với đuôi mở rộng là `.blade.php`
  - View cho phép kết hợp code html, css, js với code php.
  - Có cơ chế để cho các câu lệnh php, if else, for, do while vào.
  - Có cơ chế để xây dựng layout cho project.

### Xử lý dữ liệu client gửi lên trong controller, các phương pháp lấy dữ liệu gửi lên.
  - Lấy dữ liệu gửi lên trong **form** thì cần lưu ý.
    - Form muốn gửi lên được phải `@csrf`.
    - Để lấy dữ liệu gửi lên từ form. Trong callback function sử dụng thêm tham số
    `Request` (`Illuminate\Http\Request`) dùng hàm get để lấy ra tham số theo tên.
      
          function functionName(Request $request){
            $firstName = $request->get('firstname');
            $lastName = $request->get('lastname');
            $country = $request->get('country');
          }
  - Lấy dữ liệu trong **query string** (tham số gửi trên url). Trong callback function sử dụng thêm tham số
    `Request` (`Illuminate\Http\Request`) dùng hàm get để lấy ra tham số theo tên giống như lấy ra ở form.
    - Ví dụ về query string: `http://localhost:8000/users/login?name=hung&email=hung@gmail&password=123&gender=1`
    - Tham số đầu tiên bắt đầu bằng dấu `?`, từ tham số thứ 2 thì là `&`.
  - Gửi dữ liệu thông qua **path variable**, khi khai báo link thì thêm dấu `{ten-bien}`. Ví dụ.
    `/users/detail/{id}`, callback function để làm việc với biến này thì khai báo như sau (tham số
    truyền vào của callback trùng tên với tên biến.)
        
          public function getUserDetail($id){
             return 'Hello path ' . $id;
          }

### Gửi dữ liệu từ controller ra view và cách hiển thị variable ngoài view.
  - Các function trong controller khi return view, ngoài tên view sẽ kèm theo biến.
    - `return view('ten-view'')->with('ten-bien-duoc-su-dung-ngoai-view', 'gia-tri-cua-bien')`.
    - `return view('ten-view', ['ten-bien-1'=> 'gia-tri-bien-1', 'ten-bien-2'=>'gia-tri-bien-2'])`
  - Ở ngoài view thì có thể dùng `{{$ten-bien-1}} {{$ten-bien-2}}` để hiển thị dữ liệu của biến.

### Hiển thị dữ liệu ngoài view. Những cấu trúc thường gặp. 
  - Tham khảo: https://laravel.com/docs/8.x/blade#if-statements
  - `{{$tenbien}}` hiển thị dữ liệu của biến hoặc biểu thức.
    - `{{ 10 + 20}}` cho kết quả bằng 30.
  - Câu lệnh điều kiện.
    
        @if($count > 1)
            <p>Hello</p>
        @endif
    
    hoặc sử dụng câu lệnh if với nhiều case

        @if (count($records) === 1)
            I have one record!
        @elseif (count($records) > 1)
            I have multiple records!
        @else
            I don't have any records!
        @endif

  - Sử dụng vòng lặp for i.

        @for($i = 0; $i < count($items); $i++)
            <p>{{$items[$i]}}</p>
        @endfor
    
  - Sử dụng vòng lặp foreach.

        @foreach($users as $user)
            <p>{{$user}}</p>
        @endfor
    
  - Sử dụng switch case.

        @switch($i)
            @case(1)
                <p>Number 1</p>
                @break
            @case(2)
                <p>Number 2</p>
                @break
            @case(3)
                <p>Number 3</p>
                @break
            @default
                <p>Default</p>
                break
        @endswitch
### Tạo layout với template blade.
  - Bộ khung chung làm layout `layout.blade.php`, chọn các phần để @yield, là nơi khác biệt giữa các trang con.
    - `@yield('content')` nội dung chính cho mỗi trang.
    - `@yield('title')` title cho mỗi trang.
    - `@yield('script')` dùng cho những trường hợp mà có file js riêng.
    - `@yield('css')` dùng cho những trường hợp có css riêng.
  - Tại các trang riêng cần lưu ý.
    - `@extends('layout')` dùng để khai báo layout dùng chung của trang. Cần lưu ý đường dẫn vào file `layout.blade.php`
      Cần trỏ đường dẫn đầy đủ kèm dấu `.` từ thư mục `views` vào bên trong file.
    - `@section('content') @endsection` tương ứng với từ khoá `@yield('content')` tạo ra các phần riêng của trang.
  - Nhúng tài nguyên vào trang.
    - Tất cả phần tài nguyên gồm: `css, js, image` nên cho vào thư mục public
    - Liên kết đến các file này sử dụng cú pháp: `{{URL::asset('js/index.js')}}`
      - Lưu ý là đường link sẽ tính bắt đầu từ public.
      - Không cần import namespace đầy đủ của lớp URL.
      - Khi copy template về thì phải sửa lại phần lớn link này.
### Làm việc với database.
  - Mở xampp, mở mysql và apache.
  - Cấu hình kết nối dabase trong file `.env`
        
        DB_CONNECTION=mysql
        DB_HOST=127.0.0.1
        DB_PORT=3306
        DB_DATABASE=t2009a_hello_laravel
        DB_USERNAME=root
        DB_PASSWORD=
    
  - Tạo model để mapping với các bảng trong database. 
    Câu lệnh tạo model kèm file migration (trong thư mục `database/migrations`): `php artisan make:model Product --migration`
  - Thực hiện udpate vào database. `php artisan migrate` `php artisan migrate:refresh`.
    - Lỗi `key too long` thì vào file `app/Providers/AppServiceProvider.php` trong hàm `boot`, 
    thêm dòng `Schema::defaultStringLength(191);`, cần bổ sung `use Illuminate\Support\Facades\Schema;` đầu file.
    - Lỗi báo bảng tồn tại, nếu đang trong `quá trình phát triển` thì có thể fix đơn giản tất cả bảng
    trong database và chạy lại lệnh.
    - Khi có thay đổi tên trường, thêm trường hoặc kiểu dữ liệu của trường thì sau khi sửa trong
    file migrate chạy `php artisan migrate:refresh` hoặc `php artisan migrate:fresh`
      
### Migration dữ liệu vào database.
  - Là quá trình khai báo và update kiểu dữ liệu các bảng từ code sang database.
  - `$table->increments('id');` tạo trường id tự tăng.
  - `$table->integer('price');` tạo trường price kiểu int.
  - `$table->string('name');` tạo trường name kiểu string.
  - `$table->integer('status')->default(1);` tạo trường status kiểu int có giá trị default 1.
  - `$table->integer('categoryId')->unsigned();` khai báo trường categoryId kiểu int nhưng phải là số dương.
    `$table->foreign('categoryId')->references('id')->on('categories');` 
    tạo ra một khoá ngoại trên bảng tại trường `categoryId` và có khoá chính là trường tên là `id`
    nhưng trên bảng `categories`
    thường đi thành một cặp để khai báo khoá ngoại.
  - `$table->timestamp('created_at')->default(\DB::raw('CURRENT_TIMESTAMP'));` tạo trường `created_at` kiểu
timestamp và lấy giá trị mặc định thời gian hiện tại.
  - Khi tạo khoá ngoại, ví dụ từ bảng `products` sang bảng `categories` thì phải tạo bảng 
`categories`, trong trường hợp sinh ra migrate của bảng product trước thì sửa nội dung ngày tháng
    để bảng `categories` có thể được tạo trước (trick) `2021_06_28_083424_create_products_table.php` sang
    `2021_06_28_083400_create_products_table.php`
    
### Seeder trong laravel.
  - Là quá trình tạo ra dữ liệu mẫu, phù hợp, đầy đủ cho project.
  - Đảm bảo quá trình demo sẽ thể hiện sự chuyên nghiệp của sản phẩm cũng như 
    có thể demo được những chức năng khó, đòi hỏi dữ liệu nhiều.
  - Dễ dàng backup và khởi tạo lại dữ liệu, phục vụ quá trình test.
  - Lệnh tạo `php artisan make:seeder TenSeeder`, tạo ra một file tên `TenSeeder` trong thư mục 
`database/seeders`. Lưu ý `TenSeeder` tương ứng với các bảng như `ProductSeeder`, `CategorySeeder`. Tên này với đuôi Seeder có thể thay đổi được,
    nhưng phải đảm bảo đồng bộ giữa các file. Mỗi một bảng cần có một file Seeder riêng biệt, không nên viết chung.
  - Các seeder nên sử dụng các dòng sau để tránh các vấn đề về khoá ngoại, và đảm bảo dữ liệu mới được sinh lại từ đầu.
      - `\Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS = 0');` thực hiện trước khi
        chạy seeder để đảm bảo quá trình insert update, không bị ảnh hưởng bởi khoá ngoại, thường dùng đầu file.
      - `\Illuminate\Support\Facades\DB::table('categories')->truncate();` thực hiện xoá hoàn toàn dữ liệu trong bảng
            nhưng không xoá bảng, nó reset id count về giá trị ban đầu là 0.
      - `\Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS = 1');`  mở lại quá trình check, thường dùng cuối file
  - Quá trình insert nên thức hiện theo mảng. Nền kèm id (kể cả tự tăng) để đảm bảo matching với khoá ngoại ở bảng khác. 
    

        \Illuminate\Support\Facades\DB::table('categories')->insert([
            [
                'name' => 'Lipstick',
                'images' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcR81NLdW06WdMGkj160-JKrFThFXCYqSyShd85PTd4uRDpEnmHw',
                'description' => 'Lipstick is a cosmetic product containing pigments, oils-v, waxes, and emollients that apply color, texture, and protection to the lips.'
            ],
            [
                'name' => 'Lip Gloss',
                'images' => 'https://media.loveitopcdn.com/6458/kcfinder/upload//images/cach-lam-son-bong-handmade-cho%20moi-cang-mong.jpg',
                'description' => 'Lip gloss is a product used primarily to give lips a glossy lustre, and sometimes to add a subtle color. It is distributed as a liquid or a soft solid (not to be confused with lip balm, which generally has medical or soothing purposes) or lipstick, which generally is a solid, cream like substance that gives off a more pigmented color',
            ]
        ]);
  - Nên insert thêm ngày tháng để phục vụ test.
      - Trong quá trình migrate sẽ có đoạn `$table->timestamps()` tự động thêm 2 trường `created_at`, `updated_at`.
      - Khi tạo seeder có thể trực tiếp thêm theo các cách sau.
        - `'created_at' => '1990-01-20'` đưa ngày tháng vào theo dạng chuỗi có định dạng `yyyy-MM-dd`.
        - `'created_at' => \Illuminate\Support\Carbon::now()` lấy theo đúng thời gian hiện tại khi chạy seed.
        - `'created_at' => \Illuminate\Support\Carbon::now()->addDays(-1)` lấy theo đúng thời gian hiện tại khi chạy seed, cộng thêm 1 ngày.
      - Việc tạo ngày tháng theo khoảng thời gian hiện tại đặc biệt quan trọng trong việc tạo dữ liệu thống kê, ví dụ:
      biểu đồ doanh thu theo thời gian, thị phần của sản phẩm...
  - Tổng kết, file seeder sẽ gần như sau.

        \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        \Illuminate\Support\Facades\DB::table('categories')->truncate();
        \Illuminate\Support\Facades\DB::table('categories')->insert([
            [
                'name' => 'Lipstick',
                'images' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcR81NLdW06WdMGkj160-JKrFThFXCYqSyShd85PTd4uRDpEnmHw',
                'description' => 'Lipstick is a cosmetic product containing pigments, oils-v, waxes, and emollients that apply color, texture, and protection to the lips.'
            ],
            [
                'name' => 'Lip Gloss',
                'images' => 'https://media.loveitopcdn.com/6458/kcfinder/upload//images/cach-lam-son-bong-handmade-cho%20moi-cang-mong.jpg',
                'description' => 'Lip gloss is a product used primarily to give lips a glossy lustre, and sometimes to add a subtle color. It is distributed as a liquid or a soft solid (not to be confused with lip balm, which generally has medical or soothing purposes) or lipstick, which generally is a solid, cream like substance that gives off a more pigmented color',
            ]
        ]);
        \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS = 1');
  - Trong file DatabaseSeeder hàm `run` thêm các đoạn gọi đến Seeder con để khi gọi db:seed sẽ chạy toàn bộ mà không cần gọi cụ thể từng file.
      - `$this->call(CategorySeeder::class);`
      - `$this->call(CustomerSeeder::class);`
  - Chạy dbseed bằng lệnh (lựa chọn 1): 
      - `php artisan db:seed` đơn thuần chạy lại file DatabaseSeeder.php 
      - `php artisan db:seed --class=UserSeeder` chạy lại file UserSeeder
      - `php artisan migrate:fresh --seed` vừa thực hiện reset hard database (xoá toàn bộ database cũ, migrate lại) và chạy file DatabaseSeeder.
    
### Model trong laravel.
  - Lấy ra danh sách các bản ghi:

        $list = Product::all();
        // đưa ra view.
  - Lấy theo id.

        $obj = Product::find(1); // id = 1
  - Lọc theo trường.

        $list = Product::where('ten-truong', '>', 'gia-tri') // các toán tử có thể là >, =, < like....
  - Tạo mới bản ghi.
    
        $obj = new Product();
        $obj->name = 'San pham 1';
        $obj->price = 10000;
        $obj->save();    

  - Update bản ghi.

        $obj = Product::find(1); // id = 1
        $obj->name = 'Giá trị update';
        $obj->price = 20000;
        $obj->save();
  - Delete bản ghi.
    
    Delete cứng.

        $obj = Product::find(1); // id = 1
        $obj->delete(); // hard delete
    
    Delete mềm.

        $obj = Product::find(1); // id = 1
        $obj->status = -1;
        $obj->updated_at = Carbon::now();
        $obj->save();

### Phân trang và customize phân trang.
  - Sử dụng phân trang mặc định. 
      - Trong phần controller khi lấy dữ liệu ra thay vì sử dụng `Model::all()` 
        thì chúng ta chuyển thành `Model::paginate(10)` trong đó 10 là số phần tử cho một trang.
        Ví dụ `Product::paginate(10)`
        
                return view('list-product', ['list'=> Product::paginate(10)]);
        
      - Trong phần view. Sử dụng cú pháp `{!! $list->links() !!}` để hiển thị các trang một cách mặc định.
      Lưu ý phần `$list` là tên biến được truyền từ controller. 
        
                {!! $list->links() !!}
      
  - Customize phân trang (khi thật sự hiểu cách phân trang có thể làm khác).
      - Tạo view riêng dành cho phân trang: tạo thư mục `pagination` trong `resources/views`, tạo file `default.blade.php`.
      - C1. Copy nội dung sau đưa vào file `default.blade.php`.
    
                @if ($paginator->lastPage() > 1)
                    <ul class="pagination">
                        <li class="{{ ($paginator->currentPage() == 1) ? ' disabled' : '' }}">
                            <a href="{{ $paginator->url(1) }}">Previous</a>
                        </li>
                        @for ($i = 1; $i <= $paginator->lastPage(); $i++)
                            <li class="{{ ($paginator->currentPage() == $i) ? ' active' : '' }}">
                                <a href="{{ $paginator->url($i) }}">{{ $i }}</a>
                            </li>
                        @endfor
                        <li class="{{ ($paginator->currentPage() == $paginator->lastPage()) ? ' disabled' : '' }}">
                            <a href="{{ $paginator->url($paginator->currentPage()+1) }}" >Next</a>
                        </li>
                    </ul>
                @endif
      - C2. Chi tiết hơn. Copy nội dung sau đưa vào file `default.blade.php`.
    
                <?php
                // config
                $link_limit = 7; // maximum number of links (a little bit inaccurate, but will be ok for now)
                ?>
                
                @if ($paginator->lastPage() > 1)
                    <ul class="pagination">
                        <li class="{{ ($paginator->currentPage() == 1) ? ' disabled' : '' }}">
                            <a href="{{ $paginator->url(1) }}">First</a>
                        </li>
                        @if($paginator->currentPage() > 1)
                            <li>
                                <a href="{{ $paginator->url($paginator->currentPage() - 1) }}">Previous</a>
                            </li>
                        @endif
                        @for ($i = 1; $i <= $paginator->lastPage(); $i++)
                            <?php
                            $half_total_links = floor($link_limit / 2);
                            $from = $paginator->currentPage() - $half_total_links;
                            $to = $paginator->currentPage() + $half_total_links;
                            if ($paginator->currentPage() < $half_total_links) {
                                $to += $half_total_links - $paginator->currentPage();
                            }
                            if ($paginator->lastPage() - $paginator->currentPage() < $half_total_links) {
                                $from -= $half_total_links - ($paginator->lastPage() - $paginator->currentPage()) - 1;
                            }
                            ?>
                            @if ($from < $i && $i < $to)
                                <li class="{{ ($paginator->currentPage() == $i) ? ' active' : '' }}">
                                    <a href="{{ $paginator->url($i) }}">{{ $i }}</a>
                                </li>
                            @endif
                        @endfor
                        @if($paginator->currentPage() < $paginator->lastPage())
                            <li>
                                <a href="{{ $paginator->url($paginator->currentPage() + 1) }}">Next</a>
                            </li>
                        @endif
                        <li class="{{ ($paginator->currentPage() == $paginator->lastPage()) ? ' disabled' : '' }}">
                            <a href="{{ $paginator->url($paginator->lastPage()) }}">Last</a>
                        </li>
                    </ul>
                @endif
      - Trong file danh sách thay vì 
        
            {!! $list->links() !!}
        
        thì chuyển thành 
        
            @include('pagination.default', ['paginator' => $list])
      - Lưu ý một số tên biến cần biết khi customize thêm.
        - `$paginator` là tên biến được truyền vào tại dùng @include.
        - `$paginator->lastPage()` là page cuối cùng.
        - `$paginator->currentPage()` là page hiện tại.
        - `$paginator->url(3)` sẽ hiện thị ra link cho trang thứ 3.
    
### Validate dữ liệu.
  - Sử dụng jquery validation `https://jqueryvalidation.org/documentation/` hoặc javascript. Xem lại kỳ 1.
  - Validate trong database sử dụng các rằng buộc, trigger, store procedure (sql server, mysql).
  - Sử dụng ngôn ngữ code backend để  validate. Với php laravel thì sẽ tiến hành theo link `https://laravel.com/docs/8.x/validation`
    - Cách 1. Validate tại controller.
    
            $request->validate(
                    [
                        'name' => 'required|min:10|max:15',
                        'price' => 'required'
                    ],
                    [
                        'name.required' => 'Vui lòng nhập tên.',
                        'name.min' => 'Tên phải lớn hơn 10 ký tự.',
                        'name.max' => 'Tên phải nhỏ hơn 15 ký tự.',
                    ]
              );
      
    - Cách 2. Validate tại `FormRequest` riêng biệt.
      - Tạo form request với câu lệnh sau.
      
            php artisan make:request StoreProductRequest
      - Trong hàm store của controller, chuyển tham số từ `Request $request` thành `StoreProductRequest $request`.
        Cụ thể, chuyển từ
        
            public function store(Request $request)
        Thành
        
            public function store(StoreProductRequest $request)
      - Trong `StoreProductRequest` khai báo rules cũng như message. `authorize()` return true.
    
            public function rules()
            {
                return [
                    'title' => 'required|unique:posts|max:255',
                    'body' => 'required',
                ];
            }
    
            public function messages()
            {
                return [
                    'name.required' => 'Vui lòng nhập tên.',
                    'name.min' => 'Tên phải lớn hơn 10 ký tự.',
                    'name.max' => 'Tên phải nhỏ hơn 15 ký tự.',
                    'price.required' => 'Vui lòng nhập giá.'
                ];
            }
        
            // validate theo business riêng.
            public function withValidator($validator)
            {
                $validator->after(function ($validator) {
                    if($this->get('name') == 'xuanhung'){
                        $validator->errors()->add('name', 'Tao không chơi với thằng Hùng.');
                    }
                });
            }
        
    - Danh sách validate rules: `https://laravel.com/docs/8.x/validation#available-validation-rules`.  
    - Tại view, hiển thị tổng quan lỗi ở đầu form.
    
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
    - Tại view, hiển thị lỗi tại từng trường, bên dưới là hiển thị lỗi cho trường `price`
    
            @error('price')
                <div class="text-danger">* {{ $message }}</div>
            @enderror
    
### Xử lý ảnh, upload và lưu trữ với cloudinary.
- Cloudinary
  - Dịch vụ lưu trữ file với dung lượng free lến 500Mb.
  - Hỗ trợ việc upload file cho nhiều ngôn ngữ khác nhau, trong đó có cả widget bằng html, css, js (dùng được ở nhiều các web framework khác nhau).
  - Hỗ trợ chỉnh sửa ảnh, crop, thay đổi kích thước. Điều này dẫn đến chúng ta có thể lấy ảnh phù hợp
    cho các thiết bị khác nhau: máy tính thì ảnh size to, mobile thì ảnh size nhỏ.
- Lý do.
  - Việc sử dụng html, js, css widget có thể dùng đi dùng lại trên các project với các ngôn ngữ khác.
  - Phù hợp trong quá trình học, thử nghiệm với 500Mb miễn phí.
  - Đơn giản, hiệu quả, tránh được các vấn đề liên quan đến bảo mật khi upload ảnh trực tiếp lên server chứa code php.
- Chuẩn bị.
  - Tài khoản cloudinary.
  - Tạo upload preset.  
- Cách nhúng widget vào trang.
  - Copy paste đoạn code sau.
    
        <button id="upload_widget" class="cloudinary-button">Upload files</button>
        <script src="https://upload-widget.cloudinary.com/global/all.js" type="text/javascript"></script>
        <script type="text/javascript">  
        var myWidget = cloudinary.createUploadWidget({
          cloudName: 'my_cloud_name', 
          uploadPreset: 'my_preset'}, function (error, result) { 
            if (!error && result && result.event === "success") { 
              //console.log('Done! Here is the image info: ', result.info.url); 
              console.log('Done! Here is the image info: ', result.info.secure_url); 
            }
          }
        )
        
        document.getElementById("upload_widget").addEventListener("click", function(){
            myWidget.open();
          }, false);
        </script>
  - Nút bấm upload có thể sửa theo style của template hiện tại. Nên bổ sung một trường hidden
    để khi upload thành công sẽ lấy link ảnh đã upload lưu vào trường hidden field. Trường hidden này 
    sẽ được gửi lên kèm form và vẫn có thể validate bình thường.
  - Có thể tạo các thẻ image preview để giúp người dùng có thể nhìn được những ảnh vừa upload.
  - Trường hợp lưu nhiều ảnh thì các ảnh có thể lưu thành chuỗi cách nhau bởi dấu ",". Việc này liên quan đến vấn đề
    lấy ảnh và hiển thị ảnh tại các trang khác. Giải quyết như sau.
      - Thêm thuộc tính cho model xử lý bóc tách ảnh để trả về một mảng các url.

            public function getListPhotoAttribute()
            {
                $array_image = [];
                if ($this->thumbnail) {
                $array_image = explode(',', $this->thumbnail);
                }
                //do whatever you want to do
                return $array_image;
            }
      - Thêm thuộc tính để model có thể dễ dàng lấy ra được ảnh default cũng như trong trường hợp mà
    không có ảnh (hiển thị ảnh default.)
        
            public function getDefaultThumbnailAttribute()
            {
                $array_image = $this->listPhoto;
                    if (count($array_image) > 0) {
                    return $array_image[0];
                } else {
                return 'https://link-anh-default.jpg';
                }
            }
       - Khi hiển thị ảnh ngoài view thì có thể dùng đoạn code sau.
    
            <img src="{{$obj->defaultThumbnail}}" style="width: 300px" alt="">
       
        hoặc hiển thị danh sách ảnh như sau.
    
            @foreach($obj->listPhoto as $url)
                <img src="{{$url}}" style="width: 300px" alt="">
            @endforeach
    
### Ẩn hiện menu theo url.
- Phương này sử dụng laravel để ẩn hiện menu khi admin chọn các link tương ứng. Có nhiều cách cũng như thư viện
có thể được sử dụng để làm điều này.
- Trong controller trả thêm các biến gồm `menu_parent` và `menu_action` với các giá trị tương ứng ra view.
  
        public static $menu_parent = 'article_category';   
        public function index()
        {
          $list = ArticleCategory::paginate(10);
          return view('admin.article_categories.list', [
            'list' => $list,
            'menu_parent' => self::$menu_parent,
            'menu_action' => 'list',
          ]);
        }
- Phía file `layout.blade.php` trong phần menu bổ sung thêm phần kiểm tra 2 biến trên để có thêm thêm class active cho menu tương ứng.
Ở ví dụ bên dưới thì 2 class `nav-expanded nav-active` được thêm vào menu khi 2 biến `$menu_parent` và `$menu_action` tương ứng với menu đó.

        <li class="nav-parent {{$menu_parent=='article_category'?' nav-expanded nav-active' : ''}}">
            <a>
                <i class="fa fa-map-marker" aria-hidden="true"></i>
                <span>Quản lý danh mục bài viết</span>
            </a>
            <ul class="nav nav-children">
                <li class="{{($menu_parent == 'article_category' && $menu_action == 'create')?'nav-active':''}}">
                    <a href="/admin/article-categories/create">
                        Thêm mới
                    </a>
                </li>
                <li class="{{($menu_parent == 'article_category' && $menu_action == 'list')?'nav-active':''}}">
                    <a href="/admin/article-categories">
                        Danh sách
                    </a>
                </li>
            </ul>
        </li>

### Session và việc sử dụng session trong laravel.
- Hiểu đơn giản là nơi lưu trữ các biến trong một thời gian có hạn, thường sẽ lưu những thông tin không quá quan trọng.
Tuỳ vào mức độ bảo mật mà thời gian expired của session sẽ ngắn hơn. Một số trường hợp ứng dụng của Session đó là việc 
lưu thông tin của người dùng vừa đăng nhập (id, username, email, fullName, thumbnail, avatar) hoặc lưu những thông tin 
như sản phẩm vừa xem, cụ thể hơn có thể là đơn hàng.
- Session có mối quan hệ với Cookie, mỗi khi người dùng vào một trang có enable session thì người dùng sẽ được cung cấp 
  một session id, và id này sẽ được lưu ở Cookie. Khi một thông tin lưu ở trong cookie thì mỗi request sẽ tự động đính kèm
  thông tin đó ở trong header.
- Một số thao tác cơ bản khi làm việc với session 
  - Lưu thông tin vào session.
        
        \Illuminate\Support\Facades\Session::put('ten-bien', $giaTriCuaBien);
  - Lấy thông tin từ session.
        
        \Illuminate\Support\Facades\Session::get('ten-bien');
  - Remove thông tin khỏi session.
        
        \Illuminate\Support\Facades\Session::forget('ten-bien');
  - Xoá tất cả thông tin trong session.
    
        \Illuminate\Support\Facades\Session::flush();
  - Thêm một biến vào session theo kiểu array (lúc này biến được thêm mặc định là 1 phần tử)
    
        \Illuminate\Support\Facades\Session::push('ten-cua-array', $phanTuTrongArray);
  - Kiểm tra sự tồn tại của biến trong session, hàm này trả về boolean.
        
        \Illuminate\Support\Facades\Session::has('ten-cua-bien');
  - Thêm một biến vào session để chỉ sử dụng một lần (Session sẽ tự xoá biến này khi lấy ra lần đầu tiên)
    
        \Illuminate\Support\Facades\Session::flash('ten-bien', $giaTriCuaBien);
    
- Xây dựng một shopping cart với laravel session một cách cơ bản.
  - Code phía controller.
  
        <?php

        namespace App\Http\Controllers;

        use App\Models\Product;
        use Illuminate\Http\Request;
        use Illuminate\Support\Facades\Session;
        use stdClass;

        class ShoppingCartController extends Controller
        {
            public static $menu_parent = 'shopping-cart';

        // show thông tin giỏ hàng.
        public function show()
        {
            // kiểm tra sự tồn tại của shopping cart trong session.
            $shoppingCart = null;
            // nếu có shopping cart rồi thì lấy ra
            if (Session::has('shoppingCart')) {
                $shoppingCart = Session::get('shoppingCart');
            } else {
                // nếu chưa có thì tạo shopping cart mới.
                $shoppingCart = [];
            }
            return view('cart', [
                'shoppingCart' => $shoppingCart
            ]);
        }

            // Thêm sản phẩm vào giỏ hàng kèm số lượng sản phẩm.
            public function add(Request $request)
            {
                // lấy thông tin sản phẩm.
                $productId = $request->get('id');
                // lấy số lượng sản phẩm cần thêm vào giỏ hàng.
                $productQuantity = $request->get('quantity');
                if($productQuantity <= 0){
                    return view('admin.errors.404', [
                        'msg' => 'Số lượng sản phẩm cần lớn hơn 0.',
                        'menu_parent' => self::$menu_parent,
                        'menu_action' => 'create'
                    ]);
                }
                // 1. Kiểm tra sự tồn tại của sản phẩm.
                $obj = Product::find($productId);
                // nếu không tồn tại thì trả về 404.
                if ($obj == null) {
                    return view('admin.errors.404', [
                        'msg' => 'Không tìm thấy sản phẩm',
                        'menu_parent' => self::$menu_parent,
                        'menu_action' => 'create'
                    ]);
                }
                // nếu có sản phẩm trong db.
                // 2. Check số lượng tồn kho. Nếu như số lượng mua lớn hơn số lượng trong kho thì báo lỗi.
        
                // kiểm tra sự tồn tại của shopping cart trong session.
                $shoppingCart = null;
                // nếu có shopping cart rồi thì lấy ra
                if (Session::has('shoppingCart')) {
                    $shoppingCart = Session::get('shoppingCart');
                } else {
                    // nếu chưa có thì tạo shopping cart mới.
                    $shoppingCart = [];
                }
                // kiểm tra sản phẩm có tồn tại trong giỏ hàng không.
                if (array_key_exists($productId, $shoppingCart)) {
                    // nếu có sản phẩm rồi thì update số lượng
                    $existingCartItem = $shoppingCart[$productId];
                    // tăng số lượng theo số lượng cần mua thêm.
                    $existingCartItem->quantity += $productQuantity;
                    // và lưu lại vào đối tượng shopping cart.
                    $shoppingCart[$productId] = $existingCartItem;
                } else {
                    // nếu chưa có tạo ra một cartItem mới, có thông tin trùng với thông tin sản phẩm từ
                    // trong database.
                    $cartItem = new stdClass();
                    $cartItem->id = $obj->id;
                    $cartItem->name = $obj->name;
                    $cartItem->unitPrice = $obj->price;
                    $cartItem->quantity = $productQuantity;
                    // đưa cartItem vào trong shoppingCart.
                    $shoppingCart[$productId] = $cartItem;
                }
                // update thông tin shopping cart vào session.
                Session::put('shoppingCart', $shoppingCart);
                return redirect('/cart/show');
            }
        
            public function update(Request $request)
            {
                // lấy thông tin sản phẩm.
                $productId = $request->get('id');
                // lấy số lượng sản phẩm cần thêm vào giỏ hàng.
                $productQuantity = $request->get('quantity');
                if($productQuantity <= 0){
                    return view('admin.errors.404', [
                        'msg' => 'Số lượng sản phẩm cần lớn hơn 0.',
                        'menu_parent' => self::$menu_parent,
                        'menu_action' => 'create'
                    ]);
                }
                // 1. Kiểm tra sự tồn tại của sản phẩm.
                $obj = Product::find($productId);
                // nếu không tồn tại thì trả về 404.
                if ($obj == null) {
                    return view('admin.errors.404', [
                        'msg' => 'Không tìm thấy sản phẩm',
                        'menu_parent' => self::$menu_parent,
                        'menu_action' => 'create'
                    ]);
                }
                // nếu có sản phẩm trong db.
                // 2. Check số lượng tồn kho. Nếu như số lượng mua lớn hơn số lượng trong kho thì báo lỗi.
        
                // kiểm tra sự tồn tại của shopping cart trong session.
                $shoppingCart = null;
                // nếu có shopping cart rồi thì lấy ra
                if (Session::has('shoppingCart')) {
                    $shoppingCart = Session::get('shoppingCart');
                } else {
                    // nếu chưa có thì tạo shopping cart mới.
                    $shoppingCart = [];
                }
                // kiểm tra sản phẩm có tồn tại trong giỏ hàng không.
                if (array_key_exists($productId, $shoppingCart)) {
                    // nếu có sản phẩm rồi thì update số lượng
                    $existingCartItem = $shoppingCart[$productId];
                    // tăng số lượng theo số lượng cần mua thêm.
                    $existingCartItem->quantity = $productQuantity;
                    // và lưu lại vào đối tượng shopping cart.
                    $shoppingCart[$productId] = $existingCartItem;
                }
                // update thông tin shopping cart vào session.
                Session::put('shoppingCart', $shoppingCart);
                return redirect('/cart/show');
            }
        
            public function remove(Request $request)
            {
                $productId = $request->get('id');
                $shoppingCart = null;
                // nếu có shopping cart rồi thì lấy ra
                if (Session::has('shoppingCart')) {
                    $shoppingCart = Session::get('shoppingCart');
                } else {
                    // nếu chưa có thì tạo shopping cart mới.
                    $shoppingCart = [];
                }
                unset($shoppingCart[$productId]); // Xoá giá trị theo key ở trong map với php.
                Session::put('shoppingCart', $shoppingCart);
                return redirect('/cart/show');
            }
        }
  - Code phía giao diện.
    
        <!DOCTYPE html>
        <html>
        <title>W3.CSS</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
        <body>
        
        <div class="w3-container">
            <h2>Shopping cart</h2>
            <p>Update your cart information</p>
        
            <table class="w3-table w3-table-all">
                <tr>
                    <th>Product Id</th>
                    <th>Product Name</th>
                    <th>Unit Price</th>
                    <th>Quantity</th>
                    <th>Total Price</th>
                    <th>Action</th>
                </tr>
                <?php
                    $totalPrice = 0;
                ?>
                @foreach($shoppingCart as $cartItem)
                    <?php
                    if (isset($cartItem)) {
                        $totalPrice += $cartItem->unitPrice * $cartItem->quantity;
                    }
                    ?>
                <tr>
                    <form action="/cart/update" method="post">
                        @csrf
                    <td>{{$cartItem->id}}</td>
                    <td>{{$cartItem->name}}</td>
                    <td>{{$cartItem->unitPrice}}</td>
                    <td>
                        <input type="hidden" name="id" value="{{$cartItem->id}}">
                        <input name="quantity" class="w3-input w3-border w3-quarter" type="number" min="1" value="{{$cartItem->quantity}}">
                    </td>
                    <td>{{$cartItem->unitPrice * $cartItem->quantity}}</td>
                    <td>
                        <button class="w3-button w3-indigo">Update</button>
                        <a href="/cart/remove?id={{$cartItem->id}}" onclick="return confirm('Bạn có chắc muốn xoá sản phẩm này khỏi giỏ hàng?')" class="w3-button w3-red">Delete</a>
                    </td>
                    </form>
                </tr>
                @endforeach
            </table>
            <div style="margin-top: 20px">
                <strong>Total price {{$totalPrice}}</strong>
            </div>
        </div>
        
        </body>
        </html>
  - Code phần routing.
    
        Route::get('/cart/show', [ShoppingCartController::class, 'show']);
        Route::get('/cart/add', [ShoppingCartController::class, 'add']);
        Route::post('/cart/update', [ShoppingCartController::class, 'update']);
        Route::get('/cart/remove', [ShoppingCartController::class, 'remove']);


- Xây dựng shopping cart sử dụng thư viện
  - https://github.com/Crinsane/LaravelShoppingcart#usage
    
### Xử lý lưu thông tin đơn hàng.

### Lệnh tổng hợp.
  - php artisan make:controller ProductController --resource
    





