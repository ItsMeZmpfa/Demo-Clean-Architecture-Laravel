<?php

namespace App\Domain\Interfaces\Schedule;

use App\Models\TimeValueObject;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

interface ScheduleEntity
{

    /**
     * Get the Id of the Schedule
     * @return int
     */
    public function getScheduleId(): int;

    /**
     * Get the userId of the Schedule
     * @return int
     */
    public function getUserIdSchedule(): int;

    /**
     * set the userId of the Schedule
     * @return int
     */
    public function setUserIdSchedule(int $id): void;


    /**
     * 
     * Get Confirm Status of Schedule from a spefice user
     * @return bool
     */
    public function getConfirmStatus(): bool;

    /**
     * set Confirm Status of Schedule
     * @param bool $status
     * @return void
     */
    public function setConfirmStatus(bool $status): void;

    /**
     * 
     * Get Confirm date of Schedule from a spefice user
     * @return TimeValueObject
     */
    public function getConfirmDate(): TimeValueObject;

    /**
     * set Confirm Status of Schedule
     * @param TimeValueObject $date
     * @return void
     */
    public function setConfirmDate(TimeValueObject $date): void;
    

    /**
     * 
     * Get Confirm User who Authoritze the Confirm
     * @return string
     */
    public function getConfirmBy(): string;

    /**
     * set Confirm By of Schedule
     * @param string $date
     * @return void
     */
    public function setConfirmBy(string $confirmBy): void;

    /**
     * 
     * Get The Date of the Schedule
     * @return TimeValueObject
     */
    public function getScheduleDate(): TimeValueObject;
    
    /**
     * set Confirm By of Schedule
     * @param TimeValueObject $date
     * @return void
     */
    public function setScheduleDate(string $date): void;

    /**
     * The user that belong to the Schedule
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function user(): BelongsToMany;
}