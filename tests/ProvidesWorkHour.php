<?php

    namespace Tests;

    use App\Domain\Interfaces\WorkHour\WorkHourEntity;
    use App\Models\TimeValueObject;

    trait ProvidesWorkHour
    {
        public static function workHourDataProvider(): array
        {
            return [
                'Test WorkHour' => [
                    'data' => [
                        'scheduleId' => 1,
                        'startTime' => "2000-12-12 08:00:00",
                        'endTime' => "2000-12-12 15:00:00",
                    ],
                ],
            ];
        }

        public static function workHourNewDataProvider(): array
        {
            return [
                'Test WorkHour' => [
                    'data' => [
                        'oldData' => [
                            'scheduleId' => 1,
                            'startTime' => "2000-12-12 08:00:00",
                            'endTime' => "2000-12-12 15:00:00",
                        ],
                        'newData' => [
                            'scheduleId' => 1,
                            'startTime' => "2011-03-03 04:00:00",
                            'endTime' => "2011-03-03 13:00:00",
                        ],
                    ],
                ],
            ];
        }

        public function assertWorkHourMatches(array $data, $workHour)
        {

            $this->assertFalse(new TimeValueObject($data['startTime']) == $workHour->getWorkHourStartTime());
            $this->assertFalse(new TimeValueObject($data['endTime']) == $workHour->getWorkHourEndTime());
        }

        public function checkWorkHourIsUpdate(bool $changeStatus)
        {
            $this->assertTrue($changeStatus);
        }

        public function checkWorkHourIsNotUpdate(bool $changeStatus)
        {
            $this->assertFalse($changeStatus);
        }

        public function assertWorkHourMatchesNewData(array $data, WorkHourEntity $workHour)
        {
            $this->assertTrue(new TimeValueObject($data['startTime']) == $workHour->getWorkHourStartTime());
            $this->assertTrue(new TimeValueObject($data['endTime']) == $workHour->getWorkHourEndTime());
        }

    }
