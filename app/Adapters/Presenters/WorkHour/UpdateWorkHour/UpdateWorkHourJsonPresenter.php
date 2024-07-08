<?php

namespace App\Adapters\Presenters\WorkHour\UpdateWorkHour;

use App\Adapters\ViewModels\JsonResourceViewModel;
use App\Domain\Interfaces\ViewModel;
use App\Domain\UseCases\UpdateWorkHour\UpdateWorkHourOutputPort;
use App\Domain\UseCases\UpdateWorkHour\UpdateWorkHourResponseModel;
use App\Http\Resources\WorkHour\UnableToUpdateWorkHourResource;
use App\Http\Resources\WorkHour\UpdateWorkNotExistsResource;
use App\Http\Resources\WorkHour\UpdateWorkResource;

class UpdateWorkHourJsonPresenter implements UpdateWorkHourOutputPort
{
    public function workHourUpdate(UpdateWorkHourResponseModel $model): ViewModel
    {
        return new JsonResourceViewModel(
            new UpdateWorkResource()
        );
    }

    public function workHourNotExists(UpdateWorkHourResponseModel $model): ViewModel
    {
        return new JsonResourceViewModel(
            new UpdateWorkNotExistsResource()
        );
    }

    public function unableToUpdateWorkHour(UpdateWorkHourResponseModel $model, \Throwable $e): ViewModel
    {
        if (config('app.debug')) {
            // rethrow and let Laravel display the error
            throw $e;
        }

        return new JsonResourceViewModel(
            new UnableToUpdateWorkHourResource($e)
        );
    }
}