<?php

namespace App\Adapters\Presenters\Schedule\CreateSchedule;

use App\Adapters\ViewModels\JsonResourceViewModel;
use App\Domain\Interfaces\ViewModel;
use App\Domain\UseCases\CreateNewSchedule\CreateNewScheduleOutputPort;
use App\Domain\UseCases\CreateNewSchedule\CreateNewScheduleResponseModel;
use App\Http\Resources\Schedule\ScheduleAlreadyExistsResource;
use App\Http\Resources\Schedule\ScheduleCreatedResource;
use App\Http\Resources\Schedule\UnableToCreateScheduleResource;
use App\Http\Resources\User\UserNotFoundResource;
use App\Http\Resources\WorkHour\WorkHourAlreadyExistsResource;
use Throwable;

class CreateNewScheduleJsonPresenter implements CreateNewScheduleOutputPort
{
    public function scheduleCreated(CreateNewScheduleResponseModel $model): ViewModel
    {
        return new JsonResourceViewModel(
            new ScheduleCreatedResource()
        );
    }

    public function scheduleAlreadyExists(CreateNewScheduleResponseModel $model): ViewModel
    {
        return new JsonResourceViewModel(
            new ScheduleAlreadyExistsResource()
        );
    }

    public function workHourAlreadyExists(CreateNewScheduleResponseModel $model): ViewModel
    {
        return new JsonResourceViewModel(
            new WorkHourAlreadyExistsResource()
        );
    }

    public function unableToCreateSchedule(Throwable $e): ViewModel
    {
        if (config('app.debug')) {
            // rethrow and let Laravel display the error
            throw $e;
        }

        return new JsonResourceViewModel(
            new UnableToCreateScheduleResource($e)
        );
    }

    public function userNotExists(CreateNewScheduleResponseModel $model): ViewModel
    {
        return new JsonResourceViewModel(
            new UserNotFoundResource()
        );
    }
}
