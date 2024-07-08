<?php

    namespace FactoryAndDataBase;

    use App\Domain\Interfaces\Schedule\ScheduleEntity;
    use App\Domain\Interfaces\User\UserEntity;
    use App\Domain\Interfaces\WorkHour\WorkHourEntity;
    use App\Domain\UseCases\CreateNewSchedule\CreateNewScheduleResponseModel;
    use App\Factories\Schedule\ScheduleModelFactory;
    use App\Factories\WorkHour\WorkHourModelFactory;
    use App\Models\EmailValueObject;
    use App\Models\PasswordValueObject;
    use App\Models\TimeValueObject;
    use App\Repositories\Schedule\ScheduleDatabaseRepository;
    use App\Repositories\User\UserDatabaseRepository;
    use App\Repositories\WorkHour\WorkHourDatabaseRepository;
    use Illuminate\Foundation\Testing\RefreshDatabase;
    use Mockery;
    use Tests\ManipulatesConfig;
    use Tests\ProvidesSchedules;
    use Tests\TestCase;

    class CreateNewScheduleFactoryDatabaseTest extends TestCase
    {
        use RefreshDatabase;
        use ProvidesSchedules;
        use ManipulatesConfig;


        /**
         * @test
         * @dataProvider scheduleDataProvider
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

            $data['user_id'] = $user->id;
            $scheduleMock = $this->mockSchedule($data);
            $workHourMock = $this->mockWorkHour($data);

            $repositorySchedule = new ScheduleDatabaseRepository();
            $repositoryWorkHour = new WorkHourDatabaseRepository();

            $schedule = $repositorySchedule->createSchedule($scheduleMock);
            $workHour = $repositoryWorkHour->createWorkHour($workHourMock, $schedule->getScheduleId());

            $this->assertTrue($schedule->exists);

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
         * @dataProvider schedulewithUserDataProvider
         */
        public function testModelFactory(array $data)
        {
            $factorySchedule = new ScheduleModelFactory();
            $factoryWorkHour = new WorkHourModelFactory();

            $schedule = $factorySchedule->makeSchedule($data['dataSchedule']);
            $workHour = $factoryWorkHour->makeWorkHour($data['dataWorkHour']);

            $this->assertScheduleMatches($data['dataSchedule'], $schedule);
            $this->assertWorkHourMatches($data['dataWorkHour'], $workHour);
        }

        /**
         * @test
         * @dataProvider scheduleDataProvider
         */

        private function mockCreateNewScheduleResponseModel(
            ScheduleEntity $schedule,
            WorkHourEntity $workHour,
        ): CreateNewScheduleResponseModel {
            return tap(Mockery::mock(CreateNewScheduleResponseModel::class),
                function ($mock) use ($schedule, $workHour) {
                    $mock
                        ->shouldReceive('getSchedule')
                        ->andReturn($schedule);

                    $mock
                        ->shouldReceive('getWorkHour')
                        ->andReturn($workHour);
                });
        }

    }
