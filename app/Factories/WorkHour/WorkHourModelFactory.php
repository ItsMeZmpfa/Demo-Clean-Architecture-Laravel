<?php

namespace App\Factories\WorkHour;

use App\Models\WorkHour;
use App\Domain\Interfaces\WorkHour\WorkHourEntity;
use App\Domain\Interfaces\WorkHour\WorkHourFactory;
use App\Models\TimeValueObject;

class WorkHourModelFactory implements WorkHourFactory
{
    public function makeWorkHour(array $attributes = []): WorkHourEntity
    {
        if (isset($attributes['startTime']) && is_string($attributes['startTime'])) {
            $attributes['startTime'] = new TimeValueObject($attributes['startTime']);
        }

        if (isset($attributes['endTime']) && is_string($attributes['endTime'])) {
            $attributes['endTime'] = new TimeValueObject($attributes['endTime']);
        }

        return new WorkHour($attributes);
    }
}