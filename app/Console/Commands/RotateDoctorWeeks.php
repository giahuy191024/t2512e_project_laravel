<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Doctor;
use App\Models\DoctorWeekSchedule;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class RotateDoctorWeeks extends Command
{
    protected $signature = 'doctor:rotate-weeks';
    protected $description = 'Xóa tuần lịch cũ và tự động thêm tuần mới cho tất cả bác sĩ';

    public function handle()
    {
        $today = Carbon::today();
        $mondayThisWeek = $today->copy()->startOfWeek(Carbon::MONDAY);

        // 1. Xóa các tuần đã qua (tuần kết thúc trước hôm nay)
        $deleted = DoctorWeekSchedule::where('week_start', '<', $mondayThisWeek->toDateString())->delete();
        $this->info("Đã xóa {$deleted} dòng lịch tuần cũ.");

        // 2. Thêm tuần mới cho bác sĩ chưa có
        $allDoctors = Doctor::all();
        $nextWeekStart = $mondayThisWeek->copy()->addWeek();
        $weekdays = range(1, 6); // Thứ 2 đến Thứ 7
        $defaultSlots = DoctorWeekSchedule::defaultSlots();
        $inserted = 0;

        foreach ($allDoctors as $doctor) {
            $hasNextWeek = DoctorWeekSchedule::where('doctor_id', $doctor->id)
                ->where('week_start', $nextWeekStart->toDateString())
                ->exists();
            if ($hasNextWeek) continue;
            foreach ($weekdays as $dow) {
                foreach (array_keys($defaultSlots) as $slot) {
                    DoctorWeekSchedule::create([
                        'doctor_id' => $doctor->id,
                        'week_start' => $nextWeekStart->toDateString(),
                        'day_of_week' => $dow,
                        'slot_code' => $slot,
                    ]);
                    $inserted++;
                }
            }
        }
        $this->info("Đã thêm {$inserted} dòng lịch tuần mới cho tất cả bác sĩ.");
        return 0;
    }
}
