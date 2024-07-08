<?php

namespace App\Domain\UseCases\DeleteSchedule;

use App\Domain\Interfaces\ViewModel;
use App\Domain\UseCases\DeleteSchedule\DeleteScheduleRequestModel;

interface DeleteScheduleOutputPort
{
    public function scheduleDelete(DeleteScheduleResponseModel $model): ViewModel;

    public function scheduleNotExists(DeleteScheduleResponseModel $model): ViewModel;

    public function unableToDeleteSchedule(\Throwable $e): ViewModel;
}