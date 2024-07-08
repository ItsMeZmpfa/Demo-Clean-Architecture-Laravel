<?php

namespace App\Repositories\Schedule;

use App\Domain\Interfaces\Schedule\ScheduleEntity;
use App\Domain\Interfaces\Schedule\ScheduleRepository;
use App\Models\Schedule;

class ScheduleDatabaseRepository implements ScheduleRepository
{

    public function exists(ScheduleEntity $schedule): bool
    {

        return Schedule::where([
            'date' => $schedule->getScheduleDate()->toString(),
            'user_id' => $schedule->getUserIdSchedule(),
        ])->exists();
    }

    public function createSchedule(ScheduleEntity $schedule): ScheduleEntity
    {
        return Schedule::create([
            'date' => $schedule->getScheduleDate()->toString(),
            'user_id' => $schedule->getUserIdSchedule(),
        ]);

    }

    public function deleteSchedule(ScheduleEntity $schedule): bool
    {
        return Schedule::where([
            'date' => $schedule->getScheduleDate()->toString(),
            'user_id' => $schedule->getUserIdSchedule(),
        ])->delete();
    }
}
