<?php

namespace App\Domain\UseCases\DeleteSchedule;

use App\Domain\Interfaces\Schedule\ScheduleEntity;

class DeleteScheduleResponseModel
{
    public function __construct(
        private bool $statusOfDelete,
    ) {
    }

    public function getStatusOfDelete(): bool
    {
        return $this->statusOfDelete;
    }

}
