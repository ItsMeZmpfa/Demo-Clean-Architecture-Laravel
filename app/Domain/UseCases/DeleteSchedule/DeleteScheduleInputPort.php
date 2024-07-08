<?php

namespace App\Domain\UseCases\DeleteSchedule;

use App\Domain\Interfaces\ViewModel;
use App\Domain\UseCases\DeleteSchedule\DeleteScheduleRequestModel;

interface DeleteScheduleInputPort
{
    public function deleteSchedule(DeleteScheduleRequestModel $model): ViewModel;
}