<?php

namespace App\Domain\Interfaces\WorkHour;


use App\Models\TimeValueObject;

interface WorkHourEntity
{
    /**
     * Get the Id of WorkHour
     * @return int
     */
    public function getWorkHourId():int;

    /**
     * Get the Id of Schedule
     * 
     */
    public function getWorkHourScheduleId():int;

    /**
     * Get the Start Time
     * @return TimeValueObject
     */
    public function getWorkHourStartTime(): TimeValueObject;

    /**
     * set Start Time WorkHour
     * @param TimeValueObject $startTime
     * @return void
     */
    public function setWorkHourStartTime(TimeValueObject $startTime): void;

    /**
     * Get the End Time
     * 
     */
    public function getWorkHourEndTime(): TimeValueObject;

    
    /**
     * set End Time WorkHour
     * @param TimeValueObject $endTime
     * @return void
     */
    public function setWorkHourEndTime(TimeValueObject $endTime): void;


}