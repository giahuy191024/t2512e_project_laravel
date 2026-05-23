<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\DoctorWeekSchedule;
use App\Models\Doctor;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class GenerateNextWeekSchedules extends Command
{
    protected $signature = 'schedules:generate-next-week';
    protected $description = 'Copy each doctor\'s current week Mon-Sat entries into the next week (auto-generate)';

    public function handle()
    {
        $this->info('Starting generation of next week schedules...');

        $doctors = Doctor::all();
        foreach ($doctors as $doctor) {
            // Determine next week_start (Monday)
            $nextWeekStart = Carbon::now()->startOfWeek()->addWeek();

            // If doctor already has schedule for next week, skip
            $exists = DoctorWeekSchedule::where('doctor_id', $doctor->id)
                ->where('week_start', $nextWeekStart->toDateString())
                ->exists();
            if ($exists) {
                $this->info("Doctor {$doctor->id} already has schedule for week {$nextWeekStart->toDateString()}, skipping.");
                continue;
            }

            // Generate default: Mon-Sat (1..6), all slots
            $defaultSlots = DoctorWeekSchedule::defaultSlots();
            $toInsert = [];
            foreach (range(1,6) as $dow) { // 1=Mon ... 6=Sat
                foreach (array_keys($defaultSlots) as $slotCode) {
                    $toInsert[] = [
                        'doctor_id' => $doctor->id,
                        'week_start' => $nextWeekStart->toDateString(),
                        'day_of_week' => $dow,
                        'slot_code' => $slotCode,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }

            if (!empty($toInsert)) {
                DB::table('doctor_week_schedules')->insert($toInsert);
                $n = count($toInsert);
                $this->info("Generated default week for doctor {$doctor->id}: {$nextWeekStart->toDateString()} ({$n} entries)");
            }
        }

        $this->info('Done.');
        return 0;
    }
}
