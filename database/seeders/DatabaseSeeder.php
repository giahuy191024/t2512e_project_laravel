<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Doctor;
use App\Models\DoctorSchedule;
use App\Models\Patient;
use App\Models\PaymentMethod;
use App\Models\TimeSlot;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. ADMIN
        $admin = User::create([
            'full_name' => 'Quản Trị Viên',
            'email'     => 'admin@clinic.test',
            'password'  => Hash::make('password'),
            'role'      => User::ROLE_ADMIN,
            'gender'    => User::GENDER_MALE,
            'status'    => 'active',
        ]);

        // 2. BÁC SĨ (3 người, chuyên khoa khác nhau)
        $doctorsData = [
            ['Nguyễn Văn An',  'Tim mạch',     12, 'BS. CKII tim mạch, 12 năm kinh nghiệm.'],
            ['Trần Thị Bình',  'Nhi khoa',      8, 'Bác sĩ chuyên khoa Nhi, tận tâm với trẻ em.'],
            ['Lê Hoàng Minh',  'Tai mũi họng', 15, 'BS. CKI Tai-Mũi-Họng, giảng viên Đại học Y.'],
        ];

        foreach ($doctorsData as $i => [$name, $specialty, $exp, $bio]) {
            $user = User::create([
                'full_name'  => 'BS. ' . $name,
                'email'      => 'doctor' . ($i + 1) . '@clinic.test',
                'password'   => Hash::make('password'),
                'role'       => User::ROLE_DOCTOR,
                'gender'     => $i === 1 ? User::GENDER_FEMALE : User::GENDER_MALE,
                'avatar_url' => 'images/doctors/doctor' . ($i + 1) . '.jpg',
                'status'     => 'active',
            ]);
            Doctor::create([
                'user_id'          => $user->id,
                'specialty'        => $specialty,
                'experience_years' => $exp,
                'bio'              => $bio,
                'status'           => Doctor::STATUS_ACTIVE,
                'created_by'       => $admin->id,
            ]);
        }

        // 3. BỆNH NHÂN (3 người)
        $patientsData = [
            ['Phạm Thu Hà',  '0901234567', 'Hà Nội',     'Cầu Giấy'],
            ['Đỗ Quốc Hùng', '0912345678', 'Hà Nội',     'Đống Đa'],
            ['Vũ Thị Lan',   '0923456789', 'Hồ Chí Minh', 'Quận 1'],
        ];

        foreach ($patientsData as $i => [$name, $phone, $city, $district]) {
            $user = User::create([
                'full_name' => $name,
                'email'     => 'patient' . ($i + 1) . '@clinic.test',
                'password'  => Hash::make('password'),
                'role'      => User::ROLE_PATIENT,
                'gender'    => $i === 1 ? User::GENDER_MALE : User::GENDER_FEMALE,
                'status'    => 'active',
            ]);
            Patient::create([
                'user_id'       => $user->id,
                'phone_number'  => $phone,
                'email_contact' => $user->email,
                'city'          => $city,
                'district'      => $district,
                'address_line'  => 'Địa chỉ mẫu số ' . ($i + 1),
            ]);
        }

        // 4. PAYMENT METHODS
        PaymentMethod::insert([
            ['code' => 'CASH',  'method_name' => 'Tiền mặt',                 'is_active' => true],
            ['code' => 'MOMO',  'method_name' => 'Ví Momo',                  'is_active' => true],
            ['code' => 'VNPAY', 'method_name' => 'VNPay',                    'is_active' => true],
            ['code' => 'BANK',  'method_name' => 'Chuyển khoản ngân hàng',   'is_active' => true],
        ]);

        // 5. LỊCH KHÁM + TIME SLOTS (3 ngày tới, mỗi ngày 4 slot 30 phút)
        $doctors = Doctor::all();
        foreach ($doctors as $doctor) {
            for ($day = 1; $day <= 3; $day++) {
                $schedule = DoctorSchedule::create([
                    'doctor_id'  => $doctor->id,
                    'work_date'  => Carbon::today()->addDays($day),
                    'start_time' => '08:00:00',
                    'end_time'   => '10:00:00',
                ]);
                $slotStart = Carbon::createFromTime(8, 0);
                for ($s = 0; $s < 4; $s++) {
                    TimeSlot::create([
                        'schedule_id'     => $schedule->id,
                        'start_time'      => $slotStart->copy()->format('H:i:s'),
                        'end_time'        => $slotStart->copy()->addMinutes(30)->format('H:i:s'),
                        'max_patient'     => 2,
                        'current_patient' => 0,
                        'status'          => TimeSlot::STATUS_AVAILABLE,
                    ]);
                    $slotStart->addMinutes(30);
                }
            }
        }

        // 6. 1 BOOKING MẪU
        $firstSlot = TimeSlot::first();
        $firstPatient = Patient::first();
        Booking::create([
            'slot_id'    => $firstSlot->id,
            'patient_id' => $firstPatient->id,
            'status'     => Booking::STATUS_CONFIRMED,
            'created_by' => $firstPatient->user_id,
        ]);
        $firstSlot->increment('current_patient');

        $this->command->info('✅ Seed xong!');
        $this->command->info('   Admin:   admin@clinic.test / password');
        $this->command->info('   Doctor:  doctor1@clinic.test / password');
        $this->command->info('   Patient: patient1@clinic.test / password');
    }
}
