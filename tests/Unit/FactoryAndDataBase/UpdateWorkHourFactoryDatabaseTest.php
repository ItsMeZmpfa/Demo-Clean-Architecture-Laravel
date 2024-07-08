<?php

    namespace FactoryAndDataBase;

    use App\Domain\Interfaces\Schedule\ScheduleEntity;
    use App\Domain\Interfaces\User\UserEntity;
    use App\Domain\Interfaces\WorkHour\WorkHourEntity;
    use App\Domain\UseCases\UpdateWorkHour\UpdateWorkHourResponseModel;
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
    use Tests\ProvidesWorkHour;
    use Tests\TestCase;

    class UpdateWorkHourFactoryDatabaseTest extends TestCase
    {
        use RefreshDatabase;
        use ProvidesWorkHour;
        use ManipulatesConfig;

        /**
         * @test
         * @dataProvider workHourNewDataProvider
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

            $repositorySchedule = new ScheduleDatabaseRepository();

            $schedule = $repositorySchedule->createSchedule($scheduleMock);

            $data['oldData']['scheduleId'] = $schedule->id;
            $data['newData']['scheduleId'] = $schedule->id;

            $workHourMock = $this->mockWorkHour($data['oldData']);
            $repositoryWorkHour = new WorkHourDatabaseRepository();

            $workHour = $repositoryWorkHour->createWorkHour($workHourMock, $schedule->getScheduleId());

            $this->assertTrue($schedule->exists);
            $this->assertTrue($workHour->exists);

            $updateWorkHourMock = $this->mockWorkHour($data['newData']);
            $updateWorkHour = $repositoryWorkHour->updateWorkHour($updateWorkHourMock);

            $this->checkWorkHourIsUpdate($updateWorkHour);

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
                    ->shouldReceive('getWorkHourScheduleId')->andReturn($data['scheduleId'])
                    ->shouldReceive('getWorkHourStartTime')->andReturn(new TimeValueObject($data['startTime']))
                    ->shouldReceive('getWorkHourEndTime')->andReturn(new TimeValueObject($data['endTime']));
            });
        }

        /**
         * @test
         * @dataProvider workHourNewDataProvider
         */
        public function testModelFactory(array $data)
        {
            $factoryWorkHour = new WorkHourModelFactory();

            $workHour = $factoryWorkHour->makeWorkHour($data['newData']);

            $this->assertWorkHourMatchesNewData($data['newData'], $workHour);
        }

        private function mockUpdateWorkHourResponseModel(WorkHourEntity $workHour): UpdateWorkHourResponseModel
        {
            return tap(Mockery::mock(UpdateWorkHourResponseModel::class), function ($mock) use ($workHour) {
                $mock
                    ->shouldReceive('getUpdateWorkHour')
                    ->andReturn(true);
            });
        }

    }
