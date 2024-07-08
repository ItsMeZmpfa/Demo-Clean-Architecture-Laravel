<?php

namespace App\Domain\Interfaces\WorkHour;

use App\Domain\Interfaces\WorkHour\WorkHourEntity;
use Illuminate\Support\Collection;

interface WorkHourRepository
{
    /**
     * Check if the given WorkHour with Time exists in Database
     * 
     * @param WorkHourEntity $workHour
     * @return bool
     */
    public function exists(WorkHourEntity $workHour): bool;

    /**
     * Check if the given WorkHour with Time exists in Database
     * 
     * @param WorkHourEntity $workHour
     * @return bool
     */
    public function existsSchedule(WorkHourEntity $workHour): bool;

    /**
     * Create a new Schedule entry in the Database
     * 
     * @param WorkHourEntity $workHour, $scheduleId
     * @return WorkHourEntity 
     */
    public function createWorkHour(WorkHourEntity $workHour,int $scheduleId): WorkHourEntity;

    /**
     * Create a new Schedule entry in the Database
     * 
     * @param WorkHourEntity $schedule
     * @return bool 
     */
    public function updateWorkHour(WorkHourEntity $workHour): bool;
}