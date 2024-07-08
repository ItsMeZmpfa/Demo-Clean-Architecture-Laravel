<?php

namespace App\Domain\UseCases\CreateNewSchedule;

use App\Domain\Interfaces\ViewModel;
use App\Domain\UseCases\CreateNewSchedule\CreateNewScheduleRequestModel;

interface CreateNewScheduleInputPort
{
    public function createSchedule(CreateNewScheduleRequestModel $model): ViewModel;
}