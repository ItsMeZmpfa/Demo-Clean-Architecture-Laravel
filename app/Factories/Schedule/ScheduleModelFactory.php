<?php

    namespace App\Factories\Schedule;

    use App\Domain\Interfaces\Schedule\ScheduleEntity;
    use App\Domain\Interfaces\Schedule\ScheduleFactory;
    use App\Models\Schedule;
    use App\Models\TimeValueObject;

    class ScheduleModelFactory implements ScheduleFactory
    {
        public function makeSchedule(array $attributes = []): ScheduleEntity
        {
            if (isset($attributes['date']) && is_string($attributes['date'])) {
                $attributes['date'] = new TimeValueObject($attributes['date']);
            }
            return new Schedule($attributes);
        }
    }
