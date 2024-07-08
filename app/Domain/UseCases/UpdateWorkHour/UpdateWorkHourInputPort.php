<?php

namespace App\Domain\UseCases\UpdateWorkHour;

use App\Domain\Interfaces\ViewModel;
use App\Domain\UseCases\UpdateWorkHour\UpdateWorkHourRequestModel;

interface UpdateWorkHourInputPort
{
    public function updateWorkHour(UpdateWorkHourRequestModel $model): ViewModel;
}