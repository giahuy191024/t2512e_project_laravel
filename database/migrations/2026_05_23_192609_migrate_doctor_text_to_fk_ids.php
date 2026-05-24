<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // ===== MAP SPECIALTY TEXT → ID =====
        $specialtyMap = [
            // Legacy hospital (3 BS seed cũ)
            'Tim mạch'                  => 'Implant nha khoa',
            'Nhi khoa'                  => 'Nha khoa trẻ em',
            'Tai mũi họng'              => 'Phẫu thuật hàm mặt',

            // 10 specialties legacy (BS user nhập qua admin form)
            'Nha khoa tổng quát'        => 'Nha khoa tổng quát',
            'Implant & Phục hình răng'  => 'Implant nha khoa',
            'Chỉnh nha / Niềng răng'    => 'Chỉnh nha - Niềng răng',
            'Răng sứ thẩm mỹ'           => 'Phục hình răng sứ',
            'Veneer dán sứ'             => 'Nha khoa thẩm mỹ',
            'Cấy ghép Implant'          => 'Implant nha khoa',
            'Điều trị tủy / Răng sâu'   => 'Nội nha - Điều trị tủy',
            'Nhổ răng tiểu phẫu'        => 'Tiểu phẫu răng khôn',
            'Tẩy trắng răng'            => 'Tẩy trắng & thẩm mỹ răng',
            'Nha khoa trẻ em'           => 'Nha khoa trẻ em',
        ];

        // Lookup specialty name → id (1 query duy nhất)
        $specialtyIds = DB::table('specialties')->pluck('id', 'name')->toArray();

        // Update specialty_id từ text
        $doctors = DB::table('doctors')
            ->whereNull('specialty_id')
            ->whereNotNull('specialty')
            ->get();

        $countSpecialty = 0;
        foreach ($doctors as $doctor) {
            $mappedName = $specialtyMap[$doctor->specialty] ?? null;
            $specialtyId = $mappedName ? ($specialtyIds[$mappedName] ?? null) : null;

            if ($specialtyId) {
                DB::table('doctors')
                    ->where('id', $doctor->id)
                    ->update([
                        'specialty_id' => $specialtyId,
                        'specialty'    => $mappedName, // cập nhật text khớp với id mới
                    ]);
                $countSpecialty++;
            }
        }

        // ===== MAP CITY TEXT → ID =====
        $cityIds = DB::table('cities')->pluck('id', 'name')->toArray();

        $doctorsCity = DB::table('doctors')
            ->whereNull('city_id')
            ->whereNotNull('city')
            ->get();

        $countCity = 0;
        foreach ($doctorsCity as $doctor) {
            $cityId = $cityIds[$doctor->city] ?? null;
            if ($cityId) {
                DB::table('doctors')
                    ->where('id', $doctor->id)
                    ->update(['city_id' => $cityId]);
                $countCity++;
            }
        }

        echo "✅ Migrated {$countSpecialty} doctors specialty + {$countCity} doctors city\n";
    }

    public function down(): void
    {
        // Reset FK về null (giữ text)
        DB::table('doctors')->update([
            'specialty_id' => null,
            'city_id'      => null,
        ]);
    }
};
