<?php

    namespace Tests;

    use App\Domain\Interfaces\Schedule\ScheduleEntity;
    use App\Models\TimeValueObject;

    trait ProvidesDeleteSchedules
    {
        public static function scheduleDeleteDataProvider(): array
        {
            return [
                'Test Schedule' => [
                    'data' => [
                        'user_id' => 1,
                        'date' => "2000-12-12 00:00:00",
                    ],
                ],
            ];
        }

        public function assertScheduleEmpty(array $data, bool $schedule)
        {
            $this->assertFalse($schedule);
        }

        public function assertScheduleNotEmpty(array $data, bool $schedule)
        {
            $this->assertTrue($schedule);
        }

        public function assertScheduleMatches(array $data, ScheduleEntity $schedule)
        {

            $this->assertTrue($schedule->getScheduleDate()->isEqualTo(new TimeValueObject($data['date'])));
        }

    }
