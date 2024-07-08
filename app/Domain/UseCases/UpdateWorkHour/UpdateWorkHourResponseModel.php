<?php

namespace App\Domain\UseCases\UpdateWorkHour;

use App\Domain\Interfaces\WorkHour\WorkHourEntity;

class UpdateWorkHourResponseModel
{
    public function __construct(
        private bool $updateWorkHour,
    ) {
    }

    public function getUpdateWorkHour(): bool
    {
        return $this->updateWorkHour;
    }

}
