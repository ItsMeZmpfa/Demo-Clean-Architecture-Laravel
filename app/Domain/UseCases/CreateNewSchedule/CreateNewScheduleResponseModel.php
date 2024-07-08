<?php

namespace App\Domain\UseCases\CreateNewSchedule;

use App\Domain\Interfaces\Schedule\ScheduleEntity;
use App\Domain\Interfaces\WorkHour\WorkHourEntity;

class CreateNewScheduleResponseModel
{
    public function __construct(
        private ScheduleEntity $schedule,
        private WorkHourEntity $workHour
    ) {
    }



    public function getSchedule(): ScheduleEntity
    {
        return $this->schedule;
    }

    public function getWorkHour(): WorkHourEntity
    {
        return $this->workHour;
    }
}