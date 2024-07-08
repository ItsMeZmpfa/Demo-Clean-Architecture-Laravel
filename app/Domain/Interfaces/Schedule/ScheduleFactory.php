<?php

namespace App\Domain\Interfaces\Schedule;

use App\Domain\Interfaces\Schedule\ScheduleEntity;

interface ScheduleFactory
{
    /**
     * Create a Factory Object for new User
     *
     * @param array<mixed> $attributes
     * @return ScheduleEntity
     */
    public function makeSchedule(array $attributes = []): ScheduleEntity;


}
