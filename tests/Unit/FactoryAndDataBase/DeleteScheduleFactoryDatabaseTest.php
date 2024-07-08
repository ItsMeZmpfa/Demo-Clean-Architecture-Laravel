<?php

    namespace FactoryAndDataBase;

    use App\Domain\Interfaces\Schedule\ScheduleEntity;
    use App\Domain\Interfaces\User\UserEntity;
    use App\Domain\Interfaces\WorkHour\WorkHourEntity;
    use App\Domain\UseCases\DeleteSchedule\DeleteScheduleResponseModel;
    use App\Factories\Schedule\ScheduleModelFactory;
    use App\Models\EmailValueObject;
    use App\Models\PasswordValueObject;
    use App\Models\TimeValueObject;
    use App\Repositories\Schedule\ScheduleDatabaseRepository;
    use App\Repositories\User\UserDatabaseRepository;
    use App\Repositories\WorkHour\WorkHourDatabaseRepository;
    use Illuminate\Foundation\Testing\RefreshDatabase;
    use Mockery;
    use Tests\ManipulatesConfig;
    use Tests\ProvidesDeleteSchedules;
    use Tests\TestCase;

    class DeleteScheduleFactoryDatabaseTest extends TestCase
    {
        use RefreshDatabase;
        use ProvidesDeleteSchedules;
        use ManipulatesConfig;

        /**
         * @test
         * @dataProvider scheduleDeleteDataProvider
         */
        public function testDatabaseRepository(array $data)
        {

            $userMock = $this->mockUser([
                'name' => "Test User",
                'email' => "test.user@example.com",
                'password' => "Test12341234",
            ]);

            $repository = new UserDatabaseRepository();
            $user = $repository->create($userMock, new PasswordValueObject("Test12341234"));

            $scheduleMock = $this->mockSchedule([
                'user_id' => $user->id,
                'date' => "2000-12-12 00:00:00",
            ]);

            $workHourMock = $this->mockWorkHour([
                'startTime' => "2000-12-12 08:00:00",
                'endTime' => "2000-12-12 15:00:00",
            ]);

            $repositorySchedule = new ScheduleDatabaseRepository();
            $repositoryWorkHour = new WorkHourDatabaseRepository();

            $schedule = $repositorySchedule->createSchedule($scheduleMock);
            $workHour = $repositoryWorkHour->createWorkHour($workHourMock, $schedule->getScheduleId());

            $this->assertTrue($schedule->exists);
            $this->assertTrue($workHour->exists);

            $data['user_id'] = $user->id;
            $scheduleDeleteMock = $this->mockSchedule($data);
            $scheduleDelete = $repositorySchedule->deleteSchedule($scheduleDeleteMock);

            $this->assertTrue($scheduleDelete);


        }

        private function mockUser(array $data): UserEntity
        {
            return tap(Mockery::mock(UserEntity::class), function ($mock) use ($data) {
                $mock
                    ->shouldReceive('getUserName')->andReturn($data['name'])
                    ->shouldReceive('getUserEmail')->andReturn(new EmailValueObject($data['email']))
                    ->shouldNotReceive('getUserPassword');
            });
        }

        private function mockSchedule(array $data): ScheduleEntity
        {
            return tap(Mockery::mock(ScheduleEntity::class), function ($mock) use ($data) {
                $mock
                    ->shouldReceive('getUserIdSchedule')->andReturn($data['user_id'])
                    ->shouldReceive('getScheduleDate')->andReturn(new TimeValueObject($data['date']));
            });
        }

        private function mockWorkHour(array $data): WorkHourEntity
        {
            return tap(Mockery::mock(WorkHourEntity::class), function ($mock) use ($data) {
                $mock
                    ->shouldReceive('getWorkHourStartTime')->andReturn(new TimeValueObject($data['startTime']))
                    ->shouldReceive('getWorkHourEndTime')->andReturn(new TimeValueObject($data['endTime']));
            });
        }

        /**
         * @test
         * @dataProvider scheduleDeleteDataProvider
         */
        public function testModelFactory(array $data)
        {
            $factorySchedule = new ScheduleModelFactory();

            $schedule = $factorySchedule->makeSchedule($data);


            $this->assertScheduleMatches($data, $schedule);

        }

        private function mockDeleteScheduleResponseModel(ScheduleEntity $schedule): DeleteScheduleResponseModel
        {
            return tap(Mockery::mock(DeleteScheduleResponseModel::class), function ($mock) use ($schedule) {
                $mock
                    ->shouldReceive('getStatusOfDelete');

            });
        }

    }
