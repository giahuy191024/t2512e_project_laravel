<?php

namespace Database\Seeders;

use App\Models\Doctor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DoctorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $doctors = [
            [
                'name' => 'Bác sĩ Nguyễn Huy Hoàng',
                'specialization' => 'Chính nha Implant',
                'biography' => 'Bác sĩ được đào tạo chuyên sâu về chính nha tại Đại học Kiến - Đức. Chuyên môn cao về điều trị khớp thái dương hàm. Đi đầu trong ứng dụng kỹ thuật mới.',
                'avatar' => 'https://via.placeholder.com/300x300?text=Doctor1',
                'phone' => '0912345678',
                'email' => 'huy.hoang@clinic.com',
                'qualifications' => 'Bác sĩ Nha khoa, Chứng chỉ Implant Quốc tế',
                'experience_years' => '10',
                'is_active' => true,
            ],
            [
                'name' => 'Bác sĩ Phạm Xuân Đăng',
                'specialization' => 'Chính nha Tổng quát',
                'biography' => 'Bác sĩ tốt nghiệp loại Giỏi Đại học Y Hà Nội. Chuyên môn cao về chính nha người lớn, chính nha sớm trẻ em. Đi đầu trong ứng dụng kỹ thuật hiện đại.',
                'avatar' => 'https://via.placeholder.com/300x300?text=Doctor2',
                'phone' => '0923456789',
                'email' => 'xuan.dang@clinic.com',
                'qualifications' => 'Bác sĩ Nha khoa, Chứng chỉ Chính nha hiện đại',
                'experience_years' => '12',
                'is_active' => true,
            ],
            [
                'name' => 'Bác sĩ Nguyễn Thị Thuỷ Hằng',
                'specialization' => 'Phục hình nha',
                'biography' => 'Bác sĩ được đào tạo chuyên sâu về phục hình trong miệng, nhạ chu. Đi đầu trong ứng dụng kỹ thuật số vào điều trị nhạ khoa.',
                'avatar' => 'https://via.placeholder.com/300x300?text=Doctor3',
                'phone' => '0934567890',
                'email' => 'thuy.hang@clinic.com',
                'qualifications' => 'Bác sĩ Nha khoa, Chứng chỉ Phục hình nha',
                'experience_years' => '8',
                'is_active' => true,
            ],
            [
                'name' => 'Bác sĩ Lê Thị Nhật Minh',
                'specialization' => 'Chính nha',
                'biography' => 'Bác sĩ được đào tạo chuyên sâu về chính nha tại Đại học Y Hà Nội. Có kinh nghiệm phong phú trong điều trị các trường hợp phức tạp.',
                'avatar' => 'https://via.placeholder.com/300x300?text=Doctor4',
                'phone' => '0945678901',
                'email' => 'nhat.minh@clinic.com',
                'qualifications' => 'Bác sĩ Nha khoa, Chứng chỉ Chính nha Nâng cao',
                'experience_years' => '15',
                'is_active' => true,
            ],
        ];

        foreach ($doctors as $doctor) {
            Doctor::create($doctor);
        }
    }
}
