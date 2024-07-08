<?php

namespace App\Domain\UseCases\CreateNewSchedule;

use App\Domain\Interfaces\ViewModel;
use Throwable;

interface CreateNewScheduleOutputPort
{
    public function scheduleCreated(CreateNewScheduleResponseModel $model): ViewModel;

    public function scheduleAlreadyExists(CreateNewScheduleResponseModel $model): ViewModel;

    public function workHourAlreadyExists(CreateNewScheduleResponseModel $model): ViewModel;

    public function userNotExists(CreateNewScheduleResponseModel $model): ViewModel;

    public function unableToCreateSchedule(Throwable $e): ViewModel;
}
