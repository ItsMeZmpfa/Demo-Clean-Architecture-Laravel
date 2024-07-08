<?php

namespace App\Models;

use App\Domain\Interfaces\Schedule\ScheduleEntity;
use App\Models\TimeValueObject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model implements ScheduleEntity
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'scheduleId',
        'user_id',
        'confirmStatus',
        'confirmDate',
        'confirmBy',
        'date',
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


    // ScheduleEntity Methods

    /**
     * Get the Id of the Schedule
     * @return int
     */
    public function getScheduleId(): int
    {
        return $this->attributes['id'] ?? '';
    }

    /**
     * set the userId of the Schedule
     * @return int
     */
    public function setUserIdSchedule(int $id): void
    {
        $this->attributes['employerID'] = $id;
    }

    /**
     * Get the userId of the Schedule
     * @return int
     */
    public function getUserIdSchedule(): int
    {
        return $this->attributes['user_id'] ?? '';
    }

    /**
     * Get the Status of the Schedule
     * @return bool
     */
    public function getConfirmStatus(): bool
    {
        return $this->attributes['confirmStatus'] ?? '';
    }

    /**
     * set the first name of the user
     * @param string $userName
     * @return void
     */
    public function setConfirmStatus(bool $status): void
    {
        $this->attributes['confirmStatus'] = $status;
    }

    /**
     * 
     * Get Confirm date of Schedule from a spefice user
     * @return TimeValueObject
     */
    public function getConfirmDate(): TimeValueObject
    {
        $this->attributes['confirmDate'] ?? '';
    }

    /**
     * set Confirm Status of Schedule
     * @param TimeValueObject $date
     * @return void
     */
    public function setConfirmDate(TimeValueObject $date): void
    {
        $this->attributes['confirmDate'] = $date;
    }

    /**
     * 
     * Get Confirm User who Authoritze the Confirm
     * @return string
     */
    public function getConfirmBy(): string
    {
        $this->attributes['confirmBy'] ?? '';
    }

    /**
     * set Confirm By of Schedule
     * @param string $date
     * @return void
     */
    public function setConfirmBy(string $confirmBy): void
    {
        $this->attributes['confirmBy'] = $confirmBy;
    }

    /**
     * 
     * Get The Date of the Schedule
     * @return TimeValueObject
     */
    public function getScheduleDate(): TimeValueObject
    {

       return $this->attributes['date'] ?? '';
    }

    /**
     * set Confirm By of Schedule
     * @param TimeValueObject $date
     * @return void
     */
    public function setScheduleDate(string $date): void
    {
        $this->attributes['date'] = $date;
    }

    /**
     * The user that belong to the Schedule
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function user(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_schedule_table', 'user_id', 'schedule_id');
    }
}