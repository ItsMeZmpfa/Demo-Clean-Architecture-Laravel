<?php

namespace App\Adapters\Presenters\Schedule\DeleteSchedule;

use App\Adapters\ViewModels\JsonResourceViewModel;
use App\Domain\Interfaces\ViewModel;
use App\Domain\UseCases\DeleteSchedule\DeleteScheduleOutputPort;
use App\Domain\UseCases\DeleteSchedule\DeleteScheduleResponseModel;
use App\Http\Resources\Schedule\UnableToDeleteScheduleResource;
use App\Http\Resources\Schedule\ScheduleNotExistsResource;
use App\Http\Resources\Schedule\DeleteScheduleResource;

class DeleteScheduleJsonPresenter implements DeleteScheduleOutputPort
{
    public function scheduleDelete(DeleteScheduleResponseModel $model): ViewModel
    {
        return new JsonResourceViewModel(
            new DeleteScheduleResource()
        );
    }

    public function scheduleNotExists(DeleteScheduleResponseModel $model): ViewModel
    {
        return new JsonResourceViewModel(
            new ScheduleNotExistsResource()
        );
    }

    public function unableToDeleteSchedule( \Throwable $e): ViewModel
    {
        if (config('app.debug')) {
            // rethrow and let Laravel display the error
            throw $e;
        }

        return new JsonResourceViewModel(
            new UnableToDeleteScheduleResource($e)
        );
    }
}