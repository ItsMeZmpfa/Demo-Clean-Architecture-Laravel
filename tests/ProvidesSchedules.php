<?php

    namespace Tests;

    use App\Domain\Interfaces\Schedule\ScheduleEntity;
    use App\Domain\Interfaces\WorkHour\WorkHourEntity;
    use App\Models\TimeValueObject;

    trait ProvidesSchedules
    {
        public static function scheduleDataProvider(): array
        {
            return [
                'Test Schedule' => [
                    'data' => [
                        'user_id' => 1,
                        'date' => "2000-12-12 00:00:00",
                        'startTime' => "2000-12-12 08:00:00",
                        'endTime' => "2000-12-12 15:00:00",
                    ],
                ],
            ];
        }


        public static function schedulewithUserDataProvider(): array
        {
            return [
                'Test Schedule' => [
                    'data' => [
                        'dataSchedule' => [
                            'user_id' => 1,
                            'date' => "2000-12-12 00:00:00",
                        ],
                        'dataWorkHour' => [
                            'startTime' => "2000-12-12 08:00:00",
                            'endTime' => "2000-12-12 15:00:00",
                        ],
                        'dataDelete' => [
                            'user_id' => 1,
                            'date' => "2000-12-12 00:00:00",
                        ],
                    ],
                ],
            ];
        }

        public static function schedulewithScheduleEmptyTestData(): array
        {
            return [
                'Test Schedule' => [
                    'data' => [
                        'dataSchedule' => [
                            'user_id' => 1,
                            'date' => "2000-12-12 00:00:00",
                        ],
                        'dataWorkHour' => [
                            'startTime' => "2000-12-12 08:00:00",
                            'endTime' => "2000-12-12 15:00:00",
                        ],
                        'dataDelete' => [
                            'user_id' => 1,
                            'date' => "546546 45656",
                        ],
                    ],
                ],
            ];
        }

        public static function schedulewithUserDataProviderUpdate(): array
        {
            return [
                'Test Schedule' => [
                    'data' => [
                        'dataSchedule' => [
                            'user_id' => 1,
                            'date' => "2000-12-12 00:00:00",
                        ],
                        'dataWorkHour' => [
                            'startTime' => "2000-12-12 08:00:00",
                            'endTime' => "2000-12-12 15:00:00",
                        ],
                        'dataUpdate' => [
                            'scheduleId' => 1,
                            'startTime' => "2000-12-12 00:00:00",
                            'endTime' => "2000-12-12 00:00:00",
                        ],
                    ],
                ],
            ];
        }


        public function assertScheduleMatches(array $data, ScheduleEntity $schedule)
        {

            $this->assertTrue($schedule->getScheduleDate()->isEqualTo(new TimeValueObject($data['date'])));
        }

        public function assertWorkHourMatches(array $data, WorkHourEntity $workHour)
        {

            $this->assertTrue($workHour->getWorkHourStartTime()->isEqualTo(new TimeValueObject($data['startTime'])));
            $this->assertTrue($workHour->getWorkHourEndTime()->isEqualTo(new TimeValueObject($data['endTime'])));
        }
    }
