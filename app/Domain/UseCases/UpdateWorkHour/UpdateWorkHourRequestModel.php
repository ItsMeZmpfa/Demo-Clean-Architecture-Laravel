<?php

namespace App\Domain\UseCases\UpdateWorkHour;

class UpdateWorkHourRequestModel
{
    /**
     * @param array<mixed> $attributes
     */
    public function __construct(private array $attributes) {
        //
    }

    public function getStartTime(): string
    {
        return $this->attributes['startTime'] ?? '';
    }

    public function getEndTime(): string
    {
        return $this->attributes['endTime'] ?? '';
    }

    public function getScheduleId(): int
    {
        return $this->attributes['scheduleId'] ?? '';
    }

}