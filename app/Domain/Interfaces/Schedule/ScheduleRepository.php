<?php

namespace App\Domain\Interfaces\Schedule;

use App\Domain\Interfaces\Schedule\ScheduleEntity;
use Illuminate\Support\Collection;

interface ScheduleRepository
{
    /**
     * Check if the given Schedule exists in Database
     * 
     * @param ScheduleEntity $schedule
     * @return bool
     */
    public function exists(ScheduleEntity $schedule): bool;

    /**
     * Create a new Schedule entry in the Database
     * 
     * @param ScheduleEntity $schedule
     * @return ScheduleEntity 
     */
    public function createSchedule(ScheduleEntity $schedule): ScheduleEntity;

    /**
     * Create a new Schedule entry in the Database
     * 
     * @param ScheduleEntity $schedule
     * @return bool 
     */
    public function deleteSchedule(ScheduleEntity $schedule): bool;
}