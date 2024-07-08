<?php

namespace App\Domain\UseCases\CreateNewSchedule;

class CreateNewScheduleRequestModel
{
    /**
     * @param array<mixed> $attributes
     */
    public function __construct(private array $attributes) {
        //
    }

    public function getEmployerId(): int
    {
        return $this->attributes['user_id'] ?? '';
    }

    public function getScheduleDate(): string
    {
        return $this->attributes['date'] ?? '';
    }

    public function getStartTime(): string
    {
        return $this->attributes['startTime'] ?? '';
    }

    public function getEndTime(): string
    {
        return $this->attributes['endTime'] ?? '';
    }
}