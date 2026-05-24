<?php

namespace Database\Seeders;

use App\Models\Specialty;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SpecialtySeeder extends Seeder
{
    public function run(): void
    {
        $specialties = [
            ['name' => 'Implant nha khoa',          'icon' => '🦷', 'description' => 'Cấy ghép răng giả bằng trụ titanium'],
            ['name' => 'Implant toàn hàm',          'icon' => '🦷', 'description' => 'Phục hình toàn bộ răng mất bằng All-on-4/6'],
            ['name' => 'Chỉnh nha - Niềng răng',    'icon' => '😁', 'description' => 'Mắc cài & khay niềng trong suốt'],
            ['name' => 'Nha khoa thẩm mỹ',          'icon' => '✨', 'description' => 'Thiết kế nụ cười và thẩm mỹ răng'],
            ['name' => 'Phục hình răng sứ',         'icon' => '👑', 'description' => 'Mão sứ, cầu răng sứ cao cấp'],
            ['name' => 'Nội nha - Điều trị tủy',    'icon' => '🩺', 'description' => 'Chữa tủy răng và sâu răng'],
            ['name' => 'Tiểu phẫu răng khôn',       'icon' => '🔧', 'description' => 'Nhổ răng khôn mọc lệch, mọc ngầm'],
            ['name' => 'Phẫu thuật hàm mặt',        'icon' => '🏥', 'description' => 'Phẫu thuật chỉnh hàm, vùng mặt'],
            ['name' => 'Tẩy trắng & thẩm mỹ răng',  'icon' => '✨', 'description' => 'Tẩy trắng răng chuyên sâu'],
            ['name' => 'Nha khoa trẻ em',           'icon' => '👶', 'description' => 'Chăm sóc răng miệng cho trẻ'],
            ['name' => 'Nha khoa tổng quát',        'icon' => '🦷', 'description' => 'Khám và điều trị tổng quát'],
        ];

        foreach ($specialties as $i => $sp) {
            Specialty::updateOrCreate(
                ['slug' => Str::slug($sp['name'])],
                [
                    'name'        => $sp['name'],
                    'icon'        => $sp['icon'],
                    'description' => $sp['description'],
                    'status'      => 1,
                    'sort_order'  => $i + 1,
                ]
            );
        }
    }
}
