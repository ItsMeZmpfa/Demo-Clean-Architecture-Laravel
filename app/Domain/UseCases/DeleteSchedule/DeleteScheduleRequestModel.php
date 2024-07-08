<?php

namespace App\Domain\UseCases\DeleteSchedule;

class DeleteScheduleRequestModel
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

}