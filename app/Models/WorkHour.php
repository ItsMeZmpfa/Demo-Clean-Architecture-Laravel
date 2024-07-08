<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Domain\Interfaces\WorkHour\WorkHourEntity;
use App\Models\TimeValueObject;
use Illuminate\Database\Eloquent\Model;

class WorkHour extends Model implements WorkHourEntity
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'workHourId',
        'scheduleId',
        'startTime',
        'endTime',
    ];


            /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'updated_at',
        'created_at',
    ];
    
    // WorkHourEntity Methods

    /**
     * Get the Id of WorkHour
     * @return int
     */
    public function getWorkHourId():int
    {
        return $this->attributes['workHourId'] ?? '';
    }

    /**
     * Get the Id of Schedule
     * @return int
     */
    public function getWorkHourScheduleId():int
    {
        return $this->attributes['scheduleId'] ?? '';
    }

    /**
     * Get the Start Time
     * @return TimeValueObject
     */
    public function getWorkHourStartTime(): TimeValueObject
    {
        return $this->attributes['startTime'] ?? '';
    }

    /**
     * set Start Time WorkHour
     * @param TimeValueObject $startTime
     * @return void
     */
    public function setWorkHourStartTime(TimeValueObject $startTime): void
    {
        $this->attributes['startTime'] = $startTime;
    }

    /**
     * Get the End Time
     * @return TimeValueObject
     */
    public function getWorkHourEndTime(): TimeValueObject
    {
        return $this->attributes['endTime'] ?? '';
    }

    /**
     * set End Time WorkHour
     * @param TimeValueObject $endTime
     * @return void
     */
    public function setWorkHourEndTime(TimeValueObject $endTime): void
    {
        $this->attributes['endTime'] = $endTime;
    }
}