<?php

namespace App\Domain\UseCases\UpdateWorkHour;

use App\Domain\Interfaces\ViewModel;
use App\Domain\UseCases\UpdateWorkHour\UpdateWorkHourRequestModel;

interface UpdateWorkHourOutputPort
{
    public function workHourUpdate(UpdateWorkHourResponseModel $model): ViewModel;

    public function workHourNotExists(UpdateWorkHourResponseModel $model): ViewModel;

    public function unableToUpdateWorkHour(UpdateWorkHourResponseModel $model, \Throwable $e): ViewModel;
}