<?php

namespace App\Repositories\WorkHour;

use App\Domain\Interfaces\WorkHour\WorkHourEntity;
use App\Domain\Interfaces\WorkHour\WorkHourRepository;
use App\Models\WorkHour;

class WorkHourDatabaseRepository implements WorkHourRepository
{
    public function exists(WorkHourEntity $workHour): bool
    {
        return WorkHour::where([
            'startTime' => $workHour->getWorkHourStartTime()->toString(),
            'endTime' => $workHour->getWorkHourEndTime()->toString(),
        ])->exists();
    }

    public function existsSchedule(WorkHourEntity $workHour): bool
    {
        return WorkHour::where([
            'scheduleId' => $workHour->getWorkHourScheduleId(),
        ])->exists();
    }

    public function createWorkHour(WorkHourEntity $workHour,int $scheduleId): WorkHourEntity
    {
        return WorkHour::create([
            'scheduleId' => $scheduleId,
            'startTime' => $workHour->getWorkHourStartTime()->toString(),
            'endTime' => $workHour->getWorkHourEndTime()->toString(),
        ]);
    }

    public function updateWorkHour(WorkHourEntity $workHour): bool
    {

        return WorkHour::where('scheduleId',$workHour->getWorkHourScheduleId())->update([
            'startTime' => $workHour->getWorkHourStartTime()->toString(),
            'endTime' => $workHour->getWorkHourEndTime()->toString(),
        ]);
    }
}