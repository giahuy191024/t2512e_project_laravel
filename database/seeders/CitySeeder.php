<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    public function run(): void
    {
        $cities = [
            ['name' => 'Hà Nội',        'code' => 'HN'],
            ['name' => 'Hồ Chí Minh',   'code' => 'HCM'],
            ['name' => 'Đà Nẵng',       'code' => 'DN'],
        ];

        foreach ($cities as $i => $c) {
            City::updateOrCreate(
                ['code' => $c['code']],
                [
                    'name'       => $c['name'],
                    'status'     => 1,
                    'sort_order' => $i + 1,
                ]
            );
        }
    }
}
